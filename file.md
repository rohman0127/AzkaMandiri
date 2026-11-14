# MASTER PROMPT — AUTONOMOUS FULL DEVELOPMENT AZKAMANDIRI

## ROLE DAN TANGGUNG JAWAB

Bertindak sebagai Senior Full-Stack Developer, Software Architect, UI/UX Designer, Database Engineer, Security Engineer, dan QA Engineer profesional.

Anda bertanggung jawab penuh untuk membangun aplikasi website **AZKAMANDIRI** dari nol sampai selesai.

PENTING: Kerjakan SELURUH PROJECT secara mandiri (fully autonomous).

Saya tidak ingin melakukan review di tengah proses pengerjaan.

Saya tidak ingin diminta menyetujui setiap tahapan.

Saya tidak ingin diberikan pilihan-pilihan teknis yang sebenarnya dapat Anda putuskan sendiri.

Saya tidak ingin menerima hasil berupa tutorial, contoh kode, mockup, atau dokumentasi saja.

Saya ingin Anda LANGSUNG MENGERJAKAN SELURUH PROJECT di dalam workspace yang tersedia sampai aplikasi benar-benar selesai dan dapat dijalankan.

**Jangan berhenti pada setiap phase untuk meminta persetujuan saya.**

**Jangan menunggu instruksi "lanjut" dari saya.**

**Jangan meminta saya mereview hasil sementara.**

**Jangan mengakhiri pekerjaan sebelum seluruh fitur selesai diimplementasikan dan diuji.**

Jika satu tahap sudah selesai, langsung lanjutkan ke tahap berikutnya secara otomatis.

Jika menemukan error, analisis dan perbaiki sendiri.

Jika ada keputusan teknis yang belum ditentukan, gunakan keputusan terbaik berdasarkan best practice dan kompatibilitas teknologi.

Saya hanya akan melakukan review setelah SELURUH PROJECT selesai.

---

# 1. IDENTITAS PROJECT

Nama project: AZKAMANDIRI

Nama brand:
AzkaMandiri – Jasa Aluminium & Kaca.

Jenis usaha:
Usaha mandiri/perseorangan yang bergerak di bidang jasa pemasangan dan pembuatan aluminium, kaca, serta pekerjaan custom untuk kebutuhan bangunan.

AzkaMandiri belum berbentuk CV maupun PT.

Jangan mencantumkan status badan hukum yang belum dimiliki.

Target pelanggan:
- Pemilik rumah.
- Pemilik ruko.
- Pemilik kantor.
- Kontraktor.
- Developer.
- Pemilik gedung.
- Pelanggan umum.

Tujuan website:
1. Memperkenalkan AzkaMandiri secara profesional.
2. Menampilkan berbagai layanan aluminium dan kaca.
3. Menampilkan hasil pekerjaan melalui portofolio.
4. Membangun kepercayaan calon pelanggan.
5. Mempermudah calon pelanggan menghubungi melalui WhatsApp.
6. Menyediakan dashboard admin untuk mengelola seluruh konten website.

Jenis aplikasi:
Company Profile Website + CMS Admin Dashboard.

---

# 2. TECH STACK WAJIB

Gunakan:

- Laravel 13.
- PHP versi yang kompatibel dengan Laravel 13.
- PostgreSQL.
- Laravel Blade.
- Tailwind CSS.
- Alpine.js.
- JavaScript.
- Vite.
- Lucide Icons.
- Laravel Eloquent ORM.
- Laravel Authentication.
- Laravel Filesystem.

Gunakan Pest atau PHPUnit untuk testing.

Jangan gunakan React, Vue, Next.js, MySQL, maupun SQLite sebagai database utama.

Pastikan semua dependency kompatibel dengan Laravel 13.

Jika ada package yang tidak kompatibel, cari alternatif yang stabil tanpa meminta persetujuan saya.

---

# 3. BRANDING DAN LOGO

Buat identitas visual original untuk AzkaMandiri.

Konsep logo:
- Menggunakan simbol geometris frame jendela aluminium.
- Memiliki elemen kaca atau panel transparan.
- Modern, minimalis, elegan.
- Mudah dikenali.
- Cocok untuk website dan media sosial.

Buat:
1. Logo horizontal.
2. Logo icon.
3. Favicon.
4. Logo untuk background terang.
5. Logo untuk background gelap.

Jika image generation tidak tersedia, buat logo menggunakan SVG secara profesional.

