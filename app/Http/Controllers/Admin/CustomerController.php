<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('transactions')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15)->withQueryString();

        // Calculate total receivables (piutang) across customers
        $totalPiutang = \App\Models\Transaction::where('payment_status', '!=', 'paid')
            ->selectRaw('SUM(total_amount - paid_amount) as sisa')
            ->value('sisa') ?? 0;

        return view('admin.customers.index', compact('customers', 'totalPiutang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'company_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Customer::create($validated);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Pelanggan berhasil disimpan']);
        }

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        $customer->load(['transactions.items.product', 'transactions.payments']);

        $totalSpent = $customer->transactions->sum('total_amount');
        $totalPaid = $customer->transactions->sum('paid_amount');
        $sisaPiutang = max(0, $totalSpent - $totalPaid);

        return view('admin.customers.show', compact('customer', 'totalSpent', 'totalPaid', 'sisaPiutang'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'company_name' => 'nullable|string|max:150',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->transactions()->count() > 0) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi.');
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }

    /**
     * Export Customer Directory as CSV/Excel
     */
    public function exportCsv(Request $request)
    {
        $query = Customer::withCount('transactions')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->get();
        $filename = 'data-pelanggan-azkamandiri-' . date('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($customers) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'Nama Pelanggan',
                'Perusahaan / Proyek',
                'Nomor WhatsApp / Telepon',
                'Email',
                'Alamat Lengkap',
                'Total Transaksi Belanja',
                'Total Belanja (Rp)',
                'Status Akun',
            ]);

            $no = 1;
            foreach ($customers as $c) {
                $totalSpent = $c->transactions()->sum('total_amount');
                fputcsv($file, [
                    $no++,
                    $c->name,
                    $c->company_name ?: '-',
                    $c->phone ?: '-',
                    $c->email ?: '-',
                    $c->address ?: '-',
                    $c->transactions_count,
                    (float) $totalSpent,
                    $c->is_active ? 'Aktif' : 'Non-Aktif',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

