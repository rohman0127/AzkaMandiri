-- AzkaMandiri MySQL Database Dump for InfinityFree Deployment
-- Generated: 2026-11-14 04:33:20
SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- Table structure for table `article_categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `article_categories`;
CREATE TABLE `article_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `article_categories_slug_unique` (`slug`),
  KEY `article_categories_sort_order_index` (`sort_order`),
  KEY `article_categories_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `article_categories`
INSERT INTO `article_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Tips & Panduan', 'tips-panduan', 'Tips bermanfaat seputar pemilihan, perawatan, dan instalasi aluminium kaca.', '1', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `article_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Material & Spesifikasi', 'material-spesifikasi', 'Mengenal kualitas profil aluminium, jenis kaca, dan aksesoris bangunan.', '2', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `article_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Inspirasi Desain', 'inspirasi-desain', 'Inspirasi model pintu, jendela, partisi, dan kanopi arsitektur modern.', '3', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `articles`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `article_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `author_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin AzkaMandiri',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `views_count` int NOT NULL DEFAULT '0',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`),
  KEY `articles_article_category_id_foreign` (`article_category_id`),
  KEY `articles_status_index` (`status`),
  KEY `articles_published_at_index` (`published_at`),
  CONSTRAINT `articles_article_category_id_foreign` FOREIGN KEY (`article_category_id`) REFERENCES `article_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `articles`
INSERT INTO `articles` (`id`, `article_category_id`, `title`, `slug`, `thumbnail`, `excerpt`, `content`, `author_name`, `status`, `published_at`, `views_count`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('1', '2', 'Panduan Memilih Kusen Aluminium: YKK vs Alexindo vs Dacon', 'panduan-memilih-kusen-aluminium-ykk-vs-alexindo', '/assets/images/articles/panduan-memilih-kusen-aluminium-ykk-vs-alexindo.svg', 'Bingung menentukan merek kusen aluminium untuk rumah Anda? Simak perbandingan ketebalan profil, warna, kelebihan, dan kisaran harganya di sini.', 'Dalam memilih kusen aluminium untuk rumah tinggal maupun ruko, ada tiga merek ternama yang paling sering digunakan di Indonesia: YKK AP, Alexindo, dan Dacon.\n\n### 1. Profil YKK AP (Kualitas Premium)\nYKK AP dikenal sebagai standar tertinggi kusen aluminium di Indonesia. Keunggulannya terletak pada ketebalan dinding profil (mencapai 1.35mm - 1.4mm), komposisi paduan aluminium murni (Alloy 6063), dan finishing anodizing yang sangat tahan gores serta tahan paparan asam garam pantai. Kusen YKK memiliki harga paling tinggi namun memiliki durabilitas paling panjang.\n\n### 2. Profil Alexindo (Pilihan Terpopuler)\nAlexindo adalah merek yang paling populer dan banyak digunakan oleh kontraktor maupun pemilik rumah pribadi. Menawarkan ketebalan ideal (sekitar 1.0mm - 1.15mm) dengan variasi warna powder coating yang luas. Nilai keekonomisannya sangat baik dengan kualitas yang kokoh dan tahan puluhan tahun.\n\n### 3. Profil Dacon & Inkalum (Ekonomis)\nBagi Anda yang memiliki anggaran terukur, profil Dacon atau Inkalum memberikan alternatif yang sangat baik. Ketebalan profil berkisar 0.8mm - 0.95mm yang cukup kokoh untuk jendela dan sekat partisi interior.\n\nAzkaMandiri siap membantu Anda memilih profil yang paling tepat sesuai kebutuhan desain dan anggaran proyek Anda. Hubungi kami untuk konsultasi gratis!', 'Tim Teknis AzkaMandiri', 'published', '2026-11-04 03:57:55', '142', 'Panduan Memilih Kusen Aluminium: YKK vs Alexindo vs Dacon – Artikel AzkaMandiri', 'Bingung menentukan merek kusen aluminium untuk rumah Anda? Simak perbandingan ketebalan profil, warna, kelebihan, dan kisaran harganya di sini.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `articles` (`id`, `article_category_id`, `title`, `slug`, `thumbnail`, `excerpt`, `content`, `author_name`, `status`, `published_at`, `views_count`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('2', '1', '5 Keunggulan Kaca Tempered untuk Pintu, Kanopi, dan Partisi Rumah', 'keunggulan-kaca-tempered-untuk-hunian', '/assets/images/articles/keunggulan-kaca-tempered-untuk-hunian.svg', 'Mengapa arsitek modern selalu merekomendasikan kaca tempered untuk area rawan benturan? Ketahui alasan keamanan dan estetika di balik kepopulerannya.', 'Kaca tempered kini menjadi standar keselamatan wajib dalam arsitektur modern. Berikut adalah 5 alasan utama mengapa Anda wajib mempertimbangkan kaca tempered:\n\n1. **Kekuatan Mekanis Hingga 5 Kali Lipat:** Kaca tempered diproses dengan pemanasan termal terkontrol hingga 700°C yang mengubah struktur molekulnya menjadi jauh lebih padat dan tahan benturan keras.\n2. **Toleransi Perubahan Suhu Ekstrem:** Mampu menahan perbedaan suhu hingga 200°C tanpa retak, sangat aman untuk kanopi atap yang terpapar sinar matahari terik.\n3. **Faktor Keamanan Tingkat Tinggi (Safety Glass):** Jika terkena benturan luar biasa melampaui batas elastisitasnya, kaca tempered tidak pecah menjadi pecahan tajam meruncing, melainkan butiran-butiran tumpul seperti jagung yang minim resiko melukai tubuh.\n4. **Tampilan Bersih & Minimalis:** Ketebalannya yang kokoh memungkinkan pembuatan pintu dan sekat frameless (tanpa kusen bingkai) yang elegan.\n5. **Meningkatkan Nilai Properti:** Hunian dengan instalasi kaca tempered berkualitas memiliki nilai jual dan prestise yang lebih tinggi.', 'Tim Arsitektur AzkaMandiri', 'published', '2026-11-08 03:57:55', '98', '5 Keunggulan Kaca Tempered untuk Pintu, Kanopi, dan Partisi Rumah – Artikel AzkaMandiri', 'Mengapa arsitek modern selalu merekomendasikan kaca tempered untuk area rawan benturan? Ketahui alasan keamanan dan estetika di balik kepopulerannya.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `articles` (`id`, `article_category_id`, `title`, `slug`, `thumbnail`, `excerpt`, `content`, `author_name`, `status`, `published_at`, `views_count`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('3', '1', 'Cara Merawat Pintu dan Jendela Aluminium Agar Selalu Halus dan Berkilau', 'tips-merawat-pintu-dan-jendela-aluminium', '/assets/images/articles/tips-merawat-pintu-dan-jendela-aluminium.svg', 'Perawatan aluminium sebenarnya sangat mudah jika Anda mengetahui trik dasarnya. Hindari cairan kimia keras yang dapat merusak lapisan cat.', 'Kusen dan pintu aluminium terkenal minim perawatan, namun dengan langkah perawatan sederhana berikut, tampilannya akan selalu seperti baru:\n\n- **Bersihkan Rel Sliding Secara Berkala:** Debu dan pasir kecil pada rel geser sering menjadi penyebab roda macet. Cukup sedot debu dengan vacuum cleaner atau sikat kecil seminggu sekali.\n- **Gunakan Sabun Lembut (Netral):** Campurkan air hangat dengan sedikit sabun cuci piring lembut. Hindari pembersih berbahan asam tinggi atau tiner yang dapat merusak lapisan powder coating.\n- **Pelumasan Hardware:** Berikan beberapa tetes oli mesin jahit atau pelumas silikon spray pada engsel dan silinder kunci setiap 6 bulan sekali.\n- **Periksa Karet Kaca (Gasket):** Pastikan karet penjepit kaca tetap elastis dan tidak getas agar kekedapan air tetap optimal saat musim hujan.', 'Admin AzkaMandiri', 'published', '2026-11-11 03:57:55', '67', 'Cara Merawat Pintu dan Jendela Aluminium Agar Selalu Halus dan Berkilau – Artikel AzkaMandiri', 'Perawatan aluminium sebenarnya sangat mudah jika Anda mengetahui trik dasarnya. Hindari cairan kimia keras yang dapat merusak lapisan cat.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `articles` (`id`, `article_category_id`, `title`, `slug`, `thumbnail`, `excerpt`, `content`, `author_name`, `status`, `published_at`, `views_count`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('4', '3', 'Inspirasi Partisi Kaca Minimalis untuk Kantor Nyaman dan Kedap Suara', 'inspirasi-partisi-kaca-kantor-minimalis', '/assets/images/articles/inspirasi-partisi-kaca-kantor-minimalis.svg', 'Ciptakan suasana kantor modern yang kolaboratif namun tetap tenang dengan kombinasi partisi kaca frameless dan profil aluminium ramping.', 'Tata ruang kantor terbuka (open plan) sering menghadapi kendala kebisingan yang mengganggu konsentrasi karyawan. Penggunaan partisi aluminium kaca tempered adalah solusi paling seimbang.\n\nDengan partisi kaca, cahaya alami bebas masuk ke seluruh penjuru ruangan kerja sehingga menghemat biaya listrik pencahayaan, sementara ruangan tetap kedap suara saat meeting penting berlangsung. Tambahan aksen stiker sandblast bermotif korporat dapat memberikan sentuhan elegan dan profesional bagi setiap klien yang berkunjung.', 'Tim Desain AzkaMandiri', 'published', '2026-11-13 03:57:55', '54', 'Inspirasi Partisi Kaca Minimalis untuk Kantor Nyaman dan Kedap Suara – Artikel AzkaMandiri', 'Ciptakan suasana kantor modern yang kolaboratif namun tetap tenang dengan kombinasi partisi kaca frameless dan profil aluminium ramping.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `cache`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `cache`
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_about_short', 's:193:\"AzkaMandiri hadir memberikan layanan pemasangan, pembuatan, dan pengerjaan aluminium serta kaca berkualitas dengan hasil rapi dan profesional untuk rumah, ruko, kantor, hingga gedung komersial.\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_address', 's:85:\"Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_business_hours', 's:65:\"Senin – Sabtu: 08.00 – 17.00 WIB (Konsultasi WhatsApp 24 Jam)\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_email', 's:22:\"kontak@azkamandiri.com\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_facebook_url', 's:42:\"https://facebook.com/azkamandiri.aluminium\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_favicon_path', 's:25:\"/assets/brand/favicon.svg\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_google_maps_embed', 's:273:\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63456.63583272671!2d106.68060868846395!3d-6.308351543884898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fa0679883581%3A0x6758622f309a4d80!2sTangerang%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid\";', '2109989561');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_instagram_url', 's:43:\"https://instagram.com/azkamandiri.aluminium\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_logo_dark_path', 's:38:\"/assets/brand/logo-horizontal-dark.svg\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_logo_path', 's:33:\"/assets/brand/logo-horizontal.svg\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_meta_description', 's:155:\"Jasa pembuatan dan pemasangan kusen aluminium, jendela aluminium, pintu kaca tempered, partisi ruko, kanopi kaca, dan shower box terpercaya di Jabodetabek.\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_meta_keywords', 's:138:\"kusen aluminium, jendela aluminium, pintu aluminium, partisi kaca, kaca tempered jabodetabek, kanopi kaca, shower box bintaro, azkamandiri\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_meta_title', 's:61:\"AzkaMandiri – Jasa Aluminium & Kaca Berkualitas Profesional\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_og_image_path', 's:32:\"assets/brand/logo-horizontal.svg\";', '2109988885');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_phone_number', 's:17:\"+62 819-3273-5383\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_service_areas', 's:115:\"Jakarta Selatan, Jakarta Barat, Tangerang Selatan, Tangerang Kota, BSD City, Bintaro, Depok, Bekasi, dan sekitarnya\";', '2109989561');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_site_name', 's:11:\"AzkaMandiri\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_tiktok_url', 's:31:\"https://tiktok.com/@azkamandiri\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_whatsapp_number', 's:13:\"6281932735383\";', '2109989538');
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('azkamandiri-cache-setting_youtube_url', 's:32:\"https://youtube.com/@azkamandiri\";', '2109989538');

-- --------------------------------------------------------
-- Table structure for table `cache_locks`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `contact_messages`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `ip_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `contact_messages`
INSERT INTO `contact_messages` (`id`, `name`, `phone_number`, `email`, `subject`, `message`, `status`, `ip_address`, `created_at`, `updated_at`) VALUES ('1', 'Bpk. Ridwan', '081299887766', 'ridwan.sample@example.com', 'Tanya Biaya Kusen Aluminium Rumah 2 Lantai', 'Halo AzkaMandiri, saya berencana merenovasi jendela rumah di daerah Bintaro. Ada sekitar 12 titik jendela casement dan 2 pintu sliding. Apakah bisa dijadwalkan survei ke lokasi akhir pekan ini?', 'unread', '127.0.0.1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `contact_messages` (`id`, `name`, `phone_number`, `email`, `subject`, `message`, `status`, `ip_address`, `created_at`, `updated_at`) VALUES ('2', 'Ibu Cynthia', '081311223344', 'cynthia.sample@example.com', 'Pemasangan Kanopi Kaca Carport', 'Selamat siang, mohon info estimasi harga per meter untuk kanopi kaca tempered laminated ukuran 4x5 meter. Rangka hollow galvanis. Terima kasih.', 'read', '127.0.0.1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `failed_jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `job_batches`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `jobs`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `migrations`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_11_14_000001_create_settings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_11_14_000002_create_pages_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_11_14_000003_create_service_categories_and_services_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_11_14_000004_create_portfolio_categories_and_portfolios_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_11_14_000005_create_article_categories_and_articles_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_11_14_000006_create_testimonials_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_11_14_000007_create_contact_messages_table', '1');

-- --------------------------------------------------------
-- Table structure for table `pages`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`),
  KEY `pages_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `pages`
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Tentang Kami', 'tentang-kami', 'AzkaMandiri adalah penyedia jasa terpercaya di bidang fabrikasi dan pemasangan aluminium serta kaca untuk kebutuhan residensial dan komersial di kawasan Jabodetabek dan sekitarnya. Kami berkomitmen memberikan solusi arsitektural yang fungsional, modern, dan tahan lama.', 'Tentang AzkaMandiri – Jasa Aluminium & Kaca Terpercaya', 'Mengenal AzkaMandiri lebih dekat, sejarah, visi misi dan keunggulan kami dalam jasa pemasangan kusen aluminium dan kaca.', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Kebijakan Privasi', 'kebijakan-privasi', 'Kebijakan Privasi ini menjelaskan bagaimana AzkaMandiri mengumpulkan, menggunakan, dan melindungi informasi pribadi yang Anda berikan saat menggunakan layanan atau website kami. Kami menghargai kerahasiaan data Anda dan berkomitmen menjaganya dengan standar keamanan yang baik.', 'Kebijakan Privasi – AzkaMandiri', 'Kebijakan privasi pengunjung website dan pelanggan jasa aluminium AzkaMandiri.', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Syarat dan Ketentuan', 'syarat-ketentuan', 'Syarat dan Ketentuan ini mengatur pemesanan layanan, survei lokasi, pembayaran bertahap, dan garansi pengerjaan yang disepakati antara pelanggan dan AzkaMandiri.', 'Syarat dan Ketentuan Layanan – AzkaMandiri', 'Syarat dan ketentuan pemesanan jasa aluminium dan kaca di AzkaMandiri.', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');

-- --------------------------------------------------------
-- Table structure for table `password_reset_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for table `portfolio_categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `portfolio_categories`;
CREATE TABLE `portfolio_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portfolio_categories_slug_unique` (`slug`),
  KEY `portfolio_categories_sort_order_index` (`sort_order`),
  KEY `portfolio_categories_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `portfolio_categories`
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Residensial', 'residensial', 'Proyek pemasangan aluminium dan kaca untuk rumah tinggal, cluster, dan perumahan.', '1', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Komersial & Kantor', 'komersial-kantor', 'Pengerjaan partisi kantor, gedung bertingkat, dan ruang kerja profesional.', '2', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Ruko & Fasad Toko', 'ruko-fasad-toko', 'Fasad etalase kaca, pintu kaca folding, dan kanopi ruko.', '3', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `portfolio_images`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `portfolio_images`;
CREATE TABLE `portfolio_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `portfolio_id` bigint unsigned NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `portfolio_images_portfolio_id_foreign` (`portfolio_id`),
  CONSTRAINT `portfolio_images_portfolio_id_foreign` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `portfolio_images`
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('1', '1', '/assets/images/portfolios/proyek-rumah-mewah-bsd.svg', 'Dokumentasi Proyek: Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', '2', '/assets/images/portfolios/partisi-kantor-scbd.svg', 'Dokumentasi Proyek: Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('3', '3', '/assets/images/portfolios/kanopi-kaca-villa-bogor.svg', 'Dokumentasi Proyek: Kanopi Kaca Tempered Laminated & Carport Modern', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('4', '4', '/assets/images/portfolios/shower-screen-apartemen-kemang.svg', 'Dokumentasi Proyek: Frameless Shower Screen Tempered Kamar Mandi', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('5', '5', '/assets/images/portfolios/pintu-lipat-folding-bintaro.svg', 'Dokumentasi Proyek: Pintu Lipat Aluminium 6 Daun Teras Belakang', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('6', '6', '/assets/images/portfolios/etalase-showroom-alam-sutera.svg', 'Dokumentasi Proyek: Fasad Kaca Display Showroom & Toko Modern', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `portfolios`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `portfolios`;
CREATE TABLE `portfolios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `portfolio_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completion_year` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portfolios_slug_unique` (`slug`),
  KEY `portfolios_portfolio_category_id_foreign` (`portfolio_category_id`),
  KEY `portfolios_sort_order_index` (`sort_order`),
  KEY `portfolios_is_featured_index` (`is_featured`),
  KEY `portfolios_is_active_index` (`is_active`),
  CONSTRAINT `portfolios_portfolio_category_id_foreign` FOREIGN KEY (`portfolio_category_id`) REFERENCES `portfolio_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `portfolios`
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('1', '1', 'Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal', 'proyek-rumah-mewah-bsd', 'Bpk. Hendra Wijaya', 'Cluster Greenwich Park, BSD City, Tangerang', '2025', 'Fabrikasi dan pemasangan kusen aluminium Alexindo hitam powder coating untuk seluruh jendela casement dan pintu sliding balkon.', 'Proyek ini mencakup pemasangan kusen aluminium tipe 4 inch dengan finishing hitam matte powder coating pada rumah 2 lantai.\n\nKlien menginginkan bukaan kaca yang lebar untuk memaksimalkan pemandangan taman samping dan sirkulasi udara alami. Seluruh kaca menggunakan kaca bening 6mm Asahimas dengan peredaman suara maksimal.', '/assets/images/portfolios/proyek-rumah-mewah-bsd.svg', '1', '1', '1', 'Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal – Portofolio AzkaMandiri', 'Fabrikasi dan pemasangan kusen aluminium Alexindo hitam powder coating untuk seluruh jendela casement dan pintu sliding balkon.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('2', '2', 'Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD', 'partisi-kantor-scbd', 'PT Sinergi Dinamika Abadi', 'Sudirman Central Business District (SCBD), Jakarta Selatan', '2025', 'Penyekat ruangan meeting dan direksi menggunakan kaca tempered 12mm frameless dengan aksesoris engsel tanam Dekkson.', 'Pengerjaan partisi kaca interior kantor seluas 180 m2. Menggunakan sistem frameless dengan profil U stainless tanam di lantai dan plafon akustik.\n\nDilengkapi pintu kaca ganda patch fitting floor hinge heavy duty serta stiker kaca sandblast bermotif garis minimalis untuk menjaga privasi rapat bisnis.', '/assets/images/portfolios/partisi-kantor-scbd.svg', '2', '1', '1', 'Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD – Portofolio AzkaMandiri', 'Penyekat ruangan meeting dan direksi menggunakan kaca tempered 12mm frameless dengan aksesoris engsel tanam Dekkson.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('3', '1', 'Kanopi Kaca Tempered Laminated & Carport Modern', 'kanopi-kaca-villa-bogor', 'Ibu Ratna Dewi', 'Sentul City, Bogor, Jawa Barat', '2025', 'Konstruksi kanopi kaca tempered laminated 5+5mm dengan rangka baja hollow galvanis 50x100mm cat hitam doff anti karat.', 'Kanopi carport dengan bentang 6 x 5 meter tanpa tiang tengah yang mengganggu ruang gerak manuver kendaraan. Menggunakan kaca laminated tahan benturan dengan lapisan film UV protection.\n\nSistem talang air tersembunyi dirancang rapi agar air hujan mengalir lancar tanpa resiko cipratan.', '/assets/images/portfolios/kanopi-kaca-villa-bogor.svg', '3', '1', '1', 'Kanopi Kaca Tempered Laminated & Carport Modern – Portofolio AzkaMandiri', 'Konstruksi kanopi kaca tempered laminated 5+5mm dengan rangka baja hollow galvanis 50x100mm cat hitam doff anti karat.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('4', '1', 'Frameless Shower Screen Tempered Kamar Mandi', 'shower-screen-apartemen-kemang', 'Bpk. Aris Pratama', 'Kemang, Jakarta Selatan', '2026', 'Pemasangan sekat kaca shower box L-shape kaca tempered 10mm dengan fitting stainless steel 304 gold satin finish.', 'Shower box sudut L-shape yang memisahkan area kering dan basah secara elegan. Engsel kaca menggunakan material SUS 304 tahan karat jangka panjang.\n\nDisertai sealing silikon antimikroba (anti jamur) sehingga sudut kaca selalu bersih, bening, dan tidak mudah menghitam.', '/assets/images/portfolios/shower-screen-apartemen-kemang.svg', '4', '0', '1', 'Frameless Shower Screen Tempered Kamar Mandi – Portofolio AzkaMandiri', 'Pemasangan sekat kaca shower box L-shape kaca tempered 10mm dengan fitting stainless steel 304 gold satin finish.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('5', '1', 'Pintu Lipat Aluminium 6 Daun Teras Belakang', 'pintu-lipat-folding-bintaro', 'Bpk. Dian Sastro', 'Kebayoran Residences, Bintaro Jaya Sektor 7', '2026', 'Pintu folding aluminium 6 daun menghubungkan ruang keluarga dengan kolam renang privat, bukaan 100% lapang.', 'Pintu folding aluminium dengan rel bawah rata lantai (flush track) agar aman saat dilintasi anak-anak dan lansia. Roda rel bearing stainless berputar sangat halus tanpa hentakan.\n\nMemberikan efek ruangan multifungsi: tertutup kedap AC atau terbuka penuh saat acara keluarga besar.', '/assets/images/portfolios/pintu-lipat-folding-bintaro.svg', '5', '1', '1', 'Pintu Lipat Aluminium 6 Daun Teras Belakang – Portofolio AzkaMandiri', 'Pintu folding aluminium 6 daun menghubungkan ruang keluarga dengan kolam renang privat, bukaan 100% lapang.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('6', '3', 'Fasad Kaca Display Showroom & Toko Modern', 'etalase-showroom-alam-sutera', 'CV Cahaya Gemilang', 'Ruko Prominence Alam Sutera, Tangerang', '2026', 'Pemasangan curtain wall kaca fasad dan pintu kaca geser otomatis untuk showroom otomotif & aksesoris.', 'Fasad toko 2 lantai dengan bentang kaca 8 meter menggunakan frame aluminium tebal warna silver anodized. Hasil akhir rapi dan menonjolkan produk jualan di dalam showroom secara maksimal.', '/assets/images/portfolios/etalase-showroom-alam-sutera.svg', '6', '0', '1', 'Fasad Kaca Display Showroom & Toko Modern – Portofolio AzkaMandiri', 'Pemasangan curtain wall kaca fasad dan pintu kaca geser otomatis untuk showroom otomotif & aksesoris.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `service_categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_categories_slug_unique` (`slug`),
  KEY `service_categories_sort_order_index` (`sort_order`),
  KEY `service_categories_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `service_categories`
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Kusen & Pintu', 'kusen-pintu', 'Kusen dan daun pintu aluminium berbagai model untuk interior dan eksterior.', '1', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Jendela Modern', 'jendela-modern', 'Jendela aluminium model geser, jungkit, casement, dan pivot.', '2', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Partisi & Kaca', 'partisi-kaca', 'Penyekat ruangan kantor, ruko, dan kaca tempered standar arsitektur.', '3', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('4', 'Kanopi & Eksterior', 'kanopi-eksterior', 'Kanopi kaca tempered laminated dan fasad arsitektur modern.', '4', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('5', 'Interior & Kamar Mandi', 'interior-kamar-mandi', 'Shower screen kaca, kitchen set aluminium anti rayap, dan etalase toko.', '5', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('6', 'Pekerjaan Custom', 'pekerjaan-custom', 'Pembuatan profil khusus aluminium dan kaca sesuai spesifikasi arsitek.', '6', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');

-- --------------------------------------------------------
-- Table structure for table `service_images`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `service_images`;
CREATE TABLE `service_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint unsigned NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_images_service_id_foreign` (`service_id`),
  CONSTRAINT `service_images_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `service_images`
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('1', '1', '/assets/images/services/kusen-aluminium.svg', 'Pemasangan Kusen Aluminium oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('2', '2', '/assets/images/services/jendela-aluminium.svg', 'Pemasangan Jendela Aluminium oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('3', '3', '/assets/images/services/pintu-aluminium.svg', 'Pemasangan Pintu Aluminium oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('4', '4', '/assets/images/services/partisi-aluminium.svg', 'Pemasangan Partisi Aluminium oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('5', '5', '/assets/images/services/kaca-tempered.svg', 'Pemasangan Kaca Tempered oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('6', '6', '/assets/images/services/kanopi-kaca.svg', 'Pemasangan Kanopi Kaca oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('7', '7', '/assets/images/services/shower-box.svg', 'Pemasangan Shower Box oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('8', '8', '/assets/images/services/etalase-kaca.svg', 'Pemasangan Etalase Kaca oleh AzkaMandiri', '1', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('9', '9', '/assets/images/services/lemari-aluminium.svg', 'Pemasangan Lemari Aluminium oleh AzkaMandiri', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES ('10', '10', '/assets/images/services/custom-aluminium-kaca.svg', 'Pemasangan Aluminium dan Kaca Custom oleh AzkaMandiri', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `services`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `service_category_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_info` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `features` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `services_slug_unique` (`slug`),
  KEY `services_service_category_id_foreign` (`service_category_id`),
  KEY `services_sort_order_index` (`sort_order`),
  KEY `services_is_featured_index` (`is_featured`),
  KEY `services_is_active_index` (`is_active`),
  CONSTRAINT `services_service_category_id_foreign` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `services`
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('1', '1', 'Kusen Aluminium', 'kusen-aluminium', 'Pemasangan kusen aluminium 3 inch dan 4 inch berkualitas tinggi dengan finishing rapi, presisi miter joint, dan tahan cuaca.', 'AzkaMandiri melayani pembuatan dan pemasangan kusen aluminium untuk berbagai kebutuhan bangunan seperti rumah tinggal, kantor, ruko, hingga gedung bertingkat.\r\n\r\nKami menyediakan pilihan profil merek terpercaya seperti Alexindo, YKK AP, Dacon, Inkalum, dan Forta. Setiap sambungan dipotong dengan mesin presisi miter saw sehingga sambungan sudut rapat tanpa celah kasar.\r\n\r\nPilihan warna meliputi Anodized Silver, Anodized Hitam, Anodized Cokelat, serta Powder Coating Putih, Cream, Urat Kayu (Wood Grain), dan warna custom lainnya.', '/assets/images/services/kusen-aluminium.svg', '/assets/images/services/kusen-aluminium.svg', 'Mulai Rp 120.000 / meter lari', '[\"Pilihan Profil 3\\\" dan 4\\\"\",\"Merek Alexindo, YKK, Dacon\",\"Powder Coating & Anodized\",\"Anti Rayap & Anti Karat\",\"Garansi Pemasangan Rapi\"]', '1', '1', '1', 'Kusen Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pemasangan kusen aluminium 3 inch dan 4 inch berkualitas tinggi dengan finishing rapi, presisi miter joint, dan tahan cuaca.', '2026-11-14 03:57:54', '2026-11-14 04:01:00');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('2', '2', 'Jendela Aluminium', 'jendela-aluminium', 'Jendela aluminium modern model casement (jungkit), sliding (geser), pivot, dan fixed glass dengan seal kedap suara dan air.', 'Jendela aluminium AzkaMandiri dirancang untuk memaksimalkan sirkulasi udara dan pencahayaan alami tanpa mengorbankan estetika dan keamanan rumah Anda.\n\nDilengkapi dengan karet gasket EPDM berkualitas dan aksesoris handle kunci mutakhir (Kinlong, Dekkson, Hampton), jendela kami memastikan kekedapan suara yang prima serta proteksi anti bocor saat hujan lebat.', '/assets/images/services/jendela-aluminium.svg', '/assets/images/services/jendela-aluminium.svg', 'Mulai Rp 650.000 / unit', '[\"Model Casement, Sliding, Jungkit\",\"Karet Seal EPDM Tahan Bocor\",\"Kunci Kinlong & Dekkson Kokoh\",\"Bisa Custom Ukuran\",\"Kaca Polos \\/ Rayban \\/ Es\"]', '2', '1', '1', 'Jendela Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Jendela aluminium modern model casement (jungkit), sliding (geser), pivot, dan fixed glass dengan seal kedap suara dan air.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('3', '1', 'Pintu Aluminium', 'pintu-aluminium', 'Pintu swing, sliding, hingga pintu lipat (folding door) aluminium dengan desain minimalis elegan dan engsel berkualitas berat.', 'Pintu aluminium merupakan solusi ideal untuk pintu utama, pintu balkon, pintu taman, maupun pintu kamar mandi. Kami memproduksi berbagai model pintu aluminium yang kokoh dan awet.\n\nKeunggulan pintu aluminium kami adalah konstruksi sudut yang diperkuat siku baja internal, pergerakan roda bearing yang halus tanpa suara berdecit, serta daya tahan tinggi terhadap kelembapan dan serangan rayap.', '/assets/images/services/pintu-aluminium.svg', '/assets/images/services/pintu-aluminium.svg', 'Mulai Rp 1.400.000 / daun pintu', '[\"Pintu Swing, Geser, & Lipat\",\"Hardware Heavy-Duty\",\"Panel Kaca Tempered \\/ Aluminium Composite\",\"Tersedia Model Minimalis Modern\",\"Tahan Cuaca & Rayap\"]', '3', '1', '1', 'Pintu Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pintu swing, sliding, hingga pintu lipat (folding door) aluminium dengan desain minimalis elegan dan engsel berkualitas berat.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('4', '3', 'Partisi Aluminium', 'partisi-aluminium', 'Penyekat ruangan kantor dan komersial dengan frame aluminium kokoh dan kaca bening/buram yang memberikan kesan luas dan profesional.', 'Maksimalkan efisiensi ruang kantor atau ruko Anda dengan partisi aluminium dan kaca dari AzkaMandiri. Partisi ini memisahkan area kerja dengan tetap menjaga suasana terang, bersih, dan terbuka.\n\nKami juga menyediakan instalasi sandblast sticker untuk privasi ruang meeting serta integrasi jalur instalasi kabel elektrikal secara rapi.', '/assets/images/services/partisi-aluminium.svg', '/assets/images/services/partisi-aluminium.svg', 'Mulai Rp 450.000 / m2', '[\"Rangka Aluminium Kokoh\",\"Kombinasi Kaca Polos \\/ Buram \\/ Sandblast\",\"Peredaman Suara yang Baik\",\"Pengerjaan Cepat & Bersih\",\"Cocok untuk Kantor & Ruko\"]', '4', '1', '1', 'Partisi Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Penyekat ruangan kantor dan komersial dengan frame aluminium kokoh dan kaca bening/buram yang memberikan kesan luas dan profesional.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('5', '3', 'Kaca Tempered', 'kaca-tempered', 'Pemasangan kaca tempered 8mm, 10mm, 12mm bersertifikasi SNI dengan kekuatan benturan 5x lebih tangguh dari kaca biasa.', 'Kaca tempered adalah kaca safety yang telah diproses pemanasan termal tinggi hingga 700°C lalu didinginkan secara cepat. Menghasilkan kekuatan mekanis dan ketahanan panas yang luar biasa.\n\nSangat direkomendasikan untuk pintu frameless patch fitting, railing tangga, void balkon, kanopi, dan partisi dinding kaca gedung. Jika pecah, kaca tempered akan menjadi butiran tumpul kecil yang meminimalisir risiko cedera.', '/assets/images/services/kaca-tempered.svg', '/assets/images/services/kaca-tempered.svg', 'Mulai Rp 550.000 / m2 (8mm-12mm)', '[\"Standar Kaca SNI Resmi\",\"Kekuatan 5x Kaca Biasa\",\"Toleransi Suhu Ekstrem\",\"Tepian Polish Halus (Bevel\\/Flat)\",\"Aksesoris Stainless 304\"]', '5', '1', '1', 'Kaca Tempered – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pemasangan kaca tempered 8mm, 10mm, 12mm bersertifikasi SNI dengan kekuatan benturan 5x lebih tangguh dari kaca biasa.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('6', '4', 'Kanopi Kaca', 'kanopi-kaca', 'Kanopi carport dan teras dengan kaca tempered atau laminated dipadu rangka hollow besi/baja WF yang modern dan mewah.', 'Hadirkan tampilan fasad rumah mewah bergaya modern tropis dengan kanopi kaca AzkaMandiri. Struktur kanopi kami dihitung dengan cermat agar mampu menahan beban angin dan air hujan dengan aman.\n\nPenggunaan kaca tempered laminated dengan lembaran interlayer PVB memastikan perlindungan maksimal dari sinar UV sekaligus keamanan mutlak jika terjadi insiden kejatuhan benda.', '/assets/images/services/kanopi-kaca.svg', '/assets/images/services/kanopi-kaca.svg', 'Mulai Rp 1.350.000 / m2', '[\"Kaca Tempered Laminated 10mm-16mm\",\"Rangka Hollow Galvanis Anti Karat \\/ WF\",\"Sealant Khusus Struktural Anti Bocor\",\"Desain Modern & Bernilai Estetika Tinggi\",\"Garansi Kebocoran\"]', '6', '1', '1', 'Kanopi Kaca – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Kanopi carport dan teras dengan kaca tempered atau laminated dipadu rangka hollow besi/baja WF yang modern dan mewah.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('7', '5', 'Shower Box', 'shower-box', 'Penyekat kaca kamar mandi frameless tempered 10mm dengan aksesoris engsel dan pipa header stainless steel 304 anti karat.', 'Shower box atau shower screen kaca menjadikan kamar mandi Anda kering, bersih, dan berkelas hotel berbintang. Kami menyediakan model pintu swing dengan engsel glass-to-wall maupun sliding shower door yang hemat tempat.\n\nSemua aksesoris penjepit dan engsel menggunakan material stainless steel SUS 304 yang tahan terhadap kelembapan tinggi dan sabun kimia tanpa mengalami korosi.', '/assets/images/services/shower-box.svg', '/assets/images/services/shower-box.svg', 'Mulai Rp 2.200.000 / set', '[\"Kaca Tempered 10mm Safety\",\"Hardware Full Stainless SUS 304\",\"Karet Magnet Penutup Rapat\",\"Model Sudut L, U, atau Straight\",\"Bebas Kerak & Mudah Dibersihkan\"]', '7', '1', '1', 'Shower Box – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Penyekat kaca kamar mandi frameless tempered 10mm dengan aksesoris engsel dan pipa header stainless steel 304 anti karat.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('8', '5', 'Etalase Kaca', 'etalase-kaca', 'Etalase kaca display jualan untuk toko, apotek, konter HP, bakery, dan showroom dengan frame aluminium kokoh dan rapi.', 'Tingkatkan daya tarik produk jualan Anda dengan etalase kaca display custom buatan AzkaMandiri. Dibuat presisi dengan rak kaca bertingkat, pintu sliding beroda rel halus, dan kunci silinder aman.\n\nKami dapat menambahkan lampu LED strip tersembunyi untuk memberikan efek pencahayaan produk yang memukau calon pembeli Anda.', '/assets/images/services/etalase-kaca.svg', '/assets/images/services/etalase-kaca.svg', 'Mulai Rp 950.000 / unit', '[\"Custom Ukuran & Jumlah Rak\",\"Roda Kunci \\/ Roda Nylon Bergerak\",\"Lampu LED Showcase Opsional\",\"Kaca Bening Bervariasi 5-8mm\",\"Kunci Silinder Keamanan\"]', '8', '0', '1', 'Etalase Kaca – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Etalase kaca display jualan untuk toko, apotek, konter HP, bakery, dan showroom dengan frame aluminium kokoh dan rapi.', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('9', '5', 'Lemari Aluminium', 'lemari-aluminium', 'Kitchen set bawah/atas dan lemari pakaian berbahan aluminium composite panel (ACP) 100% anti rayap, tahan air, dan awet puluhan tahun.', 'Bosan dengan lemari kayu atau partikel board yang mudah lapuk dan dimakan rayap? Lemari aluminium dan kitchen set dari AzkaMandiri adalah solusi abadi untuk hunian Anda.\n\nDilapisi Aluminium Composite Panel (ACP) berkualitas dengan aneka pilihan warna glossy, matte, marmer, atau corak kayu, lemari ini sangat higienis, mudah dilap, dan tidak berbau jamur.', '/assets/images/services/lemari-aluminium.svg', '/assets/images/services/lemari-aluminium.svg', 'Mulai Rp 2.100.000 / meter lari', '[\"100% Bebas Rayap & Jamur\",\"Tahan Air & Lembap\",\"Panel ACP Aneka Corak & Warna\",\"Engsel Slow-Motion (Soft-Close)\",\"Konstruksi Kuat & Ringan\"]', '9', '0', '1', 'Lemari Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Kitchen set bawah/atas dan lemari pakaian berbahan aluminium composite panel (ACP) 100% anti rayap, tahan air, dan awet puluhan tahun.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES ('10', '6', 'Aluminium dan Kaca Custom', 'custom-aluminium-kaca', 'Pengerjaan spesialis desain khusus aluminium dan kaca sesuai gambar kerja arsitek, interior designer, atau kebutuhan unik proyek Anda.', 'Apakah Anda memiliki desain arsitektural yang unik dan membutuhkan ketelitian fabrikasi khusus? AzkaMandiri siap menerjemahkan sketsa atau gambar kerja AutoCAD Anda menjadi kenyataan.\n\nKami melayani pembuatan louvre kisi-kisi aluminium, curtain wall gedung mini, skylight kaca atap, aquarium raksasa, hingga booth pameran custom dengan standar presisi tinggi.', '/assets/images/services/custom-aluminium-kaca.svg', '/assets/images/services/custom-aluminium-kaca.svg', 'Berdasarkan Spesifikasi & Gambar Proyek', '[\"Konsultasi Desain & Gambar Kerja\",\"Fleksibilitas Bentuk & Dimensi\",\"Pilihan Paduan Material Lengkap\",\"Survei Lapangan Gratis\",\"Garansi Kepuasan Pelanggan\"]', '10', '1', '1', 'Aluminium dan Kaca Custom – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pengerjaan spesialis desain khusus aluminium dan kaca sesuai gambar kerja arsitek, interior designer, atau kebutuhan unik proyek Anda.', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `sessions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES ('MmrnhbGlxB2xiAfrieJnlZyZR3Li8JZRUM56UJ86', '1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36 Edg/158.0.0.0', 'eyJfdG9rZW4iOiI3amtyNVhENFBROElGeGRCUnN5RVBCaXU5ekJBSlNUWXdXWkQ0TVl2IiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiNGRlZTE4ZDBlMjZkODYzMTdhMjE4MTExYThhYjMyNjMyYWE5MWQ2MWZjMGE1ODZhMDY0NTMxYzcwMTQxYjI5NSJ9', '1794629594');

-- --------------------------------------------------------
-- Table structure for table `settings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`),
  KEY `settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `settings`
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('1', 'site_name', 'AzkaMandiri', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('2', 'brand_title', 'AzkaMandiri – Jasa Aluminium & Kaca', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('3', 'tagline', 'Solusi Aluminium & Kaca untuk Hunian dan Bangunan Anda', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('4', 'business_type', 'Jasa Pemasangan & Pembuatan Aluminium, Kaca & Custom Bangunan', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('5', 'about_short', 'AzkaMandiri hadir memberikan layanan pemasangan, pembuatan, dan pengerjaan aluminium serta kaca berkualitas dengan hasil rapi dan profesional untuk rumah, ruko, kantor, hingga gedung komersial.', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('6', 'business_history', 'Berawal dari dedikasi dan pengalaman bertahun-tahun para teknisi aluminium dan kaca, AzkaMandiri tumbuh sebagai mitra terpercaya bagi ratusan pemilik rumah, kontraktor, dan arsitek di area Jabodetabek. Kami mengutamakan ketepatan dimensi, kerapian sambungan, dan ketahanan material.', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('7', 'vision', 'Menjadi penyedia jasa aluminium dan kaca terdepan yang dipercaya atas kualitas pengerjaan presisi, integritas tinggi, dan kepuasan pelanggan menyeluruh.', 'general', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('8', 'mission', '1. Memberikan hasil instalasi aluminium dan kaca yang rapi, kokoh, dan presisi.\r\n2. Menggunakan material berkualitas dari merek terpercaya (Alexindo, YKK, Dacon, dll).\r\n3. Menawarkan harga yang transparan, kompetitif, dan sebanding dengan mutu layanan.\r\n4. Memberikan konsultasi teknis yang solutif serta pelayanan ramah dan responsif.', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('9', 'whatsapp_number', '6281932735383', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('10', 'phone_number', '+62 819-3273-5383', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('11', 'email', 'kontak@azkamandiri.com', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('12', 'address', 'Jl. Pondok Serut, Paku Jaya, Kec. Serpong Utara, Kota Tangerang Selatan, Banten 15220', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('13', 'service_areas', 'Jakarta Selatan, Jakarta Barat, Tangerang Selatan, Tangerang Kota, BSD City, Bintaro, Depok, Bekasi, dan sekitarnya', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('14', 'business_hours', 'Senin – Sabtu: 08.00 – 17.00 WIB (Konsultasi WhatsApp 24 Jam)', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('15', 'google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63456.63583272671!2d106.68060868846395!3d-6.308351543884898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fa0679883581%3A0x6758622f309a4d80!2sTangerang%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('16', 'instagram_url', 'https://instagram.com/azkamandiri.aluminium', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('17', 'facebook_url', 'https://facebook.com/azkamandiri.aluminium', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('18', 'tiktok_url', 'https://tiktok.com/@azkamandiri', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('19', 'youtube_url', 'https://youtube.com/@azkamandiri', 'general', '2026-11-14 03:57:54', '2026-11-14 04:12:12');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('20', 'meta_title', 'AzkaMandiri – Jasa Aluminium & Kaca Berkualitas Profesional', 'seo', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('21', 'meta_description', 'Jasa pembuatan dan pemasangan kusen aluminium, jendela aluminium, pintu kaca tempered, partisi ruko, kanopi kaca, dan shower box terpercaya di Jabodetabek.', 'seo', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('22', 'meta_keywords', 'kusen aluminium, jendela aluminium, pintu aluminium, partisi kaca, kaca tempered jabodetabek, kanopi kaca, shower box bintaro, azkamandiri', 'seo', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('23', 'logo_path', '/assets/brand/logo-horizontal.svg', 'assets', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('24', 'logo_dark_path', '/assets/brand/logo-horizontal-dark.svg', 'assets', '2026-11-14 03:57:54', '2026-11-14 03:57:54');
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES ('25', 'favicon_path', '/assets/brand/favicon.svg', 'assets', '2026-11-14 03:57:54', '2026-11-14 03:57:54');

-- --------------------------------------------------------
-- Table structure for table `testimonials`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint unsigned NOT NULL DEFAULT '5',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_sort_order_index` (`sort_order`),
  KEY `testimonials_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `testimonials`
INSERT INTO `testimonials` (`id`, `client_name`, `client_role`, `photo`, `content`, `rating`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('1', 'Bpk. Bambang S.', 'Pemilik Rumah – BSD City (Sample Demo)', NULL, 'Pemasangan kusen dan jendela aluminium untuk renovasi rumah sangat rapi, siku-sikunya presisi dan tidak ada goresan. Komunikasi lewat WhatsApp sangat cepat dan jelas.', '5', '1', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `testimonials` (`id`, `client_name`, `client_role`, `photo`, `content`, `rating`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('2', 'Ibu Maya Larasati', 'Desainer Interior – Jakarta (Sample Demo)', NULL, 'Sering bekerja sama dengan AzkaMandiri untuk partisi kaca kantor dan shower box apartemen. Kualitas material sesuai pesanan dan waktu pengerjaan on time.', '5', '2', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');
INSERT INTO `testimonials` (`id`, `client_name`, `client_role`, `photo`, `content`, `rating`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES ('3', 'Bpk. Ferry Kurniawan', 'Pemilik Ruko – Tangerang (Sample Demo)', NULL, 'Pintu sliding kaca ruko saya terpasang dengan baik. Relnya halus, aksesoris kunci juga kokoh. Harga sangat wajar dibandingkan kompetitor.', '5', '3', '1', '2026-11-14 03:57:55', '2026-11-14 03:57:55');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Administrator AzkaMandiri', 'admin@azkamandiri.com', '2026-11-14 03:57:54', '$2y$12$UE3mmzJNwqXye5duNqhXSOnA1HeDz9fMAm9lHx3ChaAjt5YstCEMu', NULL, '2026-11-14 03:57:54', '2026-11-14 03:57:54');

SET FOREIGN_KEY_CHECKS = 1;
