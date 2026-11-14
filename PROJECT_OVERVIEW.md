# AzkaMandiri – Project Overview & Architecture Guide

Dokumen ini menyajikan gambaran menyeluruh arsitektur teknis, katalog fitur, strategi SEO & konversi, serta panduan praktis penyesuaian data bagi pemilik usaha (merchant onboarding) pada proyek **AzkaMandiri** – Website Company Profile & Content Management System (CMS) Aplikator Aluminium & Kaca.

---

## 1. Arsitektur Sistem

Aplikasi dibangun menggunakan pola arsitektur **Model-View-Controller (MVC)** standar Laravel 13 dengan pemisahan domain yang bersih dan modular:

```
                  ┌────────────────────────┐
                  │      HTTP Request      │
                  └───────────┬────────────┘
                              │
                    ┌─────────▼────────┐
                    │ Web Routes File  │
                    │  (routes/web.php)│
                    └─────────┬────────┘
                              │
          ┌───────────────────┴───────────────────┐
          │                                       │
┌─────────▼─────────┐                   ┌─────────▼─────────┐
│ Frontend Subsystem│                   │  Admin Subsystem  │
│  (Controllers/    │                   │   (Controllers/   │
│     Frontend)     │                   │       Admin)      │
└─────────┬─────────┘                   └─────────┬─────────┘
          │                                       │
          │         ┌───────────────────┐         │ (Auth Middleware)
          └────────►│   Eloquent Models │◄────────┘
                    │    (app/Models)   │
                    └─────────┬─────────┘
                              │
                    ┌─────────▼─────────┐
                    │   MySQL 8.0+ DB   │
                    │   (Tables & JSON) │
                    └───────────────────┘
```

### Karakteristik Desain Teknis:
1. **Modular Controllers**: Controller dipisahkan secara tegas ke dalam dua namespace: `App\Http\Controllers\Frontend` untuk pengunjung umum dan `App\Http\Controllers\Admin` untuk pengelola CMS.
2. **Helper Function Global (`app/helpers.php`)**: Menyediakan fungsi sentral `setting($key, $default)`, `wa_link()`, `wa_service_link()`, dan `wa_portfolio_link()` sehingga tidak ada duplikasi logika di dalam views maupun controllers.
3. **Trait Reusable (`HandlesImageUploads`)**: Menstandarkan penanganan berkas gambar (validasi format mimes: jpg, jpeg, png, webp, svg, penyimpanan ke `storage/app/public/`, dan penghapusan berkas lama saat diupdate/dihapus).
4. **Clean Asset Pipeline**: Menggunakan **Tailwind CSS v4** dengan warna korporat yang konsisten (Primary Navy `#172B4D`, Dark Navy `#101D33`, Accent Gold `#D6A84F`, dan neutral tones) serta **Alpine.js** untuk interaktivitas ringan (menu responsif, modal foto, accordion FAQ, filter dinamis) tanpa overhead framework JS berat.

---

## 2. Katalog Fitur Frontend Publik

