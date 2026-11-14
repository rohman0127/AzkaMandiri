<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Solusi Aluminium & Kaca');
        $response->assertSee('AzkaMandiri');
    }

    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200);
        $response->assertSee('Tentang AzkaMandiri');
    }

    public function test_services_catalog_page_renders_and_filters(): void
    {
        $response = $this->get(route('services.index'));
        $response->assertStatus(200);
        $response->assertSee('Kusen Aluminium');

        $searchResponse = $this->get(route('services.index', ['q' => 'Kusen']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Kusen Aluminium');
    }

    public function test_service_detail_page_renders(): void
    {
        $service = Service::where('slug', 'kusen-aluminium')->first();
        $this->assertNotNull($service);

        $response = $this->get(route('services.show', $service->slug));
        $response->assertStatus(200);
        $response->assertSee($service->name);
        $response->assertSee('Konsultasi Layanan Ini via WhatsApp');
    }

    public function test_portfolios_catalog_page_renders(): void
    {
        $response = $this->get(route('portfolios.index'));
        $response->assertStatus(200);
        $response->assertSee('Portofolio Proyek AzkaMandiri');
    }

    public function test_portfolio_detail_page_renders(): void
    {
        $portfolio = Portfolio::first();
        $this->assertNotNull($portfolio);

        $response = $this->get(route('portfolios.show', $portfolio->slug));
        $response->assertStatus(200);
        $response->assertSee($portfolio->title);
    }

    public function test_articles_catalog_page_renders(): void
    {
        $response = $this->get(route('articles.index'));
        $response->assertStatus(200);
        $response->assertSee('Artikel & Inspirasi Arsitektur');
    }

    public function test_article_detail_page_renders_and_increments_views(): void
    {
        $article = Article::first();
        $this->assertNotNull($article);
        $initialViews = $article->views_count;

        $response = $this->get(route('articles.show', $article->slug));
        $response->assertStatus(200);
        $response->assertSee($article->title);

        $this->assertEquals($initialViews + 1, $article->fresh()->views_count);
    }

    public function test_contact_page_renders(): void
    {
        $response = $this->get(route('contact'));
        $response->assertStatus(200);
        $response->assertSee('Hubungi AzkaMandiri');
    }

    public function test_contact_form_submission_stores_message_in_database(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'phone_number' => '081234567899',
            'email' => 'budi@example.com',
            'subject' => 'Permintaan Penawaran Jendela Kantor',
            'message' => 'Halo tim AzkaMandiri, mohon informasi survei untuk 10 titik jendela sliding di kantor kami.',
        ];

        $response = $this->post(route('contact.submit'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'phone_number' => '081234567899',
            'subject' => 'Permintaan Penawaran Jendela Kantor',
            'status' => 'unread',
        ]);
    }

    public function test_contact_form_rejects_html_and_script_injection(): void
    {
        // 1. HTML tag in name
        $response1 = $this->post(route('contact.submit'), [
            'name' => '<script>alert("XSS")</script>',
            'phone_number' => '081234567899',
            'subject' => 'Konsultasi Pintu Kaca',
            'message' => 'Halo ini pesan biasa.',
        ]);
        $response1->assertSessionHasErrors(['name']);

        // 2. HTML tag in subject
        $response2 = $this->post(route('contact.submit'), [
            'name' => 'Ahmad Fauzi',
            'phone_number' => '081234567899',
            'subject' => 'Pintu Kaca <style>body{display:none}</style>',
            'message' => 'Halo ini pesan biasa.',
        ]);
        $response2->assertSessionHasErrors(['subject']);

        // 3. HTML tag in message
        $response3 = $this->post(route('contact.submit'), [
            'name' => 'Ahmad Fauzi',
            'phone_number' => '081234567899',
            'subject' => 'Pintu Kaca Sliding',
            'message' => 'Silakan klik <a href="http://malicious.com">disini</a> untuk melihat detailnya.',
        ]);
        $response3->assertSessionHasErrors(['message']);
    }

    public function test_contact_form_rejects_css_injection(): void
    {
        // CSS properties in message
        $response = $this->post(route('contact.submit'), [
            'name' => 'Hendro Setiawan',
            'phone_number' => '081234567899',
            'subject' => 'Konsultasi Kusen',
            'message' => 'Tolong buatkan penawaran dengan background-color: red; color: white;',
        ]);
        $response->assertSessionHasErrors(['message']);
    }

    public function test_contact_form_rejects_zip_and_dangerous_file_references(): void
    {
        // 1. ZIP file reference in message
        $response1 = $this->post(route('contact.submit'), [
            'name' => 'Rian Pratama',
            'phone_number' => '081234567899',
            'subject' => 'Spesifikasi Proyek BSD',
            'message' => 'Silakan unduh dokumen gambar kerja di blueprint.zip untuk ukuran detailnya.',
        ]);
        $response1->assertSessionHasErrors(['message']);

        // 2. EXE file reference in subject
        $response2 = $this->post(route('contact.submit'), [
            'name' => 'Rian Pratama',
            'phone_number' => '081234567899',
            'subject' => 'Download software_installer.exe',
            'message' => 'Halo tim silakan cek penawaran berikut untuk proyek gedung.',
        ]);
        $response2->assertSessionHasErrors(['subject']);

        // 3. PHP script reference in message
        $response3 = $this->post(route('contact.submit'), [
            'name' => 'Rian Pratama',
            'phone_number' => '081234567899',
            'subject' => 'Proyek Partisi Kaca',
            'message' => 'Silakan buka endpoint kami di webshell.php sekarang.',
        ]);
        $response3->assertSessionHasErrors(['message']);
    }

    public function test_contact_form_rejects_uploaded_files(): void
    {
        $fakeZip = \Illuminate\Http\UploadedFile::fake()->create('malicious.zip', 500, 'application/zip');

        $response = $this->post(route('contact.submit'), [
            'name' => 'Dimas Anggara',
            'phone_number' => '081234567899',
            'subject' => 'Proyek Kusen Aluminium BSD',
            'message' => 'Halo berikut ini lampiran berkas terkompresi dari kami.',
            'attachment' => $fakeZip,
        ]);

        $response->assertSessionHasErrors(['message']);
    }

    public function test_contact_form_rejects_bot_honeypot(): void
    {
        $response = $this->post(route('contact.submit'), [
            'name' => 'Spam Bot Automatic',
            'phone_number' => '081234567899',
            'subject' => 'Penawaran SEO Backlink',
            'message' => 'Kami menawarkan layanan promosi website untuk bisnis Anda.',
            'website_hp' => 'http://spam-link.ru',
        ]);

        $response->assertSessionHasErrors(['website_hp']);
    }

    public function test_contact_form_rejects_invalid_phone_number_and_name(): void
    {
        // Invalid name (numbers / symbols only)
        $response1 = $this->post(route('contact.submit'), [
            'name' => '12345678',
            'phone_number' => '081234567899',
            'subject' => 'Pemasangan Kanopi',
            'message' => 'Halo tim AzkaMandiri, mohon informasi survei kanopi kaca.',
        ]);
        $response1->assertSessionHasErrors(['name']);

        // Invalid phone number (letters, too short)
        $response2 = $this->post(route('contact.submit'), [
            'name' => 'Joko Susanto',
            'phone_number' => '0812ABCDEF',
            'subject' => 'Pemasangan Kanopi',
            'message' => 'Halo tim AzkaMandiri, mohon informasi survei kanopi kaca.',
        ]);
        $response2->assertSessionHasErrors(['phone_number']);
    }

    public function test_static_page_renders(): void
    {
        $response = $this->get(route('pages.show', 'kebijakan-privasi'));
        $response->assertStatus(200);
        $response->assertSee('Kebijakan Privasi');
    }

    public function test_sitemap_xml_renders(): void
    {
        $response = $this->get(route('seo.sitemap'));
        $response->assertStatus(200);
        $this->assertStringContainsString('<urlset', $response->getContent());
        $this->assertStringContainsString('kusen-aluminium', $response->getContent());
    }

    public function test_robots_txt_renders(): void
    {
        $response = $this->get(route('seo.robots'));
        $response->assertStatus(200);
        $this->assertStringContainsString('User-agent', $response->getContent());
        $this->assertStringContainsString('Sitemap:', $response->getContent());
    }
}

