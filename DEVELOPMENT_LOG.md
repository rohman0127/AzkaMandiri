# AzkaMandiri – Development Implementation Log

Dokumen ini mencatat riwayat kronologis pengerjaan pengembangan aplikasi web **AzkaMandiri** dari Fase 1 hingga Fase 11, keputusan arsitektur yang diambil, tantangan teknis yang dihadapi, serta hasil verifikasi pengujian akhir.

---

## 1. Kronologi Pengerjaan (Fase 1 s/d Fase 11)

### Phase 1: Setup Lingkungan & Inisialisasi Proyek
- Inisialisasi framework Laravel versi **13.42.0** pada direktori `d:\JUALAN\azkamandiri laravel`.
- Konfigurasi koneksi basis data **MySQL 8.0+** pada port 3306 (database `azkamandiri` dan `azkamandiri_test`).
- Menjalankan `php artisan storage:link` untuk symlink direktori penyimpanan file upload.
- Menginstal dependensi frontend modern melalui NPM: `alpinejs`, `@tailwindcss/vite`, `lucide`, dan mengonfigurasi `resources/css/app.css` serta `resources/js/app.js`.

### Phase 2: Desain Aset Branding & Identitas Visual
- Merancang dan membuat aset vektor orisinal (SVG murni) di `public/assets/brand/`:
  - `logo-horizontal.svg` (kombinasi profil kusen aluminium modern & panel kaca transparan dengan tipografi presisi).
  - `logo-horizontal-dark.svg` (versi kontras tinggi untuk latar belakang gelap).
  - `logo-icon.svg` (monogram geometris inisial "A" dan "M").
  - `favicon.svg` (icon vektor tajam di seluruh resolusi layar).
- Palet warna yang diterapkan:
  - Primary Navy: `#172B4D`
  - Dark Navy: `#101D33`
  - Accent Gold: `#D6A84F`
  - Body Text: `#343A40`
  - Background Neutral: `#F8F9FA` & `#FFFFFF`
- Menghasilkan aset demo pengerjaan arsitektur berformat SVG beresolusi tinggi untuk 10 layanan, 6 portofolio, dan 4 artikel edukasi di direktori `public/assets/images/`.

### Phase 3: Perancangan Skema Database MySQL & Migrasi
- Membuat 10 berkas migrasi database relasional:
  1. `0001_01_01_000000_create_users_table.php` (tabel `users`, `password_reset_tokens`, `sessions`)
  2. `0001_01_01_000001_create_cache_table.php` (tabel `cache`, `cache_locks`)
  3. `0001_01_01_000002_create_jobs_table.php` (tabel `jobs`, `failed_jobs`)
  4. `2026_11_14_000001_create_settings_table.php` (tabel `settings`)
  5. `2026_11_14_000002_create_pages_table.php` (tabel `pages`)
  6. `2026_11_14_000003_create_service_categories_and_services_table.php` (tabel `service_categories`, `services`, `service_images`)
  7. `2026_11_14_000004_create_portfolio_categories_and_portfolios_table.php` (tabel `portfolio_categories`, `portfolios`, `portfolio_images`)
  8. `2026_11_14_000005_create_article_categories_and_articles_table.php` (tabel `article_categories`, `articles`)
  9. `2026_11_14_000006_create_testimonials_table.php` (tabel `testimonials`)
  10. `2026_11_14_000007_create_contact_messages_table.php` (tabel `contact_messages`)
- Seluruh tabel mengadopsi engine InnoDB dengan tipe data standar (seperti `JSON` untuk spesifikasi dan fitur layanan) dan deklarasi `ON DELETE CASCADE` pada foreign key.

### Phase 4: Eloquent Model & Database Seeder Komprehensif
- Membuat 11 Eloquent Model dengan relasi, casts (`array` untuk JSON), accessor, dan scopes:
  - `User`, `Setting`, `Page`, `ServiceCategory`, `Service`, `ServiceImage`, `PortfolioCategory`, `Portfolio`, `PortfolioImage`, `ArticleCategory`, `Article`, `Testimonial`, `ContactMessage`.
