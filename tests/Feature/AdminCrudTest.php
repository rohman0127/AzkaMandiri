<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Testimonial;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        $this->admin = User::first();
    }

    public function test_admin_can_crud_service_category(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.service-categories.store'), [
            'name' => 'Kanopi & Fasad Spesial',
            'slug' => 'kanopi-fasad-spesial',
            'description' => 'Pengerjaan kanopi kaca tempered dan fasad modern.',
            'sort_order' => 10,
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.service-categories.index'));
        $this->assertDatabaseHas('service_categories', [
            'name' => 'Kanopi & Fasad Spesial',
            'slug' => 'kanopi-fasad-spesial',
        ]);

        $category = ServiceCategory::where('slug', 'kanopi-fasad-spesial')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.service-categories.update', $category->id), [
            'name' => 'Kanopi & Fasad Modern Super',
            'slug' => 'kanopi-fasad-modern-super',
            'description' => 'Pengerjaan kanopi updated.',
            'sort_order' => 5,
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.service-categories.index'));
        $this->assertDatabaseHas('service_categories', [
            'name' => 'Kanopi & Fasad Modern Super',
            'slug' => 'kanopi-fasad-modern-super',
            'sort_order' => 5,
        ]);

        // 3. Delete
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.service-categories.destroy', $category->id));
        $delResponse->assertRedirect(route('admin.service-categories.index'));
        $this->assertDatabaseMissing('service_categories', ['id' => $category->id]);
    }

    public function test_admin_can_crud_portfolio_category(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.portfolio-categories.store'), [
            'name' => 'Hotel & Hospitality',
            'slug' => 'hotel-hospitality',
            'description' => 'Proyek kaca untuk hotel dan villa.',
            'sort_order' => 7,
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.portfolio-categories.index'));
        $this->assertDatabaseHas('portfolio_categories', [
            'name' => 'Hotel & Hospitality',
            'slug' => 'hotel-hospitality',
        ]);

        $cat = PortfolioCategory::where('slug', 'hotel-hospitality')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.portfolio-categories.update', $cat->id), [
            'name' => 'Hotel & Resort Mewah',
            'slug' => 'hotel-resort-mewah',
            'description' => 'Updated hotel desc.',
            'sort_order' => 3,
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.portfolio-categories.index'));
        $this->assertDatabaseHas('portfolio_categories', [
            'name' => 'Hotel & Resort Mewah',
            'slug' => 'hotel-resort-mewah',
        ]);

        // 3. Delete
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.portfolio-categories.destroy', $cat->id));
        $delResponse->assertRedirect(route('admin.portfolio-categories.index'));
        $this->assertDatabaseMissing('portfolio_categories', ['id' => $cat->id]);
    }

    public function test_admin_can_crud_article_category(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.article-categories.store'), [
            'name' => 'Arsitektur & Estetika',
            'slug' => 'arsitektur-estetika',
            'description' => 'Panduan estetika fasad kaca.',
            'sort_order' => 4,
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.article-categories.index'));
        $this->assertDatabaseHas('article_categories', [
            'name' => 'Arsitektur & Estetika',
            'slug' => 'arsitektur-estetika',
        ]);

        $cat = ArticleCategory::where('slug', 'arsitektur-estetika')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.article-categories.update', $cat->id), [
            'name' => 'Arsitektur Modern',
            'slug' => 'arsitektur-modern',
            'description' => 'Updated desc.',
            'sort_order' => 2,
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.article-categories.index'));
        $this->assertDatabaseHas('article_categories', [
            'name' => 'Arsitektur Modern',
        ]);

        // 3. Delete
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.article-categories.destroy', $cat->id));
        $delResponse->assertRedirect(route('admin.article-categories.index'));
        $this->assertDatabaseMissing('article_categories', ['id' => $cat->id]);
    }

    public function test_admin_can_crud_testimonial(): void
    {
        Storage::fake('public');

        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'client_name' => 'Bpk. Ridwan Hanif',
            'client_role' => 'Pemilik Rumah Tinggal, Bintaro',
            'content' => 'Pemasangan jendela sliding sangat rapi dan kedap suara.',
            'rating' => 5,
            'sort_order' => 1,
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', [
            'client_name' => 'Bpk. Ridwan Hanif',
            'rating' => 5,
        ]);

        $testimonial = Testimonial::where('client_name', 'Bpk. Ridwan Hanif')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.testimonials.update', $testimonial->id), [
            'client_name' => 'Bpk. Ridwan Hanif S.T.',
            'client_role' => 'Arsitek & Pemilik Rumah',
            'content' => 'Pemasangan luar biasa presisi.',
            'rating' => 5,
            'sort_order' => 2,
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', [
            'client_name' => 'Bpk. Ridwan Hanif S.T.',
        ]);

        // 3. Delete
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.testimonials.destroy', $testimonial->id));
        $delResponse->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_admin_can_create_and_update_service(): void
    {
        Storage::fake('public');

        $category = ServiceCategory::first();

        $createResponse = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'name' => 'Kaca Grafir Custom',
            'service_category_id' => $category->id,
            'excerpt' => 'Kaca motif grafir dekoratif seni tinggi.',
            'description' => 'Penjelasan lengkap kaca grafir...',
            'price_info' => 'Mulai Rp 350.000 / m2',
            'features' => "Motif Bunga\nKaca 8mm\nFinishing Halus",
            'is_active' => '1',
            'is_featured' => '1',
            'sort_order' => '15',
        ]);

        $createResponse->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', [
            'name' => 'Kaca Grafir Custom',
            'slug' => 'kaca-grafir-custom',
        ]);

        $service = Service::where('slug', 'kaca-grafir-custom')->first();

        // Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.services.update', $service->id), [
            'name' => 'Kaca Grafir Custom Premium',
            'service_category_id' => $category->id,
            'excerpt' => 'Updated excerpt...',
            'description' => 'Updated description...',
            'price_info' => 'Mulai Rp 400.000 / m2',
            'features' => "Motif Modern\nKaca 10mm",
            'is_active' => '1',
            'is_featured' => '0',
            'sort_order' => '12',
        ]);

        $updateResponse->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', [
            'name' => 'Kaca Grafir Custom Premium',
            'slug' => 'kaca-grafir-custom-premium',
            'sort_order' => 12,
        ]);

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service->id));
        $deleteResponse->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_admin_can_create_and_update_portfolio(): void
    {
        $category = PortfolioCategory::first();

        $response = $this->actingAs($this->admin)->post(route('admin.portfolios.store'), [
            'title' => 'Pemasangan Kanopi Villa Anyer',
            'portfolio_category_id' => $category->id,
            'client_name' => 'Bpk. Gunawan',
            'location' => 'Anyer, Banten',
            'completion_year' => '2026',
            'excerpt' => 'Kanopi kaca tepi pantai.',
            'description' => 'Deskripsi kanopi pantai...',
            'is_active' => '1',
            'is_featured' => '1',
            'sort_order' => '5',
        ]);

        $response->assertRedirect(route('admin.portfolios.index'));

        $this->assertDatabaseHas('portfolios', [
            'title' => 'Pemasangan Kanopi Villa Anyer',
            'slug' => 'pemasangan-kanopi-villa-anyer',
        ]);

        $portfolio = Portfolio::where('slug', 'pemasangan-kanopi-villa-anyer')->first();

        // Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.portfolios.update', $portfolio->id), [
            'title' => 'Pemasangan Kanopi Villa Anyer Resort',
            'portfolio_category_id' => $category->id,
            'client_name' => 'Bpk. Gunawan S.E.',
            'location' => 'Anyer, Banten',
            'completion_year' => '2026',
            'excerpt' => 'Updated excerpt...',
            'description' => 'Updated desc...',
            'is_active' => '1',
            'is_featured' => '1',
            'sort_order' => '3',
        ]);

        $updateResponse->assertRedirect(route('admin.portfolios.index'));
        $this->assertDatabaseHas('portfolios', [
            'title' => 'Pemasangan Kanopi Villa Anyer Resort',
        ]);

        // Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.portfolios.destroy', $portfolio->id));
        $deleteResponse->assertRedirect(route('admin.portfolios.index'));
        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
    }

    public function test_admin_can_crud_article(): void
    {
        $category = ArticleCategory::first();

        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => 'Tips Merawat Kaca Kamar Mandi',
            'article_category_id' => $category->id,
            'author_name' => 'Tim AzkaMandiri',
            'status' => 'published',
            'excerpt' => 'Cara membersihkan jamur dan kerak kaca tempered.',
            'content' => 'Langkah pertama gunakan cairan pembersih kaca non-asam...',
        ]);
        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'title' => 'Tips Merawat Kaca Kamar Mandi',
            'slug' => 'tips-merawat-kaca-kamar-mandi',
        ]);

        $article = Article::where('slug', 'tips-merawat-kaca-kamar-mandi')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.articles.update', $article->id), [
            'title' => 'Tips Merawat Kaca Kamar Mandi Anti Kerak',
            'article_category_id' => $category->id,
            'author_name' => 'Tim Teknis AzkaMandiri',
            'status' => 'published',
            'excerpt' => 'Updated excerpt...',
            'content' => 'Updated content...',
        ]);
        $updateResponse->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'title' => 'Tips Merawat Kaca Kamar Mandi Anti Kerak',
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.articles.destroy', $article->id));
        $deleteResponse->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_admin_can_crud_page(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.pages.store'), [
            'title' => 'Standar Mutu Instalasi',
            'slug' => 'standar-mutu-instalasi',
            'content' => 'AzkaMandiri menjamin seluruh material aluminium memiliki ketebalan presisi.',
            'meta_title' => 'Standar Mutu AzkaMandiri',
            'meta_description' => 'Kualitas aluminium dan kaca terjamin.',
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', [
            'title' => 'Standar Mutu Instalasi',
            'slug' => 'standar-mutu-instalasi',
        ]);

        $page = Page::where('slug', 'standar-mutu-instalasi')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.pages.update', $page->id), [
            'title' => 'Standar Mutu & Keamanan Instalasi',
            'slug' => 'standar-mutu-keamanan-instalasi',
            'content' => 'Konten diperbarui dengan sertifikasi K3.',
            'is_active' => '1',
        ]);
        $updateResponse->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseHas('pages', [
            'title' => 'Standar Mutu & Keamanan Instalasi',
        ]);

        // 3. Delete
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.pages.destroy', $page->id));
        $delResponse->assertRedirect(route('admin.pages.index'));
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function test_admin_can_manage_contact_messages(): void
    {
        $message = ContactMessage::create([
            'name' => 'Test User',
            'phone_number' => '081299998888',
            'subject' => 'Pertanyaan Proyek Ruko',
            'message' => 'Halo apakah ada diskon untuk ruko 3 lantai?',
            'status' => 'unread',
        ]);

        // Viewing detail marks it read
        $showResponse = $this->actingAs($this->admin)->get(route('admin.contact-messages.show', $message->id));
        $showResponse->assertStatus(200);
        $this->assertEquals('read', $message->fresh()->status);

        // Update status to followed_up
        $patchResponse = $this->actingAs($this->admin)->patch(route('admin.contact-messages.update-status', $message->id), [
            'status' => 'followed_up',
        ]);
        $patchResponse->assertRedirect();
        $this->assertEquals('followed_up', $message->fresh()->status);

        // Delete message
        $delResponse = $this->actingAs($this->admin)->delete(route('admin.contact-messages.destroy', $message->id));
        $delResponse->assertRedirect(route('admin.contact-messages.index'));
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_update_website_and_seo_settings(): void
    {
        $profileResponse = $this->actingAs($this->admin)->put(route('admin.settings.profile.update'), [
            'site_name' => 'AzkaMandiri Aluminium',
            'brand_title' => 'AzkaMandiri – Jasa Aluminium & Kaca Berkualitas',
            'whatsapp_number' => '6289988776655',
            'phone_number' => '+62 899-8877-6655',
            'email' => 'admin@azkamandiri.com',
            'address' => 'Jl. Baru No. 123, Tangerang',
        ]);

        $profileResponse->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'key' => 'site_name',
            'value' => 'AzkaMandiri Aluminium',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'whatsapp_number',
            'value' => '6289988776655',
        ]);

        // SEO Settings update
        $seoResponse = $this->actingAs($this->admin)->put(route('admin.settings.seo.update'), [
            'meta_title' => 'Spesialis Aluminium Tangerang Selatan',
            'meta_description' => 'Jasa aplikator kusen aluminium dan partisi kaca.',
            'meta_keywords' => 'kusen aluminium, partisi kaca, bsd, tangsel',
        ]);
        $seoResponse->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'key' => 'meta_title',
            'value' => 'Spesialis Aluminium Tangerang Selatan',
        ]);
    }

    public function test_admin_can_update_own_profile_and_password(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.profile.update'), [
            'name' => 'Super Administrator Azka',
            'email' => 'superadmin@azkamandiri.com',
            'current_password' => 'Password123!',
            'new_password' => 'NewSecret2026!',
            'new_password_confirmation' => 'NewSecret2026!',
        ]);

        $response->assertRedirect();

        $this->admin->refresh();
        $this->assertEquals('Super Administrator Azka', $this->admin->name);
        $this->assertEquals('superadmin@azkamandiri.com', $this->admin->email);
        $this->assertTrue(Hash::check('NewSecret2026!', $this->admin->password));
    }

    public function test_all_admin_modules_render_valid_edit_modal_data_items(): void
    {
        $routes = [
            'admin.services.index',
            'admin.service-categories.index',
            'admin.portfolios.index',
            'admin.portfolio-categories.index',
            'admin.articles.index',
            'admin.article-categories.index',
            'admin.testimonials.index',
            'admin.pages.index',
            'admin.contact-messages.index',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($this->admin)->get(route($routeName));
            $response->assertOk();

            $html = $response->getContent();
            
            // Extract all data-item attributes
            preg_match_all('/data-item="([^"]+)"/', $html, $matches);
            
            $this->assertNotEmpty($matches[1], "No data-item found in {$routeName}");

            foreach ($matches[1] as $encodedJson) {
                $decodedHtml = html_entity_decode($encodedJson, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $item = json_decode($decodedHtml, true);
                
                $this->assertNotNull($item, "Invalid JSON in data-item on {$routeName}: " . json_last_error_msg());
                $this->assertArrayHasKey('id', $item, "Item in {$routeName} missing 'id'");
                
                if ($routeName !== 'admin.contact-messages.index') {
                    $this->assertArrayHasKey('updateUrl', $item, "Item in {$routeName} missing 'updateUrl'");
                } else {
                    $this->assertArrayHasKey('updateStatusUrl', $item, "Item in {$routeName} missing 'updateStatusUrl'");
                }
            }
        }
    }
}
