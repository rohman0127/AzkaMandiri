<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\InventoryCategory;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosInventoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::first();
    }

    public function test_admin_can_access_all_pos_and_inventory_pages(): void
    {
        $routes = [
            'admin.inventory.categories.index',
            'admin.inventory.units.index',
            'admin.inventory.products.index',
            'admin.inventory.stock-adjustments.index',
            'admin.suppliers.index',
            'admin.purchases.index',
            'admin.purchases.create',
            'admin.customers.index',
            'admin.pos.index',
            'admin.pos.transactions',
            'admin.reports.sales',
            'admin.reports.profit-loss',
            'admin.reports.stock',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($this->admin)->get(route($routeName));
            $response->assertStatus(200);
        }
    }

    public function test_admin_can_crud_unit_and_inventory_category(): void
    {
        // 1. Unit CRUD
        $unitResponse = $this->actingAs($this->admin)->post(route('admin.inventory.units.store'), [
            'name' => 'Karton Besar',
            'symbol' => 'ktn',
            'is_active' => '1',
        ]);
        $unitResponse->assertRedirect(route('admin.inventory.units.index'));
        $this->assertDatabaseHas('units', ['symbol' => 'ktn']);

        // 2. Category CRUD
        $catResponse = $this->actingAs($this->admin)->post(route('admin.inventory.categories.store'), [
            'name' => 'Fiting & Engsel Stainless',
            'description' => 'Aksesoris engsel pintu floor hinge & patch fitting',
            'is_active' => '1',
        ]);
        $catResponse->assertRedirect(route('admin.inventory.categories.index'));
        $this->assertDatabaseHas('inventory_categories', ['name' => 'Fiting & Engsel Stainless']);
    }

    public function test_admin_can_create_and_manage_product(): void
    {
        $category = InventoryCategory::first();
        $unit = Unit::first();

        $response = $this->actingAs($this->admin)->post(route('admin.inventory.products.store'), [
            'sku' => 'TEST-ALU-001',
            'barcode' => '899000111222',
            'name' => 'Aluminium Kusen 3 Inch Brown Anodize',
            'category_id' => $category->id,
            'unit_id' => $unit->id,
            'cost_price' => 125000,
            'price' => 175000,
            'stock' => 50,
            'min_stock' => 10,
            'rack_location' => 'Rak A-01',
            'type' => 'standard',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.inventory.products.index'));
        $this->assertDatabaseHas('products', [
            'sku' => 'TEST-ALU-001',
            'stock' => 50,
            'cost_price' => 125000,
            'price' => 175000,
        ]);
    }

    public function test_restock_purchase_increments_product_stock(): void
    {
        $supplier = Supplier::first();
        $product = Product::where('type', 'standard')->first();
        $initialStock = (float)$product->stock;
        $addedQty = 25;

        $response = $this->actingAs($this->admin)->post(route('admin.purchases.store'), [
            'invoice_number' => 'PO-SUPP-999',
            'supplier_id' => $supplier->id,
            'purchase_date' => now()->format('Y-m-d'),
            'payment_status' => 'paid',
            'notes' => 'Pembelian stok tambahan untuk workshop',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => $addedQty,
                    'unit_cost' => 120000,
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.purchases.index'));

        // Refresh product and assert stock increased
        $product->refresh();
        $this->assertEquals($initialStock + $addedQty, (float)$product->stock);

        $this->assertDatabaseHas('purchases', [
            'invoice_number' => 'PO-SUPP-999',
            'supplier_id' => $supplier->id,
        ]);
    }

    public function test_pos_checkout_validates_insufficient_stock(): void
    {
        $product = Product::where('type', 'standard')->first();
        $product->update(['stock' => 5]);

        // Attempting to buy 10 when only 5 exist
        $response = $this->actingAs($this->admin)->post(route('admin.pos.store'), [
            'order_type' => 'retail',
            'payment_type' => 'cash',
            'discount_amount' => 0,
            'paid_amount' => 1000000,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10,
                    'unit_price' => (float)$product->price,
                ],
            ],
        ]);

        $response->assertSessionHas('error');
        $product->refresh();
        $this->assertEquals(5, (float)$product->stock); // unchanged
    }

    public function test_pos_retail_checkout_decrements_stock_and_records_payment(): void
    {
        $product = Product::where('type', 'standard')->first();
        $product->update(['stock' => 30, 'price' => 100000, 'cost_price' => 70000]);

        $buyQty = 4;
        $unitPrice = 100000;
        $subtotal = $buyQty * $unitPrice; // 400.000
        $discount = 20000; // Total 380.000
        $paid = 400000; // Change 20.000

        $response = $this->actingAs($this->admin)->post(route('admin.pos.store'), [
            'order_type' => 'retail',
            'payment_type' => 'cash',
            'discount_amount' => $discount,
            'paid_amount' => $paid,
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => $buyQty,
                    'unit_price' => $unitPrice,
                ],
            ],
        ]);

        $product->refresh();
        $this->assertEquals(26, (float)$product->stock); // 30 - 4 = 26

        $latestTrx = Transaction::latest('id')->first();
        $this->assertNotNull($latestTrx);
        $this->assertEquals(400000, (float)$latestTrx->subtotal);
        $this->assertEquals(380000, (float)$latestTrx->total_amount);
        $this->assertEquals(380000, (float)$latestTrx->paid_amount);
        $this->assertEquals(20000, (float)$latestTrx->change_amount);
        $this->assertEquals('paid', $latestTrx->payment_status);

        $response->assertRedirect(route('admin.pos.show', $latestTrx->id));
    }

    public function test_pos_custom_project_partial_payment_and_installment_settlement(): void
    {
        $customer = Customer::first();
        $product = Product::where('type', 'custom_service')->first() ?? Product::first();

        // 1. Initial order with Down Payment (DP)
        $totalOrder = 5000000;
        $dpAmount = 2000000;

        $response = $this->actingAs($this->admin)->post(route('admin.pos.store'), [
            'customer_id' => $customer->id,
            'order_type' => 'project_custom',
            'payment_type' => 'transfer',
            'discount_amount' => 0,
            'paid_amount' => $dpAmount,
            'due_date' => now()->addDays(14)->format('Y-m-d'),
            'notes' => 'Proyek Partisi Kaca Kantor Lt 2',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'unit_price' => $totalOrder,
                    'specification' => 'Kaca Tempered 10mm Clear Frameless 3x2.5m',
                ],
            ],
        ]);

        $trx = Transaction::latest('id')->first();
        $this->assertNotNull($trx);
        $this->assertEquals('partial', $trx->payment_status);
        $this->assertEquals(3000000, (float)$trx->remaining_debt);

        // 2. Settle remaining debt via addPayment
        $settleResponse = $this->actingAs($this->admin)->post(route('admin.pos.add-payment', $trx->id), [
            'amount' => 3000000,
            'payment_type' => 'transfer',
            'reference_number' => 'BCA-TRF-889911',
            'notes' => 'Pelunasan 100% setelah serah terima terpasang',
        ]);

        $settleResponse->assertRedirect(route('admin.pos.show', $trx->id));

        $trx->refresh();
        $this->assertEquals('paid', $trx->payment_status);
        $this->assertEquals(5000000, (float)$trx->paid_amount);
        $this->assertEquals(0, (float)$trx->remaining_debt);
        $this->assertCount(2, $trx->payments); // DP + Settlement
    }

    public function test_stock_adjustment_opname_updates_product_inventory(): void
    {
        $product = Product::where('type', 'standard')->first();
        $initialStock = (float)$product->stock;
        $correction = 3; // 3 broken

        $response = $this->actingAs($this->admin)->post(route('admin.inventory.stock-adjustments.store'), [
            'product_id' => $product->id,
            'date' => now()->format('Y-m-d'),
            'type' => 'out',
            'quantity' => $correction,
            'reason' => 'damaged',
            'notes' => 'Profil aluminium tergores saat pemindahan gudang',
        ]);

        $response->assertRedirect(route('admin.inventory.stock-adjustments.index'));

        $product->refresh();
        $this->assertEquals($initialStock - $correction, (float)$product->stock);
    }

    public function test_receipt_views_and_invoice_pdf_generation(): void
    {
        $trx = Transaction::first();

        // 1. Thermal Receipt View
        $thermalResponse = $this->actingAs($this->admin)->get(route('admin.pos.thermal-receipt', $trx->id));
        $thermalResponse->assertStatus(200);
        $thermalResponse->assertSee($trx->invoice_code);
        $thermalResponse->assertSee('AZKA MANDIRI');

        // 2. Dompdf Invoice PDF
        $pdfResponse = $this->actingAs($this->admin)->get(route('admin.pos.invoice-pdf', $trx->id));
        $pdfResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $pdfResponse->headers->get('Content-Type'));
    }

    public function test_document_oriented_reports_pdf_generation(): void
    {
        // 1. Sales Report PDF
        $salesPdf = $this->actingAs($this->admin)->get(route('admin.reports.sales.pdf'));
        $salesPdf->assertStatus(200);
        $this->assertEquals('application/pdf', $salesPdf->headers->get('Content-Type'));

        // 2. Profit & Loss Report PDF
        $plPdf = $this->actingAs($this->admin)->get(route('admin.reports.profit-loss.pdf'));
        $plPdf->assertStatus(200);
        $this->assertEquals('application/pdf', $plPdf->headers->get('Content-Type'));

        // 3. Stock Valuation Report PDF
        $stockPdf = $this->actingAs($this->admin)->get(route('admin.reports.stock.pdf'));
        $stockPdf->assertStatus(200);
        $this->assertEquals('application/pdf', $stockPdf->headers->get('Content-Type'));
    }
}