Simpan logo di public/assets/brand/.

Gunakan palet warna:

- Primary Navy: #172B4D.
- Dark Navy: #101D33.
- Gold: #D6A84F.
- White: #FFFFFF.
- Light Gray: #F5F6F8.
- Text Dark: #343A40.
- Secondary Text: #737B87.

Gunakan font Inter atau Poppins.

---

# 4. DESAIN WEBSITE

Buat desain premium dengan konsep:

Modern Architectural – Minimalist – Professional.

Inspirasi:
Website perusahaan jasa aluminium, kaca, konstruksi, arsitektur, dan interior modern.

Karakteristik:
- Clean layout.
- Premium typography.
- White space yang cukup.
- Foto bangunan dan pekerjaan aluminium berkualitas tinggi.
- Hero section yang kuat.
- Card modern.
- Rounded corner secukupnya.
- Shadow halus.
- Animasi ringan.
- Navigasi sederhana.
- Responsive.

Jangan membuat desain yang terlihat seperti template gratis yang belum dikustomisasi.

Buat konsistensi desain antara frontend dan admin dashboard.

---

# 5. FRONTEND WEBSITE

Implementasikan seluruh halaman berikut.

## A. Homepage

URL: /

Komponen:

1. Navbar:
   - Logo.
   - Home.
   - Tentang Kami.
   - Layanan.
   - Portofolio.
   - Artikel.
   - Kontak.
   - Hubungi Kami.

2. Hero:
   Headline:
   "Solusi Aluminium & Kaca untuk Hunian dan Bangunan Anda"

   Deskripsi:
   "AzkaMandiri hadir memberikan layanan pemasangan, pembuatan, dan pengerjaan aluminium serta kaca berkualitas dengan hasil rapi dan profesional."

   Tombol:
   - Konsultasi Sekarang.
   - Lihat Portofolio.

3. Trust Indicator:
   - Pengerjaan Rapi.
   - Material Berkualitas.
   - Harga Kompetitif.
   - Konsultasi.
   - Kepuasan Pelanggan.

4. About Preview.

5. Services Preview.

6. Why Choose Us.

7. Portfolio Preview.

8. How It Works.

9. Testimonials.

10. CTA WhatsApp.

11. Footer.

Seluruh konten yang dapat dikelola harus berasal dari database.

## B. Tentang Kami

URL: /tentang-kami

Tampilkan:
- Profil AzkaMandiri.
- Sejarah usaha.
- Visi.
- Misi.
- Nilai kerja.
- Keunggulan.
- Foto pekerjaan.
- CTA WhatsApp.

## C. Layanan

URL: /layanan

Layanan awal:
- Kusen Aluminium.
- Jendela Aluminium.
- Pintu Aluminium.
- Partisi Aluminium.
- Kaca Tempered.
- Kanopi Kaca.
- Shower Box.
- Etalase Kaca.
- Lemari Aluminium.
- Aluminium dan Kaca Custom.

Fitur:
- Daftar layanan.
- Kategori.
- Search.
- Pagination.
- Detail layanan.
- Gambar.
- Galeri.
- CTA WhatsApp.

URL detail: /layanan/{slug}.

## D. Portofolio

URL: /portofolio

Fitur:
- Daftar proyek.
- Kategori.
- Filter.
- Search.
- Pagination.
- Foto.
- Nama proyek.
- Lokasi.
- Tahun pengerjaan.

Detail: /portofolio/{slug}.

## E. Artikel

URL: /artikel

Fitur:
- Daftar artikel.
- Kategori.
- Thumbnail.
- Tanggal publikasi.
- Ringkasan.
- Pagination.
- Search.

Detail: /artikel/{slug}.

## F. Kontak

URL: /kontak

Tampilkan:
- WhatsApp.
- Telepon.
- Email.
- Alamat.
- Area layanan.
- Google Maps.
- Form kontak.

Form kontak:
- Nama.
- WhatsApp.
- Email opsional.
- Subjek.
- Pesan.

Simpan pesan ke PostgreSQL.

---

# 6. WHATSAPP INTEGRATION

Integrasikan WhatsApp secara menyeluruh.

Buat:
- Floating WhatsApp.
- Tombol navbar.
- Tombol hero.
- Tombol detail layanan.
- Tombol detail portofolio.
- Tombol kontak.

Nomor WhatsApp harus berasal dari pengaturan database.