| No | Halaman | URL Rute | Deskripsi & Fungsionalitas |
|:---|:---|:---|:---|
| 1 | **Beranda** | `/` | Hero section modern dengan dual CTA (Konsultasi WA & Lihat Portofolio), badge pengalaman & garansi, ringkasan keunggulan, grid 6 layanan terpopuler, showcase 6 portofolio terbaru, estimasi alur kerja (Konsultasi -> Survei -> Fabrikasi -> Instalasi -> Serah Terima & Garansi), ulasan testimoni klien riil, 3 artikel tips terbaru, accordion FAQ interaktif, dan floating WhatsApp button. |
| 2 | **Tentang Kami** | `/tentang-kami` | Sejarah singkat AzkaMandiri sebagai spesialis aplikator aluminium & kaca perorangan terpercaya di Tangerang Selatan, visi misi, nilai kerja (Presisi, Material Orisinal, Tepat Waktu, Transparan, Bergaransi), profil workshop, dan legalitas operasional. |
| 3 | **Katalog Layanan** | `/layanan` | Daftar lengkap seluruh layanan aktif, filter tabs berdasarkan kategori (Kusen & Pintu, Partisi & Kaca, Komersial & Khusus), pencarian instan berbasis teks, badge estimasi harga awal, dan tautan ke halaman detail. |
| 4 | **Detail Layanan** | `/layanan/{slug}` | Informasi komprehensif spesifik layanan: galeri foto pengerjaan interaktif, deskripsi mendalam, estimasi harga transparan, spesifikasi teknis lengkap (merek aluminium, ketebalan profil, tipe finishing warna, jenis kaca), daftar keunggulan fitur, FAQ relevan, dan tombol CTA konsultasi WhatsApp otomatis menyertakan nama layanan. |
| 5 | **Galeri Portofolio** | `/portofolio` | Galeri showcase pengerjaan proyek riil dengan filter kategori proyek, informasi tipe bangunan (Rumah Tinggal, Ruko, Kantor, Cafe), lokasi pengerjaan (BSD City, Bintaro, Jaksel, dll.), dan tahun instalasi. |
| 6 | **Detail Portofolio** | `/portofolio/{slug}` | Rincian proyek terpilih: slider galeri hasil pekerjaan, latar belakang kebutuhan klien, solusi teknis yang diaplikasikan AzkaMandiri, daftar material terpasang, durasi pengerjaan, dan tombol CTA konsultasi WhatsApp dengan rujukan proyek terkait. |
| 7 | **Artikel Edukasi** | `/artikel` | Blog tips dan panduan konstruksi kaca & aluminium, filter kategori (Tips, Inspirasi Desain, Perawatan), fitur pencarian artikel, dan counter pembaca otomatis. |
| 8 | **Detail Artikel** | `/artikel/{slug}` | Pembacaan artikel lengkap dengan typography nyaman, informasi tanggal & penulis, auto-increment view count pada setiap kunjungan, dan sidebar artikel terkait. |
| 9 | **Halaman Kontak** | `/kontak` | Alamat workshop lengkap, jam operasional, link navigasi Google Maps, nomor telepon & WhatsApp interaktif, email resmi, dan formulir pengiriman pesan langsung ke database CMS. |
| 10 | **Halaman Statis** | `/halaman/{slug}` | Menampilkan halaman informasi hukum dan kebijakan, seperti: `syarat-ketentuan`, `kebijakan-privasi`, dan `garansi-pekerjaan`. |
| 11 | **Sitemap XML** | `/sitemap.xml` | XML sitemap otomatis mengindeks seluruh URL dinamis (layanan, portofolio, artikel, halaman statis) untuk mesin pencari Google/Bing. |
| 12 | **Robots TXT** | `/robots.txt` | Aturan crawling mesin perayap (mengizinkan perayapan halaman publik dan memblokir akses bot ke area `/admin`). |

---

## 3. Katalog Fitur Admin CMS Dashboard

Admin CMS dapat diakses melalui URL `/admin` dan diproteksi dengan session authentication.