- Mengimplementasikan 9 database seeder:
  - `AdminUserSeeder`: Kredensial superadmin `admin@azkamandiri.com` / `Password123!`.
  - `SettingSeeder`: 16 parameter profil website, kontak WA, alamat workshop Tangerang Selatan, jam kerja, dan meta SEO.
  - `PageSeeder`: 3 dokumen legalitas (Syarat & Ketentuan, Kebijakan Privasi, Garansi Pekerjaan).
  - `ServiceSeeder`: 10 layanan komprehensif lengkap dengan spesifikasi teknis dan estimasi harga.
  - `PortfolioSeeder`: 6 proyek portofolio riil di kawasan BSD, Bintaro, Serpong, dan Jakarta Selatan.
  - `ArticleSeeder`: 4 artikel tips dan edukasi seputar aluminium & kaca.
  - `TestimonialSeeder`: 5 testimoni kepuasan klien pemilik hunian & kontraktor.
  - `ContactMessageSeeder`: Data contoh pesan masuk pelanggan.
  - `DatabaseSeeder`: Master seeder pemanggil seluruh seeder.

### Phase 5: Helper & Utility Layer
- Membuat `app/Helpers/WhatsAppHelper.php` untuk pembersihan nomor telepon (`cleanPhoneNumber`) dan penyusunan tautan chat WA otomatis berbasis konteks layanan atau portofolio.
- Mendaftarkan file global helper `app/helpers.php` pada `composer.json` autoload:
  - `setting($key, $default)`
  - `wa_link($message)`
  - `wa_service_link($serviceName)`
  - `wa_portfolio_link($portfolioTitle)`
- Membuat trait `App\Traits\HandlesImageUploads.php` untuk standardisasi upload berkas gambar dan penghapusan berkas lama saat update/delete.

### Phase 6: Subsystem Admin CMS (Controller & View CRUD)
- Mengembangkan 14 Admin Controllers di bawah namespace `App\Http\Controllers\Admin`:
  - `AuthController`: Login form, otentikasi kredensial, logout dengan invalidasi session.
  - `DashboardController`: Perhitungan ringkasan metrik dan agregasi pesan unread.
  - `ProfileSettingController` & `SeoSettingController`: Manajemen identitas usaha & SEO.
  - `ServiceCategoryController` & `ServiceController`: Manajemen produk & multi-foto galeri.
  - `PortfolioCategoryController` & `PortfolioController`: Manajemen portofolio proyek.
  - `ArticleCategoryController` & `ArticleController`: Manajemen artikel & publikasi.
  - `TestimonialController`: Manajemen ulasan & rating bintang.
  - `ContactMessageController`: Manajemen inbox pesan & update status.
  - `PageController`: Manajemen halaman informasi statis.
  - `UserProfileController`: Pembaruan profil & password admin.
- Merancang layout admin responsif `resources/views/layouts/admin.blade.php` dengan sidebar navigasi, header status user, flash alert notifikasi, dan konfirmasi modal hapus.
- Membangun seluruh views form input dan tabel data untuk 13 modul CMS.

### Phase 7: Subsystem Frontend Publik
- Mengembangkan 8 Frontend Controllers di bawah namespace `App\Http\Controllers\Frontend`:
  - `HomeController`, `AboutController`, `ServiceController`, `PortfolioController`, `ArticleController`, `ContactController`, `PageController`, `SeoController`.
- Membangun antarmuka layout publik `resources/views/layouts/app.blade.php`:
  - Top announcement strip informasi jam operasional dan kontak cepat.
  - Header navigasi modern dengan state sticky saat scroll.
  - Dynamic Meta Tags (Title, Description, Canonical, OG Tags, Twitter Card).
  - Schema.org `LocalBusiness` JSON-LD terstruktur.
  - Footer terperinci dengan logo, navigasi, alamat workshop, dan legal link.
  - Floating WhatsApp action button dengan pulse animation.