Gunakan pesan otomatis yang dinamis berdasarkan layanan atau proyek yang dipilih.

Pastikan menggunakan format wa.me yang benar dan URL encoding.

---

# 7. ADMIN DASHBOARD

URL: /admin.

Buat dashboard modern dengan:
- Sidebar.
- Topbar.
- Breadcrumb.
- Statistik.
- Notifikasi.
- User profile.
- Logout.

Gunakan satu akun administrator.

Tidak perlu registrasi publik maupun multi-role.

Admin harus dapat mengelola seluruh konten website tanpa menyentuh kode program.

## Modul admin wajib:

### 1. Dashboard
- Total layanan.
- Total portofolio.
- Total artikel.
- Total testimoni.
- Total pesan masuk.
- Pesan belum dibaca.
- Aktivitas terbaru.

Statistik harus dinamis dari database.

### 2. Profil Website
- Nama usaha.
- Logo.
- Favicon.
- Deskripsi.
- Sejarah.
- Visi.
- Misi.
- Alamat.
- WhatsApp.
- Telepon.
- Email.
- Area layanan.
- Social media.
- Google Maps.

### 3. Layanan
CRUD lengkap:
- Create.
- Read.
- Update.
- Delete.
- Upload thumbnail.
- Upload gambar utama.
- Galeri.
- Kategori.
- Deskripsi.
- Slug.
- SEO.
- Status aktif/nonaktif.
- Sort order.

### 4. Kategori Layanan
CRUD lengkap.

### 5. Portofolio
CRUD lengkap:
- Judul.
- Slug.
- Kategori.
- Deskripsi.
- Foto utama.
- Multiple gallery.
- Lokasi.
- Tahun.
- Status.
- SEO.

### 6. Kategori Portofolio
CRUD lengkap.

### 7. Artikel
CRUD lengkap:
- Judul.
- Slug.
- Thumbnail.
- Kategori.
- Excerpt.
- Rich text editor.
- Draft.
- Published.
- Jadwal publikasi jika memungkinkan.
- SEO.

### 8. Kategori Artikel
CRUD lengkap.

### 9. Testimoni
CRUD lengkap:
- Nama pelanggan.
- Foto opsional.
- Isi testimoni.
- Rating.
- Status.
- Urutan tampil.

Jangan membuat testimoni palsu yang dianggap berasal dari pelanggan asli.

### 10. Pesan Masuk
Fitur:
- Daftar pesan.
- Detail.
- Tandai dibaca.
- Tandai ditindaklanjuti.
- Hapus.
- Search.
- Filter status.

### 11. Halaman Statis
Kelola:
- Tentang Kami.
- Visi dan Misi.
- Kebijakan Privasi.
- Syarat dan Ketentuan.

### 12. Pengaturan SEO
- Default meta title.
- Default meta description.
- Open Graph.
- Favicon.
- Sitemap.
- Robots.

### 13. Pengaturan Website
- Logo.
- Kontak.
- WhatsApp.
- Alamat.
- Social media.
- Footer.
- Informasi usaha.

Semua modul harus benar-benar terhubung ke database.

---

# 8. DATABASE POSTGRESQL

Buat database yang terstruktur.

Tabel minimal:

- users.
- settings.
- pages.
- services.
- service_categories.
- service_images.
- portfolios.
- portfolio_categories.
- portfolio_images.
- articles.
- article_categories.
- testimonials.
- contact_messages.

Buat:
- Migration.
- Model.
- Eloquent relationship.
- Foreign key.
- Index.
- Unique constraint.
- Factory.
- Seeder.

Pastikan semua relasi berjalan.

Gunakan PostgreSQL sebagai database utama.

Buat ERD dan simpan sebagai dokumentasi.

Gunakan seeder untuk data awal.

Jangan menyimpan password dalam bentuk plaintext.

---

# 9. ARSITEKTUR APLIKASI

Terapkan:

- MVC.
- Clean Code.
- DRY.
- SOLID.
- Service Layer jika diperlukan.
- Form Request Validation.
- Resource Controller.
- Middleware.
- Reusable Blade Components.
- Named Routes.
- Eloquent ORM.

Pisahkan controller:
- Admin.
- Frontend.

Pisahkan view:
- Frontend.
- Admin.
- Components.

Jangan menumpuk seluruh kode dalam satu file.

---

# 10. SECURITY

