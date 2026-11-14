<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryCategory;
use App\Models\Product;
use App\Models\Unit;
use App\Traits\HandlesImageUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request)
    {
        $query = Product::with(['category', 'unit'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->get('stock_status') === 'low') {
            $query->whereColumn('stock', '<=', 'min_stock');
        } elseif ($request->get('stock_status') === 'out') {
            $query->where('stock', '<=', 0);
        }

        $products = $query->paginate(15)->withQueryString();
        $categories = InventoryCategory::where('is_active', true)->orderBy('name')->get();
        $units = Unit::where('is_active', true)->orderBy('name')->get();

        $totalProducts = Product::count();
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        return view('admin.inventory.products.index', compact(
            'products',
            'categories',
            'units',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku',
            'barcode' => 'nullable|string|max:50',
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:inventory_categories,id',
            'unit_id' => 'required|exists:units,id',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'rack_location' => 'nullable|string|max:100',
            'type' => 'required|in:standard,custom_service',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        Product::create($validated);

        return redirect()->route('admin.inventory.products.index')->with('success', 'Produk inventaris berhasil ditambahkan.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:50',
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:inventory_categories,id',
            'unit_id' => 'required|exists:units,id',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'min_stock' => 'required|numeric|min:0',
            'rack_location' => 'nullable|string|max:100',
            'type' => 'required|in:standard,custom_service',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $validated['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        $product->update($validated);

        return redirect()->route('admin.inventory.products.index')->with('success', 'Produk inventaris berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->transactionItems()->count() > 0 || $product->purchaseItems()->count() > 0) {
            return back()->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi atau pembelian.');
        }

        if ($product->image) {
            $this->deleteImage($product->image);
        }

        $product->delete();

        return redirect()->route('admin.inventory.products.index')->with('success', 'Produk berhasil dihapus dari inventaris.');
    }

    /**
     * Export Products Inventory as CSV/Excel
     */
    public function exportCsv(Request $request)
    {
        $query = Product::with(['category', 'unit'])->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->get('stock_status') === 'low') {
            $query->whereColumn('stock', '<=', 'min_stock');
        } elseif ($request->get('stock_status') === 'out') {
            $query->where('stock', '<=', 0);
        }

        $products = $query->get();
        $filename = 'daftar-produk-azkamandiri-' . date('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'No',
                'SKU / Kode Barang',
                'Barcode',
                'Nama Produk & Material',
                'Kategori',
                'Tipe',
                'Satuan',
                'Harga Modal / Beli (Rp)',
                'Harga Jual (Rp)',
                'Estimasi Margin (Rp)',
                'Stok Fisik',
                'Stok Minimum',
                'Lokasi Rak',
                'Status Stok',
                'Status Aktif',
            ]);

            $no = 1;
            foreach ($products as $p) {
                $margin = (float)$p->price - (float)$p->cost_price;
                $stockStatus = 'Aman';
                if ($p->type === 'standard') {
                    if ($p->stock <= 0) {
                        $stockStatus = 'Habis';
                    } elseif ($p->stock <= $p->min_stock) {
                        $stockStatus = 'Menipis';
                    }
                } else {
                    $stockStatus = 'Custom / Jasa (Tanpa Batas)';
                }

                fputcsv($file, [
                    $no++,
                    $p->sku,
                    $p->barcode ?: '-',
                    $p->name,
                    $p->category ? $p->category->name : 'Umum',
                    $p->type === 'standard' ? 'Barang Fisik' : 'Jasa / Custom',
                    $p->unit ? $p->unit->symbol : 'unit',
                    (float) $p->cost_price,
                    (float) $p->price,
                    $margin,
                    $p->type === 'standard' ? (float)$p->stock : '-',
                    $p->type === 'standard' ? (float)$p->min_stock : '-',
                    $p->rack_location ?: '-',
                    $stockStatus,
                    $p->is_active ? 'Aktif' : 'Non-Aktif',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

