<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\InventoryCategory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportAndDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
        $this->adminUser = User::where('email', 'admin@azkamandiri.com')->first();
    }

    public function test_dashboard_renders_with_highcharts_and_year_filter(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin?year=2026');

        $response->assertStatus(200);
        $response->assertSee('Executive Business Dashboard');
        $response->assertSee('highcharts-sales-container');
        $response->assertSee('highcharts-pie-container');
        $response->assertSee('highcharts-category-container');
        $response->assertSee('Ekspor Excel (.xlsx)');
        $response->assertSee('Cetak / PDF Resmi');
        $response->assertSee('2026');
    }

    public function test_dashboard_export_excel(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard/export/excel?year=2026');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_dashboard_export_pdf(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard/export/pdf?year=2026');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_pos_transactions_export_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/pos/transactions/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('No Invoice', $response->streamedContent());
    }

    public function test_products_export_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/inventory/products/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('ALU-KS3-BLK', $response->streamedContent());
    }

    public function test_purchases_export_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/purchases/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Nomor PO', $response->streamedContent());
    }

    public function test_customers_export_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/customers/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Hendra Gunawan', $response->streamedContent());
    }

    public function test_suppliers_export_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/suppliers/export');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Duta Aluminium', $response->streamedContent());
    }

    public function test_reports_sales_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/sales/csv');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $content = $response->streamedContent();
        $this->assertStringContainsString('AZKAMANDIRI', $content);
        $this->assertStringContainsString('REKAPITULASI PENJUALAN & KAS MASUK (POS)', $content);
        $this->assertStringContainsString('RINGKASAN KEUANGAN UTAMA', $content);
        $this->assertStringContainsString('DISTRIBUSI PENERIMAAN BERDASARKAN METODE BAYAR', $content);
        $this->assertStringContainsString('RINCIAN TRANSAKSI PERIODE TERPILIH', $content);
        $this->assertStringContainsString('TOTAL PERIODE', $content);
    }

    public function test_reports_sales_pdf(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/sales/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_reports_sales_excel(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/sales/excel');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_reports_profit_loss_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/profit-loss/csv');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('LAPORAN LABA RUGI', $response->streamedContent());
    }

    public function test_reports_stock_csv(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/stock/csv');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('ALU-KS3-BLK', $response->streamedContent());
    }

    public function test_reports_purchases_screen_loads(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/purchases');

        $response->assertStatus(200);
        $response->assertSee('Laporan Pembelian &amp; Restock', false);
        $response->assertSee('Total Pengeluaran Belanja');
        $response->assertSee('Total Material Masuk');
    }

    public function test_reports_purchases_pdf_download(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/purchases/pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_reports_purchases_excel(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/purchases/excel');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_reports_purchases_csv_export(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/reports/purchases/csv');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $content = $response->streamedContent();
        $this->assertStringContainsString('AZKAMANDIRI', $content);
        $this->assertStringContainsString('REKAPITULASI PEMBELIAN & RESTOCK BAHAN BAKU', $content);
        $this->assertStringContainsString('RINGKASAN PEMBELIAN & RESTOCK UTAMA', $content);
        $this->assertStringContainsString('DISTRIBUSI STATUS PEMBAYARAN FAKTUR', $content);
        $this->assertStringContainsString('RINCIAN FAKTUR PEMBELIAN & RESTOCK PERIODE TERPILIH', $content);
        $this->assertStringContainsString('TOTAL PERIODE', $content);
    }
}