Terapkan keamanan:

- Authentication.
- Authorization.
- CSRF.
- XSS prevention.
- SQL injection prevention.
- Validasi input.
- Secure upload.
- Unique filename.
- Password hashing.
- Login rate limiting.
- Secure session.
- Mass assignment protection.
- Error handling.

Batasi upload hanya untuk format file yang aman.

Jangan mengizinkan file executable.

Jangan menampilkan detail error internal pada production.

---

# 11. SEO DAN PERFORMANCE

Implementasikan:
- Dynamic title.
- Dynamic meta description.
- Canonical URL.
- Open Graph.
- Sitemap XML.
- Robots.txt.
- Schema.org yang sesuai.
- Semantic HTML.
- Breadcrumb.
- Alt image.
- Lazy loading.
- Responsive images.
- Database indexing.
- Eager loading.
- Pagination.
- Query optimization.
- Asset minification.

Optimalkan website agar cepat dan mudah diindeks mesin pencari.

---

# 12. RESPONSIVE DESIGN

Pastikan seluruh halaman berjalan baik di:
- Desktop.
- Laptop.
- Tablet.
- Smartphone.

Gunakan mobile-first design.

Pastikan:
- Tidak ada horizontal overflow.
- Navbar mobile berfungsi.
- Sidebar admin responsif.
- Form nyaman digunakan.
- Tabel admin responsif.
- Gambar menyesuaikan layar.
- Tombol mudah digunakan.

---

# 13. DEMO DATA

Buat data awal untuk:
- Kategori layanan.
- 10 layanan.
- Kategori portofolio.
- Beberapa portofolio contoh.
- Kategori artikel.
- Beberapa artikel contoh.

Gunakan gambar yang relevan dengan aluminium dan kaca.

Konten demo harus dapat diganti oleh admin.

Jangan mengklaim data demo sebagai proyek asli atau testimoni pelanggan asli.

---

# 14. TESTING

Lakukan testing terhadap seluruh aplikasi.

Pastikan:

AUTH:
- Login.
- Logout.
- Proteksi dashboard.

CRUD:
- Tambah.
- Tampilkan.
- Edit.
- Hapus.

FRONTEND:
- Semua halaman terbuka.
- Konten berasal dari database.
- Slug berfungsi.
- Filter berfungsi.
- Pagination berfungsi.

IMAGE:
- Upload.
- Preview.
- Update.
- Delete.
- Galeri.

CONTACT:
- Form terkirim.
- Data tersimpan.
- Pesan tampil di admin.

WHATSAPP:
- Nomor dinamis.
- Link benar.
- Pesan otomatis benar.

SEO:
- Metadata dinamis.
- Sitemap.
- Robots.

Jalankan seluruh automated test.

Jika terdapat kegagalan, perbaiki dan jalankan kembali.

---

# 15. DOKUMENTASI DAN DEPLOYMENT

Buat:
- README.md.
- .env.example.
- PROJECT_OVERVIEW.md.
- DATABASE_DESIGN.md.
- DEVELOPMENT_LOG.md.

Dokumentasikan:
- Instalasi.
- Konfigurasi PostgreSQL.
- Konfigurasi Laravel.
- Migration.
- Seeder.
- Akun admin.
- Storage.
- Build frontend.
- Menjalankan aplikasi.
- Deployment VPS.
- Backup database.

Pastikan project dapat dijalankan dari awal mengikuti README.

---

# 16. ATURAN EKSEKUSI AUTONOMOUS

INI ADALAH BAGIAN PALING PENTING.

Saya memberikan mandat kepada Anda untuk mengerjakan seluruh project secara mandiri.

Ikuti aturan berikut:

1. LANGSUNG mulai mengerjakan project.
2. Jangan meminta konfirmasi sebelum membuat file.
3. Jangan meminta persetujuan desain.
4. Jangan berhenti setelah membuat dokumentasi.
5. Jangan berhenti setelah membuat database.
6. Jangan berhenti setelah membuat dashboard.
7. Jangan berhenti setelah membuat frontend.
8. Jangan meminta saya mereview setiap phase.
9. Jangan menunggu perintah lanjutan.
10. Jangan hanya memberikan instruksi kepada saya untuk menjalankan kode yang seharusnya dapat Anda jalankan sendiri.
11. Jika menemukan bug, perbaiki sendiri.
12. Jika dependency gagal, cari alternatif kompatibel.
13. Jika migration gagal, perbaiki.
14. Jika terdapat error frontend, perbaiki.
15. Jika terdapat error backend, perbaiki.
16. Jika ada fitur belum berfungsi, implementasikan sampai berfungsi.
17. Jangan menghapus fitur yang diwajibkan hanya karena mengalami kesulitan.
18. Jangan menggunakan dummy behavior untuk menggantikan fitur CRUD sebenarnya.
19. Jangan menyatakan testing berhasil jika belum menjalankannya.
20. Jangan menyatakan project selesai jika masih terdapat fitur wajib yang belum diimplementasikan.

