# AzkaMandiri – Website Company Profile & CMS Aplikator Aluminium & Kaca

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-4.x-38B2AC?style=flat&logo=tailwind-css)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat&logo=alpinedotjs)](https://alpinejs.dev)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php)](https://php.net)
[![Tests Passing](https://img.shields.io/badge/Tests-37%20passed%20(100%25)-success?style=flat)](#automated-testing)

Website profil usaha dan Content Management System (CMS) modern, elegan, responsif, dan SEO-friendly untuk **AzkaMandiri**, spesialis aplikator kusen aluminium, pintu & jendela kaca, partisi kantor, shower box, curtain wall, dan etalase komersial di wilayah Tangerang Selatan & Jabodetabek.

Dibangun dengan arsitektur **Laravel 13**, basis data **MySQL 8.0+ (InnoDB)**, serta antarmuka visual modern berbasis **Tailwind CSS v4** dan **Alpine.js**.

---

## 📋 Daftar Isi
1. [Fitur Utama](#-fitur-utama)
2. [Kebutuhan Sistem](#-kebutuhan-sistem)
3. [Panduan Instalasi Langkah Demi Langkah](#-panduan-instalasi-langkah-demi-langkah)
4. [Kredensial Default Admin CMS](#-kredensial-default-admin-cms)
5. [Automated Testing](#-automated-testing)
6. [Struktur Direktori Proyek](#-struktur-direktori-proyek)
7. [Panduan Integrasi WhatsApp](#-panduan-integrasi-whatsapp)
8. [Panduan Deployment ke VPS Produksi](#-panduan-deployment-ke-vps-produksi)
9. [Dokumentasi Tambahan](#-dokumentasi-tambahan)

---

## ✨ Fitur Utama

### Frontend Publik
- **Beranda (Home)**: Hero banner informatif, keunggulan usaha, grid layanan unggulan, showcase portofolio terbaru, estimasi alur kerja transparan, testimoni klien riil, artikel tips konstruksi, FAQ interaktif, dan sticky WhatsApp CTA floating button.
- **Tentang Kami**: Profil spesialis aplikator, visi & misi, nilai inti, tim ahli bersertifikasi K3 & aplikator, serta keabsahan izin operasional.
- **Katalog Layanan (`/layanan`)**: Filter kategori, pencarian keyword dinamis, dan kartu spesifikasi layanan lengkap.
- **Detail Layanan (`/layanan/{slug}`)**: Galeri foto pengerjaan, tabel spesifikasi teknis, fitur keunggulan material, FAQ spesifik layanan, dan tombol CTA konsultasi WhatsApp otomatis menyertakan nama layanan terkait.
- **Galeri Portofolio (`/portofolio`)**: Filter kategori proyek, info klien/tipe bangunan, lokasi, material yang digunakan, dan tahun pengerjaan.
- **Detail Portofolio (`/portofolio/{slug}`)**: Showcase hasil pekerjaan, galeri multi-foto, rincian teknis proyek, dan tombol CTA konsultasi WhatsApp dengan konteks proyek terkait.
- **Artikel Edukasi (`/artikel`)**: Tips memilih profil aluminium, panduan perawatan kaca tempered, artikel inspirasi desain arsitektural, counter view interaktif, dan pencarian artikel.
- **Halaman Kontak (`/kontak`)**: Informasi alamat workshop di Tangerang Selatan, jam operasional, link Google Maps interaktif, nomor WhatsApp dan telepon dinamis, serta formulir pengiriman pesan yang langsung tersimpan ke database CMS.
- **Halaman Statis Dinamis (`/halaman/{slug}`)**: Menampilkan Syarat & Ketentuan Layanan, Kebijakan Privasi, dan Garansi Pekerjaan.
- **Optimasi SEO Lengkap**: Otomatis generate Schema.org `LocalBusiness` JSON-LD, Open Graph tags, Twitter Card tags, dinamis `sitemap.xml`, dan `robots.txt`.

### Admin CMS Dashboard (`/admin`)
- **Dashboard Ringkasan**: Statistik total layanan, portofolio proyek, artikel, pesan masuk yang belum dibaca, pesan terbaru, dan review cepat aktivitas.
- **Manajemen Layanan & Kategori**: Full CRUD layanan lengkap dengan upload thumbnail & galeri multi-foto, estimasi harga mulai, spesifikasi teknis, dan fitur unggulan.
- **Manajemen Portofolio & Kategori**: Full CRUD proyek lengkap dengan multi-foto, informasi lokasi, material, dan tanggal penyelesaian.
- **Manajemen Artikel & Kategori**: Full CRUD artikel berita dan tips konstruksi dengan status publikasi draft/published.
- **Manajemen Testimoni**: Kelola ulasan klien, rating bintang (1-5), profesi/perusahaan, dan avatar klien.
- **Pesan Masuk (Contact Messages)**: Inbox pesan masuk pelanggan dari form kontak publik, filter status (unread/read/replied), tandai status, dan tombol aksi "Balas via WhatsApp" otomatis.
- **Halaman Statis**: Kelola halaman Kebijakan Privasi, Garansi, Ketentuan Layanan, dsb.
- **Pengaturan Profil Usaha**: Update nama usaha, slogan, email, nomor WhatsApp dinamis, telepon, alamat workshop, link Google Maps, jam kerja, link sosial media, dan upload logo/favicon.
- **Pengaturan SEO**: Update meta title global, meta description, keywords, dan Open Graph default image.
- **Profil Admin**: Update nama, email, dan kata sandi akun admin.

---

## 💻 Kebutuhan Sistem

Pastikan environment Anda memenuhi prasyarat berikut:
- **PHP**: Versi **8.2** atau **8.3+** dengan ekstensi aktif:
  - `pdo_mysql`, `mysql` (atau `mysqli`)
  - `mbstring`, `openssl`, `curl`, `fileinfo`, `gd` (atau `imagick`), `xml`, `bcmath`
- **MySQL**: Versi **8.0+** (dengan Storage Engine InnoDB)
- **Composer**: Versi **2.x**
- **Node.js**: Versi **18.x** atau **20+** LTS
- **NPM**: Versi **9.x** atau **10+**

---

## 🚀 Panduan Instalasi Langkah Demi Langkah

### 1. Masuk ke Direktori Proyek
```bash
cd "d:\JUALAN\azkamandiri laravel"
```

### 2. Install Dependensi PHP
```bash
composer install --no-interaction --prefer-dist --optimize-autoloader
```

### 3. Buat Database MySQL
Buka MySQL CLI atau GUI (phpMyAdmin / HeidiSQL / DBeaver / Navicat), lalu jalankan:
```sql
CREATE DATABASE azkamandiri CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE azkamandiri_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Konfigurasi Berkas `.env`
Salin template konfigurasi:
```bash
cp .env.example .env
```
Sesuaikan kredensial MySQL pada file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=azkamandiri
DB_USERNAME=root
DB_PASSWORD=root
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Jalankan Migrasi & Database Seeder
Jalankan migrasi seluruh tabel (13 tabel lengkap) dan seeder data awal (10 layanan, 6 portofolio, 4 artikel, testimoni, halaman statis, dan pengaturan website):
```bash
php artisan migrate:fresh --seed
```

### 7. Buat Symbolic Link Storage Upload
Hubungkan direktori publik ke penyimpanan upload:
```bash
php artisan storage:link
```

### 8. Install & Kompilasi Asset Frontend
Install dependensi npm dan kompilasi asset:
```bash
npm install
npm run build
```
*(Untuk mode pengembangan dengan live reload, jalankan `npm run dev`)*

### 9. Jalankan Server Lokal
```bash
php artisan serve
```
Aplikasi siap diakses melalui peramban:
- Frontend Publik: `http://localhost:8000`
- Admin CMS: `http://localhost:8000/admin`

---

## 🔐 Kredensial Default Admin CMS

| Parameter | Keterangan |
| :--- | :--- |
| **URL Login** | [`http://localhost:8000/admin/login`](http://localhost:8000/admin/login) |
| **Email** | `admin@azkamandiri.com` |
| **Password** | `Password123!` |
| **Role** | Super Administrator (Akses penuh 13 modul CMS) |

> ⚠️ **Penting untuk Produksi**: Segera ganti email dan password default ini melalui menu **Profil Admin** (`/admin/profile`) setelah instalasi di server produksi.

---

## 🧪 Automated Testing

Proyek ini telah dilengkapi dengan unit dan feature tests komprehensif yang berjalan langsung di atas basis data MySQL test (`azkamandiri_test`).

Jalankan test suite dengan perintah:
```bash
php artisan test
```
Atau dengan format rincian deskriptif:
```bash
php artisan test --testdox
```

### Cakupan Test (37 Tests, 299 Assertions, 100% Passing):
- **Authentication**: Form login rendering, validasi kredensial benar/salah, proteksi rute middleware admin, dan logout.
- **Frontend Pages & Transactions**: Home page, About page, Catalog Layanan & live search filter (case-insensitive `LIKE`), Detail Layanan, Catalog Portofolio, Detail Portofolio, Catalog Artikel, Detail Artikel (dengan verifikasi auto-increment view counter), Form Kontak (dengan verifikasi transaksi penyimpanan pesan pelanggan ke MySQL), Halaman Statis, `sitemap.xml`, dan `robots.txt`.
- **Admin CMS Full CRUD**: Siklus lengkap Create, Read, Update, Delete untuk Service Categories, Portfolio Categories, Article Categories, Services, Portfolios, Articles, Testimonials, Static Pages, Contact Messages management & status update, Website & SEO Settings update, serta Admin Profile & Password hashing update.

---

## 📁 Struktur Direktori Proyek

```
azkamandiri-laravel/
├── app/
│   ├── Helpers/
│   │   └── WhatsAppHelper.php       # Format URL pesan WhatsApp dinamis
│   ├── Http/Controllers/
│   │   ├── Admin/                   # 14 Controller Admin CMS
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ServiceController.php
│   │   │   ├── PortfolioController.php
│   │   │   ├── ArticleController.php
│   │   │   ├── ContactMessageController.php
│   │   │   ├── ProfileSettingController.php
│   │   │   ├── SeoSettingController.php
│   │   │   └── ...
│   │   └── Frontend/                # 8 Controller Frontend Publik
│   │       ├── HomeController.php
│   │       ├── AboutController.php
│   │       ├── ServiceController.php
│   │       ├── PortfolioController.php
│   │       ├── ArticleController.php
│   │       ├── ContactController.php
│   │       ├── PageController.php
│   │       └── SeoController.php
│   ├── Models/                      # 11 Eloquent Model
│   ├── Traits/
│   │   └── HandlesImageUploads.php  # Trait helper upload/delete gambar
│   └── helpers.php                  # Helper setting(), wa_link(), dsb.
├── database/
│   ├── migrations/                  # 10 migration file MySQL (InnoDB)
│   └── seeders/                     # 9 database seeder komprehensif
├── public/
│   ├── assets/
│   │   ├── brand/                   # SVG Logo Horizontal, Dark, Icon, Favicon
│   │   └── images/                  # Demo assets layanan, portofolio, artikel
│   └── storage/                     # Symlink ke storage/app/public
├── resources/
│   ├── css/app.css                  # Tailwind CSS v4 styling & typography
│   ├── js/app.js                    # Alpine.js & Lucide Icons loader
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php        # Layout utama frontend publik
│       │   └── admin.blade.php      # Layout utama admin dashboard CMS
│       ├── frontend/                # View beranda, layanan, portofolio, artikel, dll.
│       └── admin/                   # View 13 modul CMS admin (Modal-based CRUD & Select2)
├── tests/
│   └── Feature/                     # Feature tests (Auth, Frontend, Admin CRUD di MySQL)
├── .env.example                     # Environment template (Koneksi MySQL)
├── DATABASE_DESIGN.md               # Spesifikasi lengkap ERD & skema MySQL 8.0+
├── PROJECT_OVERVIEW.md              # Rincian arsitektur & panduan kustomisasi
├── DEVELOPMENT_LOG.md               # Catatan kronologis implementasi Phase 1-12
└── README.md                        # Panduan dokumentasi utama
```

---

## 💬 Panduan Integrasi WhatsApp

AzkaMandiri mengandalkan WhatsApp sebagai saluran konversi utama. Sistem secara otomatis membuat tautan `https://wa.me/` terenkripsi URL yang ramah bagi calon pelanggan:

1. **Floating WhatsApp Button**:
   - Tautan langsung ke nomor CS yang dikonfigurasi di CMS (`Setting: whatsapp_number`).
   - Format template:
     ```
     Halo AzkaMandiri, saya ingin berkonsultasi mengenai jasa aluminium dan kaca.
     ```
2. **CTA Layanan (`/layanan/{slug}`)**:
   - Membawa konteks nama layanan yang sedang dilihat:
     ```
     Halo AzkaMandiri, saya tertarik dengan layanan [Nama Layanan]. Boleh minta estimasi harga dan jadwal survei lokasi?
     ```
3. **CTA Portofolio (`/portofolio/{slug}`)**:
   - Membawa referensi proyek yang sedang dilihat:
     ```
     Halo AzkaMandiri, saya melihat proyek [Judul Portofolio] di website. Bisakah membuatkan model serupa untuk lokasi saya?
     ```
4. **Balas Pesan Masuk Admin (`/admin/contact-messages/{id}`)**:
   - Admin dapat mengklik tombol **"Balas via WhatsApp"** yang langsung membuka chat ke nomor kontak pengirim dengan salam pembuka personal.

---

## 🛠️ Panduan Manajemen Basis Data & Lingkungan Lokal

Seluruh pengembangan AzkaMandiri dijalankan secara penuh di lingkungan lokal dengan spesifikasi MySQL 8.0+:

### 1. Konfigurasi Database Lokal (.env)
Pastikan parameter koneksi MySQL pada `.env` telah sesuai:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=azkamandiri
DB_USERNAME=root
DB_PASSWORD=root
```

### 2. Reset & Fresh Migration dengan Seeder
Untuk meregenerasi struktur database dan mengisikan data default:
```bash
php artisan migrate:fresh --seed
```

### 3. Database Testing Terpisah
Pengujian otomatis dijalankan pada database terpisah `azkamandiri_test` yang telah dikonfigurasi pada `phpunit.xml`:
```sql
CREATE DATABASE IF NOT EXISTS azkamandiri_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Jalankan test suite:
```bash
php artisan test
```

### 4. Kompatibilitas MySQL InnoDB
- Seluruh tabel dikonfigurasi menggunakan storage engine **InnoDB** dengan `ROW_FORMAT=DYNAMIC`.
- Panjang default string diatur `Schema::defaultStringLength(191)` pada `AppServiceProvider` untuk kepatuhan indeks komposit `utf8mb4` MySQL.

---

## 📚 Dokumentasi Tambahan

Untuk dokumentasi lebih mendalam mengenai arsitektur, basis data, dan riwayat pengembangan, silakan pelajari:
- **[PROJECT_OVERVIEW.md](PROJECT_OVERVIEW.md)**: Ringkasan arsitektur sistem, rincian fitur frontend & backend, konfigurasi WhatsApp, strategi SEO, serta panduan onboarding pemilik usaha.
- **[DATABASE_DESIGN.md](DATABASE_DESIGN.md)**: Diagram relasi basis data (ERD), skema kamus data MySQL 8.0+, konfigurasi indeks, dan cascading delete rule.
- **[DEVELOPMENT_LOG.md](DEVELOPMENT_LOG.md)**: Log kronologis pengerjaan per fase, keputusan arsitektur, migrasi basis data ke MySQL, dan laporan verifikasi pengujian.

---

**AzkaMandiri** – *Solusi Estetika & Kekuatan Kusen Aluminium dan Kaca Modern.*  
Dikembangkan secara profesional dan siap pakai untuk produksi.
