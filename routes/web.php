<?php

use App\Http\Controllers\Admin\ArticleCategoryController as AdminArticleCategoryController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\InventoryCategoryController as AdminInventoryCategoryController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PortfolioCategoryController as AdminPortfolioCategoryController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\PosController as AdminPosController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProfileSettingController as AdminProfileSettingController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SeoSettingController as AdminSeoSettingController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\StockAdjustmentController as AdminStockAdjustmentController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\UserProfileController as AdminUserProfileController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PortfolioController;
use App\Http\Controllers\Frontend\SeoController;
use App\Http\Controllers\Frontend\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about');
Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portofolio');
Route::get('/portofolio', [PortfolioController::class, 'index'])->name('portfolios.index');
Route::get('/portofolio/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'submit'])->middleware('throttle:10,1')->name('contact.submit');
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('pages.show');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Protected CMS Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export/excel', [AdminDashboardController::class, 'exportExcel'])->name('dashboard.export.excel');
    Route::get('/dashboard/export/pdf', [AdminDashboardController::class, 'exportPdf'])->name('dashboard.export.pdf');

    // Layanan
    Route::resource('services', AdminServiceController::class);
    Route::delete('services/gallery/{image}', [AdminServiceController::class, 'deleteGalleryImage'])->name('services.gallery.delete');
    Route::resource('service-categories', AdminServiceCategoryController::class);

    // Portofolio
    Route::resource('portfolios', AdminPortfolioController::class);
    Route::delete('portfolios/gallery/{image}', [AdminPortfolioController::class, 'deleteGalleryImage'])->name('portfolios.gallery.delete');
    Route::resource('portfolio-categories', AdminPortfolioCategoryController::class);

    // Artikel
    Route::resource('articles', AdminArticleController::class);
    Route::resource('article-categories', AdminArticleCategoryController::class);

    // Testimoni
    Route::resource('testimonials', AdminTestimonialController::class);

    // Pesan Masuk
    Route::get('contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::patch('contact-messages/{contactMessage}/status', [AdminContactMessageController::class, 'updateStatus'])->name('contact-messages.update-status');
    Route::delete('contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    Route::redirect('contacts', '/admin/contact-messages')->name('contacts');

    // Halaman Statis
    Route::resource('pages', AdminPageController::class);

    // Pengaturan
    Route::get('settings/profile', [AdminProfileSettingController::class, 'index'])->name('settings.profile');
    Route::put('settings/profile', [AdminProfileSettingController::class, 'update'])->name('settings.profile.update');
    Route::redirect('settings', '/admin/settings/profile')->name('settings');
    Route::redirect('settings/company', '/admin/pages')->name('settings.company');

    Route::get('settings/seo', [AdminSeoSettingController::class, 'index'])->name('settings.seo');
    Route::put('settings/seo', [AdminSeoSettingController::class, 'update'])->name('settings.seo.update');

    // Profil Admin (Akun)
    Route::get('profile', [AdminUserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminUserProfileController::class, 'update'])->name('profile.update');

    // ==========================================
    // MODUL POS & MANAJEMEN INVENTARIS
    // ==========================================

    // 1. Point of Sales (Kasir)
    Route::middleware(['permission:pos.access,pos.view_transactions'])->group(function () {
        Route::get('pos', [AdminPosController::class, 'index'])->name('pos.index');
        Route::post('pos/checkout', [AdminPosController::class, 'store'])->name('pos.store');
        Route::get('pos/transactions', [AdminPosController::class, 'transactions'])->name('pos.transactions');
        Route::get('pos/transactions/export', [AdminPosController::class, 'exportCsv'])->name('pos.transactions.export');
        Route::get('pos/transactions/{transaction}', [AdminPosController::class, 'show'])->name('pos.show');
        Route::post('pos/transactions/{transaction}/payments', [AdminPosController::class, 'addPayment'])->name('pos.add-payment');
        Route::get('pos/transactions/{transaction}/thermal', [AdminPosController::class, 'thermalReceipt'])->name('pos.thermal');
        Route::get('pos/transactions/{transaction}/thermal-receipt', [AdminPosController::class, 'thermalReceipt'])->name('pos.thermal-receipt');
        Route::get('pos/transactions/{transaction}/invoice', [AdminPosController::class, 'invoicePdf'])->name('pos.invoice');
        Route::get('pos/transactions/{transaction}/invoice-pdf', [AdminPosController::class, 'invoicePdf'])->name('pos.invoice-pdf');
    });

    // 2. Inventaris Produk & Material
    Route::middleware(['permission:products.view,inventory.categories,inventory.units,inventory.adjust_stock'])->group(function () {
        Route::get('inventory/products/export', [AdminProductController::class, 'exportCsv'])->name('inventory.products.export');
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::resource('products', AdminProductController::class);
            Route::resource('categories', AdminInventoryCategoryController::class);
            Route::resource('units', AdminUnitController::class);
            Route::resource('stock-adjustments', AdminStockAdjustmentController::class)->only(['index', 'store']);
        });

        // Alias URL langsung untuk inventaris
        Route::redirect('products', '/admin/inventory/products');
        Route::redirect('products/export', '/admin/inventory/products/export');
        Route::redirect('categories', '/admin/inventory/categories');
        Route::redirect('units', '/admin/inventory/units');
        Route::redirect('stock-adjustments', '/admin/inventory/stock-adjustments');
    });

    // 3. Supplier & Restock Pembelian
    Route::middleware(['permission:suppliers.view,purchases.view,purchases.create'])->group(function () {
        Route::get('suppliers/export', [AdminSupplierController::class, 'exportCsv'])->name('suppliers.export');
        Route::resource('suppliers', AdminSupplierController::class);
        Route::get('purchases/export', [AdminPurchaseController::class, 'exportCsv'])->name('purchases.export');
        Route::resource('purchases', AdminPurchaseController::class);
    });

    // 4. Pelanggan & Piutang
    Route::middleware(['permission:customers.view,customers.manage'])->group(function () {
        Route::get('customers/export', [AdminCustomerController::class, 'exportCsv'])->name('customers.export');
        Route::resource('customers', AdminCustomerController::class);
    });

    // 5. Laporan Keuangan & Stok
    Route::middleware(['permission:reports.sales,reports.purchases,reports.profit_loss,reports.stock'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('sales', [AdminReportController::class, 'sales'])->name('sales');
        Route::get('sales/pdf', [AdminReportController::class, 'salesPdf'])->name('sales.pdf');
        Route::get('sales/excel', [AdminReportController::class, 'salesExcel'])->name('sales.excel');
        Route::get('sales/csv', [AdminReportController::class, 'salesCsv'])->name('sales.csv');
        Route::get('purchases', [AdminReportController::class, 'purchases'])->name('purchases');
        Route::get('purchases/pdf', [AdminReportController::class, 'purchasesPdf'])->name('purchases.pdf');
        Route::get('purchases/excel', [AdminReportController::class, 'purchasesExcel'])->name('purchases.excel');
        Route::get('purchases/csv', [AdminReportController::class, 'purchasesCsv'])->name('purchases.csv');
        Route::get('profit-loss', [AdminReportController::class, 'profitLoss'])->name('profit-loss');
        Route::get('profit-loss/pdf', [AdminReportController::class, 'profitLossPdf'])->name('profit-loss.pdf');
        Route::get('profit-loss/csv', [AdminReportController::class, 'profitLossCsv'])->name('profit-loss.csv');
        Route::get('stock', [AdminReportController::class, 'stock'])->name('stock');
        Route::get('stock/pdf', [AdminReportController::class, 'stockPdf'])->name('stock.pdf');
        Route::get('stock/csv', [AdminReportController::class, 'stockCsv'])->name('stock.csv');
    });

    // 6. Manajemen Pengguna & Hak Akses (RBAC)
    Route::middleware(['permission:users.manage,users.view'])->group(function () {
        Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::resource('users', AdminUserController::class);
    });

    Route::middleware(['permission:roles.manage'])->group(function () {
        Route::resource('roles', AdminRoleController::class);
    });
});