| Modul | Endpoint Rute | Fungsi & Kemampuan Pengelolaan |
|:---|:---|:---|
| **Dashboard** | `/admin` | Metrik ringkasan: Total Layanan, Portofolio, Artikel Berita, Pesan Masuk Belum Dibaca, daftar 5 pesan terbaru, dan jalan pintas cepat ke seluruh modul. |
| **Profil Website** | `/admin/settings/profile` | Form pembaruan identitas usaha: nama website/brand, slogan, deskripsi ringkas, nomor WhatsApp (format otomatis diubah menjadi international code 62), nomor telepon, email, alamat fisik workshop, link Google Maps embed/direct, jam kerja operasional, tautan medsos (Instagram, Facebook, TikTok, YouTube), upload logo utama, logo dark mode, dan favicon. |
| **Pengaturan SEO** | `/admin/settings/seo` | Pengaturan meta title default, meta description, meta keywords, dan default OG social share image. |
| **Kategori Layanan** | `/admin/service-categories` | Tambah, ubah, hapus kategori layanan (misal: Kusen & Pintu Aluminium, Partisi & Kaca Interior, Facade & Komersial). |
| **Kelola Layanan** | `/admin/services` | Tambah, ubah, hapus data layanan. Mendukung upload thumbnail utama, upload multiple foto galeri pengerjaan, penentuan estimasi harga, input spesifikasi teknis dinamis, daftar fitur unggulan, status aktif, dan featured toggle. |
| **Kategori Portofolio** | `/admin/portfolio-categories` | Tambah, ubah, hapus kategori proyek (Residential, Commercial, Interior Office, dsb.). |
| **Kelola Portofolio** | `/admin/portofolio` | Tambah, ubah, hapus showcase proyek. Mendukung multi-image upload, nama klien/tipe proyek, lokasi pengerjaan, jenis material terpasang, tanggal penyelesaian, dan deskripsi detail. |
| **Kategori Artikel** | `/admin/article-categories` | Tambah, ubah, hapus kategori artikel konstruksi & panduan. |
| **Kelola Artikel** | `/admin/articles` | Tambah, edit, hapus artikel edukasi. Dilengkapi status Draft / Published, upload cover gambar, input ringkasan, isi konten lengkap, dan counter pembaca. |
| **Testimoni Klien** | `/admin/testimonials` | Tambah, edit, hapus ulasan testimoni. Rating bintang (1 s/d 5), nama klien, profesi atau tipe proyek, isi ulasan, dan avatar/foto klien. |
| **Pesan Masuk (Inbox)** | `/admin/contact-messages` | Daftar kontak pelanggan dari form publik. Fitur filter berdasarkan status (Unread, Read, Replied), tombol baca pesan detail, aksi tandai sudah dibaca, hapus pesan, dan tombol one-click **"Balas via WhatsApp"** yang membuka chat WA ke nomor pengirim. |
| **Halaman Statis** | `/admin/pages` | Tambah, edit, hapus konten statis (Syarat & Ketentuan, Kebijakan Privasi, Garansi Layanan). Mendukung status aktif dan auto-slug. |
| **Profil Akun Admin** | `/admin/profile` | Update nama administrator, alamat email login, dan ganti kata sandi login admin. |

---

## 4. Mekanisme Integrasi WhatsApp

WhatsApp adalah poros konversi penjualan AzkaMandiri. Implementasi tautan dinamis dikendalikan oleh class `App\Helpers\WhatsAppHelper`:

### 1. Sanitasi Nomor WhatsApp
Fungsi `cleanPhoneNumber($phone)` secara otomatis memformat nomor telepon dari format lokal Indonesia (`0812...`) atau internasional (`+62...`) menjadi string angka berawalan kode negara standar WhatsApp API (`62812...`).

### 2. Tautan Berbasis Konteks (Context-Aware URL Generation)
- **Umum (Floating Button & Header)**:
  ```php
  wa_link("Halo AzkaMandiri, saya ingin berkonsultasi mengenai jasa aluminium dan kaca.")
  ```
- **Layanan Spesifik**:
  ```php
  wa_service_link($service->name)
  // Menghasilkan:
  // "Halo AzkaMandiri, saya tertarik dengan layanan [Nama Layanan]. Boleh minta estimasi harga dan jadwal survei lokasi?"
  ```
- **Portofolio Spesifik**:
  ```php
  wa_portfolio_link($portfolio->title)
  // Menghasilkan:
  // "Halo AzkaMandiri, saya melihat proyek [Judul Proyek] di website Anda. Bisakah membuatkan model serupa untuk lokasi saya?"
  ```
- **Balas Pesan Pelanggan di Admin**:
  ```php
  WhatsAppHelper::generateUrl($message->phone, "Halo {$message->name}, terima kasih telah menghubungi AzkaMandiri. Menanggapi pesan Anda mengenai: \"{$message->subject}\"...")
  ```

---

## 5. Strategi Search Engine Optimization (SEO)

AzkaMandiri dirancang untuk mendominasi kata kunci lokal seperti:
- *"jasa kusen aluminium tangerang selatan"*
- *"pasang pintu kaca tempered bsd"*
- *"kontraktor partisi aluminium kantor bintaro"*
- *"bengkel aluminium tangsel terpercaya"*

### Implementasi Teknis SEO:
1. **Dinamis Meta Tags (`resources/views/layouts/app.blade.php`)**:
   - Meta title otomatis tersusun dengan pola: `[Judul Halaman] | [Nama Usaha] - [Slogan]`.
   - Meta description, keywords, dan author dinamis.
   - Canonical URL tag untuk mencegah isu duplikasi konten.
