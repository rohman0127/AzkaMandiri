<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdjustment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $query = StockAdjustment::with(['product.unit', 'user'])->latest('date');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('adjustment_code', 'like', "%{$search}%")
                  ->orWhereHas('product', function ($pq) use ($search) {
                      $pq->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        $adjustments = $query->paginate(15)->withQueryString();
        $products = Product::where('is_active', true)->with('unit')->orderBy('name')->get();

        return view('admin.inventory.stock-adjustments.index', compact('adjustments', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'date' => 'required|date',
            'type' => 'required|in:in,out',
            'quantity' => 'required|numeric|min:0.01',
            'reason' => 'required|in:stock_opname,damaged,project_usage,return,other',
            'notes' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::lockForUpdate()->find($validated['product_id']);

            if ($validated['type'] === 'out' && (float)$product->stock < (float)$validated['quantity']) {
                return back()->withInput()->with('error', "Stok saat ini ({$product->stock} {$product->unit->symbol}) tidak mencukupi untuk pengurangan sebesar {$validated['quantity']}.");
            }

            // Generate adjustment code
            $datePrefix = 'ADJ-' . date('Ym') . '-';
            $latest = StockAdjustment::where('adjustment_code', 'like', "{$datePrefix}%")
                ->orderBy('id', 'desc')
                ->first();

            $nextSeq = 1;
            if ($latest) {
                $parts = explode('-', $latest->adjustment_code);
                $lastSeq = end($parts);
                $nextSeq = intval($lastSeq) + 1;
            }
            $adjustmentCode = $datePrefix . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

            StockAdjustment::create([
                'adjustment_code' => $adjustmentCode,
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'date' => $validated['date'],
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'reason' => $validated['reason'],
                'notes' => $validated['notes'],
            ]);

            // Adjust stock
            if ($validated['type'] === 'in') {
                $product->increment('stock', $validated['quantity']);
            } else {
                $product->decrement('stock', $validated['quantity']);
            }

            DB::commit();

            return redirect()->route('admin.inventory.stock-adjustments.index')
                ->with('success', 'Penyesuaian stok berhasil dicatat dan stok fisik telah diselaraskan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses penyesuaian stok: ' . $e->getMessage());
        }
    }
}