- Membangun view frontend berdesain mewah dan profesional:
  - `frontend/home.blade.php` (10 section lengkap dari hero sampai FAQ interaktif).
  - `frontend/about.blade.php` (Profil usaha, visi misi, legalitas, proses kerja).
  - `frontend/services/index.blade.php` & `show.blade.php` (Katalog & detail spesifikasi).
  - `frontend/portfolios/index.blade.php` & `show.blade.php` (Galeri proyek & rincian hasil kerja).
  - `frontend/articles/index.blade.php` & `show.blade.php` (Edukasi material & view counter).
  - `frontend/contact.blade.php` (Form kontak terhubung ke database dan kartu kontak).
  - `frontend/pages/show.blade.php` (Halaman statis kebijakan privasi & garansi).
  - `frontend/seo/sitemap.blade.php` (Sitemap XML dinamis).

### Phase 8: Integrasi Dynamic WhatsApp Conversion Funnel
- Menghubungkan setiap tombol CTA pada kartu layanan dan portofolio dengan pesan dinamis otomatis menyertakan nama item yang diminati pengguna.
- Menambahkan fitur balasan satu-klik via WhatsApp di modul inbox admin.

### Phase 9: Optimasi SEO, Sitemaps & Robots
- Rute `/sitemap.xml` merender XML dinamis berisi seluruh URL publik dengan header `Content-Type: application/xml`.
- Rute `/robots.txt` menyajikan konfigurasi perayap dengan header `Content-Type: text/plain`.

### Phase 10: Automated Testing & Verifikasi Kualitas
- Konfigurasi `phpunit.xml` untuk pengujian terhadap database MySQL `azkamandiri_test`.
- Menulis unit dan feature tests pada `tests/Feature/AuthTest.php`, `tests/Feature/FrontendPagesTest.php`, dan `tests/Feature/AdminCrudTest.php`.
- Menjalankan test suite: **23 tests, 73 assertions, 100% lulus tanpa kegagalan**.

### Phase 11: Dokumentasi Lengkap & Handover
- Pembuatan `README.md`, `PROJECT_OVERVIEW.md`, `DATABASE_DESIGN.md`, `DEVELOPMENT_LOG.md`, dan penyempurnaan `.env.example`.

### Phase 12: Penyempurnaan UX Admin CMS (Full-Width, Modal CRUD, Select2 & Ultra-Luxury SweetAlert2)
- **Full-Width Layout**: Mengeliminasi batas artifisial `max-w-7xl mx-auto` sehingga antarmuka tabel admin membentang elegan (*edge-to-edge content*) tanpa rongga kosong di kanan dan kiri pada layar lebar.
- **Breadcrumbs Interaktif**: Komponen navigasi hierarkis cerdas di Topbar dengan tautan aktif dan pemisah chevron Lucide.
- **Modal CRUD di Semua Modul**: Penerapan modal *Single-Page CRUD* untuk Kategori Layanan, Layanan, Kategori Portofolio, Portofolio, Kategori Artikel, Artikel, Testimoni, Halaman Statis, dan Inbox Pesan Masuk (Detail & Balas WhatsApp).
- **Select2 Luxury Theme**: Integrasi resmi jQuery & Select2 dengan tema custom emas-navy (`#172B4D`, `#D6A84F`) pada seluruh elemen dropdown.
- **Ultra-Luxury SweetAlert2**: Dialog konfirmasi & flash message diletakkan presisi di tengah layar (*perfect center*) berlatar *frosted glass* 12px, dilengkapi lencana perhiasan (*bespoke jewel badges*) SVG bergradasi halus dan bilah waktu auto-dismiss 3.5 detik.

### Phase 13: Migrasi Penuh ke Basis Data MySQL 8.0+ (Single Source of Truth)
- Menetapkan **MySQL 8.0+ sebagai satu-satunya database utama** untuk seluruh lingkungan pengembangan aplikasi AzkaMandiri (menggantikan PostgreSQL dan SQLite).
- Konfigurasi parameter koneksi pada `.env` dan `.env.example`:
  - `DB_CONNECTION=mysql`
  - `DB_HOST=127.0.0.1`
  - `DB_PORT=3306`
  - `DB_DATABASE=azkamandiri`
  - `DB_USERNAME=root`
  - `DB_PASSWORD=root`
