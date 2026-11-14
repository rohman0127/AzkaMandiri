<?php

use App\Http\Controllers\Admin\ArticleCategoryController as AdminArticleCategoryController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PortfolioCategoryController as AdminPortfolioCategoryController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ProfileSettingController as AdminProfileSettingController;
use App\Http\Controllers\Admin\SeoSettingController as AdminSeoSettingController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserProfileController as AdminUserProfileController;
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

    // Halaman Statis
    Route::resource('pages', AdminPageController::class);

    // Pengaturan
    Route::get('settings/profile', [AdminProfileSettingController::class, 'index'])->name('settings.profile');
    Route::put('settings/profile', [AdminProfileSettingController::class, 'update'])->name('settings.profile.update');

    Route::get('settings/seo', [AdminSeoSettingController::class, 'index'])->name('settings.seo');
    Route::put('settings/seo', [AdminSeoSettingController::class, 'update'])->name('settings.seo.update');

    // Profil Admin (Akun)
    Route::get('profile', [AdminUserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [AdminUserProfileController::class, 'update'])->name('profile.update');
});