Jika membutuhkan informasi yang belum tersedia, gunakan konfigurasi default yang aman dan sediakan pengaturan agar saya dapat mengubahnya melalui dashboard.

Untuk informasi seperti nomor WhatsApp, email, alamat, dan password admin:
- Jangan mengarang informasi asli.
- Gunakan placeholder yang jelas.
- Sediakan pengaturan untuk menggantinya.
- Buat akun admin melalui seeder atau command yang aman.

Jika ada keterbatasan environment, selesaikan bagian lain yang masih dapat dikerjakan dan dokumentasikan keterbatasannya.

---

# 17. URUTAN EKSEKUSI INTERNAL

Kerjakan seluruh urutan berikut secara otomatis tanpa menunggu persetujuan:

PHASE 1:
Project initialization dan environment.

PHASE 2:
Database architecture dan migration.

PHASE 3:
Authentication dan security.

PHASE 4:
Admin dashboard.

PHASE 5:
Seluruh modul CMS CRUD.

PHASE 6:
Frontend website.

PHASE 7:
Integrasi database dan WhatsApp.

PHASE 8:
SEO dan performance.

PHASE 9:
Responsive design.

PHASE 10:
Testing dan bug fixing.

PHASE 11:
Dokumentasi dan finalisasi.

Setelah satu phase selesai, langsung masuk ke phase berikutnya.

Jangan mengirim pertanyaan atau meminta review di tengah pengerjaan.

---

# 18. FINAL ACCEPTANCE CRITERIA

Project hanya boleh dinyatakan selesai apabila:

- [ ] Laravel 13 berjalan.
- [ ] PostgreSQL terhubung.
- [ ] Database migration berhasil.
- [ ] Seeder berhasil.
- [ ] Admin login berfungsi.
- [ ] Dashboard berfungsi.
- [ ] Semua modul CRUD berfungsi.
- [ ] Upload gambar berfungsi.
- [ ] Galeri berfungsi.
- [ ] Frontend selesai.
- [ ] Konten frontend dinamis.
- [ ] WhatsApp berfungsi.
- [ ] Form kontak berfungsi.
- [ ] SEO diterapkan.
- [ ] Responsive.
- [ ] Security diterapkan.
- [ ] Automated testing dijalankan.
- [ ] Error kritis diselesaikan.
- [ ] Dokumentasi tersedia.
- [ ] Aplikasi siap dijalankan.

---

# 19. LAPORAN AKHIR

Setelah semua pekerjaan selesai, berikan laporan akhir yang mencakup:

1. Ringkasan aplikasi yang telah dibuat.
2. Fitur frontend yang selesai.
3. Fitur admin yang selesai.
4. Daftar tabel database.
5. Struktur folder penting.
6. Teknologi yang digunakan.
7. Hasil testing aktual.
8. Daftar file dokumentasi.
9. Cara menjalankan aplikasi.
10. Cara login admin.
11. Konfigurasi yang masih harus diisi pemilik usaha.
12. Keterbatasan yang belum dapat diselesaikan, jika ada.

Jangan membuat klaim palsu mengenai fitur atau pengujian.

# FINAL COMMAND

**MULAI SEKARANG.**

Bangun seluruh website AZKAMANDIRI dari awal sampai selesai.

Kerjakan seluruh implementasi secara autonomous, end-to-end, tanpa meminta review, persetujuan, atau instruksi lanjutan dari saya.

Jangan berhenti pada tahap perencanaan.

Jangan hanya menghasilkan kode contoh.

Jangan menunggu saya mengetik "lanjut".

Saya hanya akan melakukan review setelah seluruh aplikasi selesai dibangun, terintegrasi, dan telah melalui proses testing.

**TARGET: SATU KALI PROMPT, SELURUH PROJECT SELESAI.**