- Konfigurasi default engine **InnoDB** pada `config/database.php` dan pengaturan `Schema::defaultStringLength(191)` pada `app/Providers/AppServiceProvider.php` untuk memastikan kompatibilitas penuh batas panjang indeks komposit pada `utf8mb4_unicode_ci`.
- Refactor seluruh query pencarian katalog dan admin dari operator PostgreSQL-spesifik `ilike` menjadi operator standar MySQL `like` pada 7 controller (Frontend & Admin: Service, Portfolio, Article, ContactMessage).
- Menjalankan fresh migration dan seeding seluruh modul: 10 tabel dan 9 seeder sukses terisi tanpa kendala.
- Konfigurasi database pengujian `azkamandiri_test` di `phpunit.xml` berbasis MySQL.
- Menjalankan seluruh automated test suite: **37 tests, 299 assertions, 100% passed**.

---

## 2. Keputusan Arsitektur & Teknologi

| Keputusan | Alasan & Keuntungan Teknis |
|:---|:---|
| **Laravel 13 + PHP 8.2+** | Framework PHP paling matang, aman, dan ekspresif. Mendukung routing modern, ORM Eloquent, proteksi CSRF bawaan, dan session handling tangguh. |
| **MySQL 8.0+ (InnoDB)** | Basis data relasional standar industri dengan engine transaksi ACID InnoDB, dukungan native tipe data JSON, integritas referensial foreign key, performa tinggi, dan portabilitas maksimal. |
| **Tailwind CSS v4 + Alpine.js** | Menghasilkan kode CSS ultra-ringan tanpa dependensi bundler raksasa seperti Vue/React untuk situs company profile. Menghadirkan performa First Contentful Paint (FCP) yang instan. |
| **Lucide Icons** | Koleksi icon vektor yang konsisten, bersih, dan berbobot ringan untuk arsitektur modern. |
| **Pemisahan Namespace Controller** | Memisahkan `Frontend` dan `Admin` controller secara eksplisit untuk menjaga modularitas kode dan kemudahan audit keamanan. |
| **Database Driver untuk Session & Cache** | Menggunakan tabel MySQL (`sessions`, `cache`) untuk session & caching tanpa perlu dependensi Redis terpisah. |

---

## 3. Tantangan Teknis yang Dihadapi & Solusinya

### Tantangan 1: Bentrok Blade Compiler pada JSON-LD `@context`
- **Gejala**: Terjadi error `ParseError: syntax error, unexpected end of file, expecting "elseif" or "else" or "endif"` saat me-render view frontend publik.
- **Penyebab**: Laravel versi terbaru memperkenalkan directive Blade `@context(...)`. Penulisan tag JSON-LD `"@context": "https://schema.org"` ditangkap oleh parser Blade sebagai directive pembuka blok tanpa tag penutup `@endcontext`.
- **Solusi**: Mengganti penulisan menjadi `"{{ '@context' }}": "https://schema.org"` dan `"{{ '@type' }}": "HomeAndConstructionBusiness"`. Dengan evaluasi echo tag Blade, parser directive terlewati sempurna dan JSON-LD valid terbentuk.

### Tantangan 2: Kompatibilitas Panjang Kunci Indeks MySQL (Error 1071)
- **Gejala**: Muncul error `SQLSTATE[42000]: 1071 Specified key was too long; max key length is 1000 bytes` saat menjalankan migration pada tabel `users` dan `failed_jobs`.
- **Penyebab**: Default collation `utf8mb4` mengalokasikan 4 byte per karakter. Pada indeks komposit atau email varchar(255), total ukuran melebihi batas indeks 1000 byte pada konfigurasi server tertentu.
- **Solusi**: Mengatur `'engine' => 'InnoDB'` secara eksplisit di `config/database.php` dan mendaftarkan `Schema::defaultStringLength(191);` di method `boot()` file `app/Providers/AppServiceProvider.php`.