2. **Open Graph & Twitter Card Protocol**:
   - `og:title`, `og:description`, `og:image`, `og:url`, `og:type` disesuaikan pada tiap halaman layanan, portofolio, dan artikel agar tampil memikat saat dibagikan ke WhatsApp, Facebook, LinkedIn, dan Twitter/X.
3. **Structured Data JSON-LD (`Schema.org`)**:
   - Menggunakan skema `HomeAndConstructionBusiness` lengkap dengan nama usaha, telepon, alamat presisi di Tangerang Selatan, koordinat geolokasi, jam buka, dan rentang harga `$$`.
4. **Sitemap Otomatis (`/sitemap.xml`)**:
   - Dikelola oleh `SeoController@sitemap` yang otomatis mengompilasi seluruh rute publik dan update timestamp secara real-time.
5. **Robots File (`/robots.txt`)**:
   - Membuka akses crawler ke seluruh konten publik dan memproteksi `/admin` dan `/storage` dari pengindeksan crawler tak bertanggung jawab.

---

## 6. Panduan Penyesuaian Data Usaha (Merchant Onboarding)

Ketika pemilik usaha asli (Pak Azka / tim manajemen AzkaMandiri) hendak memperbarui data operasional riil, berikut panduan langkahnya:

### 1. Mengubah Kontak, Alamat & Jam Kerja
1. Masuk ke Admin Dashboard: `http://domain-anda.com/admin/login`
2. Buka menu **Pengaturan** -> **Profil Website**.
3. Ubah kolom:
   - **Nomor WhatsApp**: Masukkan nomor handphone aktif (contoh: `0812-9876-5432`).
   - **Alamat Workshop**: Masukkan alamat fisik bengkel kerja di Tangerang Selatan.
   - **Embed / Link Google Maps**: Salin tautan share link atau iframe embed dari Google Maps workshop.
   - **Jam Operasional**: Sesuaikan jadwal buka (misal: `Senin - Sabtu: 08.00 - 17.00 WIB`).
4. Klik **Simpan Perubahan**. Semua kontak di seluruh website (header, footer, tombol WA, floating button, halaman kontak) akan langsung terupdate otomatis!

### 2. Mengganti Logo Brand
1. Di halaman **Profil Website**, temukan bagian upload:
   - **Logo Utama**: Upload logo warna untuk background terang (format SVG/PNG transparan).
   - **Logo Dark Mode**: Upload logo versi putih/kontras untuk footer gelap.
   - **Favicon**: Upload icon kotak 32x32 atau 64x64 px.
2. Klik **Simpan Perubahan**.

### 3. Menambahkan atau Mengubah Layanan Baru
1. Buka menu **Layanan** -> Klik tombol **Tambah Layanan**.
2. Masukkan:
   - Nama Layanan (contoh: *Pintu Lipat Aluminium Minimalis*).
   - Pilih Kategori Layanan.
   - Masukkan estimasi harga mulai (contoh: `Rp 1.250.000 / unit`).
   - Unggah Thumbnail utama dan foto galeri hasil pengerjaan.
   - Isi spesifikasi teknis (Pilihan Merek profil seperti Alexindo, YKK, Dacon, pilihan kaca 5mm-12mm tempered).
   - Tulis keunggulan layanan pada kolom checklist fitur.
3. Klik **Simpan**. Halaman layanan baru beserta tombol WhatsApp otomatis langsung terbit dan terdaftar di `sitemap.xml`.

### 4. Menambahkan Hasil Proyek ke Portofolio
1. Buka menu **Portofolio** -> Klik **Tambah Portofolio**.
2. Masukkan judul proyek, nama klien atau jenis properti, lokasi proyek (contoh: *Cluster Foresta, BSD City*), material yang digunakan, dan tahun penyelesaian.
3. Unggah foto-foto resolusi tinggi hasil pekerjaan akhir.
4. Klik **Simpan**. Proyek akan langsung tampil di galeri portofolio publik.

---

*Dokumentasi ini disiapkan secara eksklusif untuk operasional dan pemeliharaan website AzkaMandiri.*