### Tantangan 3: Operator Pencarian Kasus-Sensitif (ilike vs like)
- **Gejala**: Muncul error `SQLSTATE[42000]: 1064 You have an error in your SQL syntax ... near 'ilike'` saat menjalankan filter pencarian layanan atau portofolio.
- **Penyebab**: Operator `ilike` merupakan sintaks khusus PostgreSQL dan tidak dikenali oleh parser MySQL.
- **Solusi**: Mengganti seluruh operator `ilike` menjadi `like` di 7 controller. Pada MySQL dengan collation `utf8mb4_unicode_ci`, operator `like` secara alami bersifat *case-insensitive*, mempertahankan fleksibilitas pencarian pengunjung tanpa error SQL.

### Tantangan 4: Format Nomor Telepon Internasional WhatsApp API
- **Gejala**: Calon pelanggan atau pengelola usaha memasukkan format nomor telepon lokal beragam (misal: `0812-xxx`, `+62 812-xxx`, atau `62812-xxx`).
- **Penyebab**: Tautan `https://wa.me/<number>` menuntut format angka murni diawali kode negara tanpa tanda plus atau nol pembuka.
- **Solusi**: Membuat helper `cleanPhoneNumber` dengan regex otomatis mendeteksi awalan `0` dan mengonversinya menjadi `62`, serta membersihkan seluruh karakter non-numerik.

---

## 4. Ringkasan Hasil Pengujian Automated Tests

Perintah eksekusi: `php artisan test --testdox`
- **Lingkungan Uji**: PHP 8.3.28, MySQL 8.4.7 (`azkamandiri_test`), Laravel 13.42.0.
- **Hasil Total**:
  - **Tests**: 37
  - **Passed**: 37 (100%)
  - **Failures**: 0
  - **Assertions**: 299
  - **Durasi Eksekusi**: ~2.5 detik

### Rincian Pengujian per Modul (Semua Lulus 100%):
1. `Tests\Feature\AdminCrud`:
   - [x] Admin can crud service category (Create, Read, Update, Delete)
   - [x] Admin can crud portfolio category (Create, Read, Update, Delete)
   - [x] Admin can crud article category (Create, Read, Update, Delete)
   - [x] Admin can crud testimonial (Create, Read, Update, Delete)
   - [x] Admin can create and update service (Create, Read, Update, Delete)
   - [x] Admin can create and update portfolio (Create, Read, Update, Delete)
   - [x] Admin can crud article (Create, Read, Update, Delete)
   - [x] Admin can crud page (Create, Read, Update, Delete)
   - [x] Admin can manage contact messages (Create from form, View/Read, Update status, Delete)
   - [x] Admin can update website and seo settings
   - [x] Admin can update own profile and password
2. `Tests\Feature\Auth`:
   - [x] Login screen can be rendered
   - [x] Admin can authenticate with valid credentials
   - [x] Admin cannot authenticate with invalid password
   - [x] Admin can logout
   - [x] Unauthenticated user cannot access admin dashboard
3. `Tests\Feature\FrontendPages`:
   - [x] Home page renders successfully
   - [x] About page renders successfully
   - [x] Services catalog page renders and filters (MySQL LIKE query)
   - [x] Service detail page renders
   - [x] Portfolios catalog page renders
   - [x] Portfolio detail page renders
   - [x] Articles catalog page renders
   - [x] Article detail page renders and increments views
   - [x] Contact page renders
   - [x] Contact form submission stores message in database (Form transaction di MySQL)
   - [x] Static page renders
   - [x] Sitemap xml renders
   - [x] Robots txt renders
4. `Tests\Unit\Example`:
   - [x] That true is true

---

*Laporan pengembangan ini disusun sebagai bukti akuntabilitas dan kualitas teknis implementasi proyek AzkaMandiri.*

