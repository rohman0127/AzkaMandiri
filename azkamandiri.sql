-- AzkaMandiri MySQL Database Dump for InfinityFree Deployment
-- Generated: 2026-11-14 21:53:56
-- Database: azkamandiri

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `article_categories`
INSERT INTO `article_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES 
('52', 'Tips & Panduan', 'tips-panduan', 'Tips bermanfaat seputar pemilihan, perawatan, dan instalasi aluminium kaca.', '1', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('53', 'Material & Spesifikasi', 'material-spesifikasi', 'Mengenal kualitas profil aluminium, jenis kaca, dan aksesoris bangunan.', '2', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('54', 'Inspirasi Desain', 'inspirasi-desain', 'Inspirasi model pintu, jendela, partisi, dan kanopi arsitektur modern.', '3', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `articles`
INSERT INTO `articles` (`id`, `article_category_id`, `title`, `slug`, `thumbnail`, `excerpt`, `content`, `author_name`, `status`, `published_at`, `views_count`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES 
('69', '53', 'Panduan Memilih Kusen Aluminium: YKK vs Alexindo vs Dacon', 'panduan-memilih-kusen-aluminium-ykk-vs-alexindo', '/assets/images/articles/panduan-memilih-kusen-aluminium-ykk-vs-alexindo.svg', 'Bingung menentukan merek kusen aluminium untuk rumah Anda? Simak perbandingan ketebalan profil, warna, kelebihan, dan kisaran harganya di sini.', 'Dalam memilih kusen aluminium untuk rumah tinggal maupun ruko, ada tiga merek ternama yang paling sering digunakan di Indonesia: YKK AP, Alexindo, dan Dacon.\n\n### 1. Profil YKK AP (Kualitas Premium)\nYKK AP dikenal sebagai standar tertinggi kusen aluminium di Indonesia. Keunggulannya terletak pada ketebalan dinding profil (mencapai 1.35mm - 1.4mm), komposisi paduan aluminium murni (Alloy 6063), dan finishing anodizing yang sangat tahan gores serta tahan paparan asam garam pantai. Kusen YKK memiliki harga paling tinggi namun memiliki durabilitas paling panjang.\n\n### 2. Profil Alexindo (Pilihan Terpopuler)\nAlexindo adalah merek yang paling populer dan banyak digunakan oleh kontraktor maupun pemilik rumah pribadi. Menawarkan ketebalan ideal (sekitar 1.0mm - 1.15mm) dengan variasi warna powder coating yang luas. Nilai keekonomisannya sangat baik dengan kualitas yang kokoh dan tahan puluhan tahun.\n\n### 3. Profil Dacon & Inkalum (Ekonomis)\nBagi Anda yang memiliki anggaran terukur, profil Dacon atau Inkalum memberikan alternatif yang sangat baik. Ketebalan profil berkisar 0.8mm - 0.95mm yang cukup kokoh untuk jendela dan sekat partisi interior.\n\nAzkaMandiri siap membantu Anda memilih profil yang paling tepat sesuai kebutuhan desain dan anggaran proyek Anda. Hubungi kami untuk konsultasi gratis!', 'Tim Teknis AzkaMandiri', 'published', '2026-11-04 21:41:07', '142', 'Panduan Memilih Kusen Aluminium: YKK vs Alexindo vs Dacon – Artikel AzkaMandiri', 'Bingung menentukan merek kusen aluminium untuk rumah Anda? Simak perbandingan ketebalan profil, warna, kelebihan, dan kisaran harganya di sini.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('70', '52', '5 Keunggulan Kaca Tempered untuk Pintu, Kanopi, dan Partisi Rumah', 'keunggulan-kaca-tempered-untuk-hunian', '/assets/images/articles/keunggulan-kaca-tempered-untuk-hunian.svg', 'Mengapa arsitek modern selalu merekomendasikan kaca tempered untuk area rawan benturan? Ketahui alasan keamanan dan estetika di balik kepopulerannya.', 'Kaca tempered kini menjadi standar keselamatan wajib dalam arsitektur modern. Berikut adalah 5 alasan utama mengapa Anda wajib mempertimbangkan kaca tempered:\n\n1. **Kekuatan Mekanis Hingga 5 Kali Lipat:** Kaca tempered diproses dengan pemanasan termal terkontrol hingga 700°C yang mengubah struktur molekulnya menjadi jauh lebih padat dan tahan benturan keras.\n2. **Toleransi Perubahan Suhu Ekstrem:** Mampu menahan perbedaan suhu hingga 200°C tanpa retak, sangat aman untuk kanopi atap yang terpapar sinar matahari terik.\n3. **Faktor Keamanan Tingkat Tinggi (Safety Glass):** Jika terkena benturan luar biasa melampaui batas elastisitasnya, kaca tempered tidak pecah menjadi pecahan tajam meruncing, melainkan butiran-butiran tumpul seperti jagung yang minim resiko melukai tubuh.\n4. **Tampilan Bersih & Minimalis:** Ketebalannya yang kokoh memungkinkan pembuatan pintu dan sekat frameless (tanpa kusen bingkai) yang elegan.\n5. **Meningkatkan Nilai Properti:** Hunian dengan instalasi kaca tempered berkualitas memiliki nilai jual dan prestise yang lebih tinggi.', 'Tim Arsitektur AzkaMandiri', 'published', '2026-11-08 21:41:07', '98', '5 Keunggulan Kaca Tempered untuk Pintu, Kanopi, dan Partisi Rumah – Artikel AzkaMandiri', 'Mengapa arsitek modern selalu merekomendasikan kaca tempered untuk area rawan benturan? Ketahui alasan keamanan dan estetika di balik kepopulerannya.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('71', '52', 'Cara Merawat Pintu dan Jendela Aluminium Agar Selalu Halus dan Berkilau', 'tips-merawat-pintu-dan-jendela-aluminium', '/assets/images/articles/tips-merawat-pintu-dan-jendela-aluminium.svg', 'Perawatan aluminium sebenarnya sangat mudah jika Anda mengetahui trik dasarnya. Hindari cairan kimia keras yang dapat merusak lapisan cat.', 'Kusen dan pintu aluminium terkenal minim perawatan, namun dengan langkah perawatan sederhana berikut, tampilannya akan selalu seperti baru:\n\n- **Bersihkan Rel Sliding Secara Berkala:** Debu dan pasir kecil pada rel geser sering menjadi penyebab roda macet. Cukup sedot debu dengan vacuum cleaner atau sikat kecil seminggu sekali.\n- **Gunakan Sabun Lembut (Netral):** Campurkan air hangat dengan sedikit sabun cuci piring lembut. Hindari pembersih berbahan asam tinggi atau tiner yang dapat merusak lapisan powder coating.\n- **Pelumasan Hardware:** Berikan beberapa tetes oli mesin jahit atau pelumas silikon spray pada engsel dan silinder kunci setiap 6 bulan sekali.\n- **Periksa Karet Kaca (Gasket):** Pastikan karet penjepit kaca tetap elastis dan tidak getas agar kekedapan air tetap optimal saat musim hujan.', 'Admin AzkaMandiri', 'published', '2026-11-11 21:41:07', '67', 'Cara Merawat Pintu dan Jendela Aluminium Agar Selalu Halus dan Berkilau – Artikel AzkaMandiri', 'Perawatan aluminium sebenarnya sangat mudah jika Anda mengetahui trik dasarnya. Hindari cairan kimia keras yang dapat merusak lapisan cat.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('72', '54', 'Inspirasi Partisi Kaca Minimalis untuk Kantor Nyaman dan Kedap Suara', 'inspirasi-partisi-kaca-kantor-minimalis', '/assets/images/articles/inspirasi-partisi-kaca-kantor-minimalis.svg', 'Ciptakan suasana kantor modern yang kolaboratif namun tetap tenang dengan kombinasi partisi kaca frameless dan profil aluminium ramping.', 'Tata ruang kantor terbuka (open plan) sering menghadapi kendala kebisingan yang mengganggu konsentrasi karyawan. Penggunaan partisi aluminium kaca tempered adalah solusi paling seimbang.\n\nDengan partisi kaca, cahaya alami bebas masuk ke seluruh penjuru ruangan kerja sehingga menghemat biaya listrik pencahayaan, sementara ruangan tetap kedap suara saat meeting penting berlangsung. Tambahan aksen stiker sandblast bermotif korporat dapat memberikan sentuhan elegan dan profesional bagi setiap klien yang berkunjung.', 'Tim Desain AzkaMandiri', 'published', '2026-11-13 21:41:07', '54', 'Inspirasi Partisi Kaca Minimalis untuk Kantor Nyaman dan Kedap Suara – Artikel AzkaMandiri', 'Ciptakan suasana kantor modern yang kolaboratif namun tetap tenang dengan kombinasi partisi kaca frameless dan profil aluminium ramping.', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `contact_messages`
INSERT INTO `contact_messages` (`id`, `name`, `phone_number`, `email`, `subject`, `message`, `status`, `ip_address`, `created_at`, `updated_at`) VALUES 
('35', 'Bpk. Ridwan', '081299887766', 'ridwan.sample@example.com', 'Tanya Biaya Kusen Aluminium Rumah 2 Lantai', 'Halo AzkaMandiri, saya berencana merenovasi jendela rumah di daerah Bintaro. Ada sekitar 12 titik jendela casement dan 2 pintu sliding. Apakah bisa dijadwalkan survei ke lokasi akhir pekan ini?', 'unread', '127.0.0.1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('36', 'Ibu Cynthia', '081311223344', 'cynthia.sample@example.com', 'Pemasangan Kanopi Kaca Carport', 'Selamat siang, mohon info estimasi harga per meter untuk kanopi kaca tempered laminated ukuran 4x5 meter. Rangka hollow galvanis. Terima kasih.', 'read', '127.0.0.1', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `customers`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `customers`
INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `company_name`, `is_active`, `created_at`, `updated_at`) VALUES 
('69', 'Bpk. Hendra Gunawan', '081288991122', 'hendra.gunawan@gmail.com', 'Cluster Heliconia Blok B3 No. 7, BSD City, Tangerang Selatan', 'Owner Rumah Tinggal - De Park BSD', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('70', 'Ibu Siti Nurhaliza', '081377889900', 'siti.nurhaliza@klinikbintaro.com', 'Ruko Emerald Avenue Sektor 9, Bintaro Jaya, Tangerang Selatan', 'Klinik Estetika Bintaro', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('71', 'Bpk. Aris Munandar', '085611224466', 'proyek@ciptabangungraha.co.id', 'Gading Serpong Boulevard Kav. 18, Tangerang', 'PT Cipta Bangun Graha', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('72', 'Bpk. Kevin Adiputra', '087788112233', 'kevin.adiputra@gmail.com', 'Alam Sutera, Serpong Utara, Tangerang Selatan', 'Rumah Cluster Sutera Narada', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

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
-- Table structure for table `inventory_categories`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `inventory_categories`;
CREATE TABLE `inventory_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventory_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `inventory_categories`
INSERT INTO `inventory_categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES 
('86', 'Profil Kusen Aluminium', 'profil-kusen-aluminium', 'Profil kusen aluminium 3 inch, 4 inch, daun pintu, dan daun jendela berbagai merek ternama.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('87', 'Kaca & Panel Arsitektur', 'kaca-panel-arsitektur', 'Lembaran kaca polos, tempered, laminated, riben, dan cermin berbagai ketebalan.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('88', 'Aksesoris & Hardware Pintu/Jendela', 'aksesoris-hardware-pintujendela', 'Handle, engsel casement, kunci tanam, roda sliding, dan perlengkapan pintu geser/lipat.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('89', 'Sealant, Karet & Perekat', 'sealant-karet-perekat', 'Silikon sealant netral/asam, karet profil, sekrup roofing, dan baut pengunci.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('90', 'Jasa Custom & Rakitan', 'jasa-custom-rakitan', 'Item pengerjaan khusus fabrikasi, bending profil, dan perakitan pesanan custom.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES 
('1', '0001_01_01_000000_create_users_table', '1'),
('2', '0001_01_01_000001_create_cache_table', '1'),
('3', '0001_01_01_000002_create_jobs_table', '1'),
('4', '2026_11_14_000001_create_settings_table', '1'),
('5', '2026_11_14_000002_create_pages_table', '1'),
('6', '2026_11_14_000003_create_service_categories_and_services_table', '1'),
('7', '2026_11_14_000004_create_portfolio_categories_and_portfolios_table', '1'),
('8', '2026_11_14_000005_create_article_categories_and_articles_table', '1'),
('9', '2026_11_14_000006_create_testimonials_table', '1'),
('10', '2026_11_14_000007_create_contact_messages_table', '1'),
('11', '2026_11_14_000008_create_inventory_categories_and_units_table', '1'),
('12', '2026_11_14_000009_create_products_and_suppliers_table', '1'),
('13', '2026_11_14_000010_create_purchases_table', '1'),
('14', '2026_11_14_000011_create_customers_and_transactions_table', '1'),
('15', '2026_11_14_000012_create_payments_and_stock_adjustments_table', '1'),
('16', '2026_11_14_000013_create_rbac_tables', '1');

-- --------------------------------------------------------
-- Table structure for table `model_has_roles`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `model_has_roles_user_id_foreign` (`user_id`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `model_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `model_has_roles`
INSERT INTO `model_has_roles` (`role_id`, `user_id`) VALUES 
('52', '52'),
('53', '53'),
('54', '54');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `pages`
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES 
('52', 'Tentang Kami', 'tentang-kami', 'AzkaMandiri adalah penyedia jasa terpercaya di bidang fabrikasi dan pemasangan aluminium serta kaca untuk kebutuhan residensial dan komersial di kawasan Jabodetabek dan sekitarnya. Kami berkomitmen memberikan solusi arsitektural yang fungsional, modern, dan tahan lama.', 'Tentang AzkaMandiri – Jasa Aluminium & Kaca Terpercaya', 'Mengenal AzkaMandiri lebih dekat, sejarah, visi misi dan keunggulan kami dalam jasa pemasangan kusen aluminium dan kaca.', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('53', 'Kebijakan Privasi', 'kebijakan-privasi', 'Kebijakan Privasi ini menjelaskan bagaimana AzkaMandiri mengumpulkan, menggunakan, dan melindungi informasi pribadi yang Anda berikan saat menggunakan layanan atau website kami. Kami menghargai kerahasiaan data Anda dan berkomitmen menjaganya dengan standar keamanan yang baik.', 'Kebijakan Privasi – AzkaMandiri', 'Kebijakan privasi pengunjung website dan pelanggan jasa aluminium AzkaMandiri.', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('54', 'Syarat dan Ketentuan', 'syarat-ketentuan', 'Syarat dan Ketentuan ini mengatur pemesanan layanan, survei lokasi, pembayaran bertahap, dan garansi pengerjaan yang disepakati antara pelanggan dan AzkaMandiri.', 'Syarat dan Ketentuan Layanan – AzkaMandiri', 'Syarat dan ketentuan pemesanan jasa aluminium dan kaca di AzkaMandiri.', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
-- Table structure for table `payments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `payment_date` datetime NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_type` enum('cash','transfer','qris') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `reference_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_transaction_id_foreign` (`transaction_id`),
  CONSTRAINT `payments_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `payments`
INSERT INTO `payments` (`id`, `transaction_id`, `payment_date`, `amount`, `payment_type`, `reference_number`, `notes`, `created_at`, `updated_at`) VALUES 
('35', '35', '2026-11-12 10:30:00', '500000.00', 'cash', 'CASH-0001', 'Pembayaran lunas kasir tunai', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('36', '36', '2026-11-13 14:15:00', '2000000.00', 'transfer', 'TRF-BCA-98124', 'Uang Muka (DP) 50% via Transfer Bank BCA', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `permissions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_label` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=613 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `permissions`
INSERT INTO `permissions` (`id`, `name`, `display_name`, `group`, `group_label`, `description`, `created_at`, `updated_at`) VALUES 
('579', 'pos.access', 'Akses Mesin Kasir POS', 'pos', 'Kasir & POS', 'Membuka antarmuka kasir dan keranjang transaksi.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('580', 'pos.create_transaction', 'Proses Transaksi & Checkout', 'pos', 'Kasir & POS', 'Melakukan checkout penjualan ritel maupun custom.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('581', 'pos.view_transactions', 'Lihat Riwayat Transaksi', 'pos', 'Kasir & POS', 'Membuka daftar riwayat penjualan kasir.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('582', 'pos.add_payment', 'Catat Pelunasan & DP', 'pos', 'Kasir & POS', 'Mencatat pembayaran cicilan bertahap atau sisa piutang.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('583', 'pos.print_receipt', 'Cetak Struk & Invoice', 'pos', 'Kasir & POS', 'Mencetak struk thermal 58/80mm dan mengunduh Invoice PDF.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('584', 'customers.view', 'Lihat Data Pelanggan', 'pos', 'Kasir & POS', 'Melihat direktori dan kontak WhatsApp pelanggan.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('585', 'customers.manage', 'Kelola Pelanggan (CRUD)', 'pos', 'Kasir & POS', 'Menambah, mengubah, dan menghapus profil pelanggan.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('586', 'products.view', 'Lihat Produk & Material', 'inventory', 'Inventaris & Stok', 'Melihat daftar master material dan sisa stok fisik.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('587', 'products.create', 'Tambah Produk Baru', 'inventory', 'Inventaris & Stok', 'Mendaftarkan SKU atau material baru ke gudang.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('588', 'products.edit', 'Ubah Produk & Harga', 'inventory', 'Inventaris & Stok', 'Mengubah nama, harga modal, harga jual, dan batas stok.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('589', 'products.delete', 'Hapus Produk', 'inventory', 'Inventaris & Stok', 'Menghapus data produk dari database.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('590', 'inventory.categories', 'Kelola Kategori Produk', 'inventory', 'Inventaris & Stok', 'CRUD kategori inventaris (profil aluminium, kaca, aksesoris).', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('591', 'inventory.units', 'Kelola Satuan Barang', 'inventory', 'Inventaris & Stok', 'CRUD satuan ukuran (batang, lembar, meter, pcs, dll.).', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('592', 'inventory.adjust_stock', 'Stok Opname & Koreksi', 'inventory', 'Inventaris & Stok', 'Mencatat opname berkala, barang rusak, dan penyesuaian.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('593', 'suppliers.view', 'Lihat Data Supplier', 'suppliers', 'Supplier & Belanja', 'Melihat daftar toko dan vendor penyuplai bahan baku.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('594', 'suppliers.manage', 'Kelola Data Supplier', 'suppliers', 'Supplier & Belanja', 'Menambah, mengubah, dan menghapus profil toko supplier.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('595', 'purchases.view', 'Lihat Riwayat Belanja', 'suppliers', 'Supplier & Belanja', 'Melihat daftar nota belanja barang masuk dari supplier.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('596', 'purchases.create', 'Input Belanja Masuk (Restock)', 'suppliers', 'Supplier & Belanja', 'Menginput barang restock yang otomatis menambah stok gudang.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('597', 'reports.sales', 'Laporan Penjualan', 'reports', 'Laporan & Keuangan', 'Melihat analisis omzet kasir dan distribusi metode bayar.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('598', 'reports.purchases', 'Laporan Pembelian & Restock', 'reports', 'Laporan & Keuangan', 'Melihat analisis pengeluaran belanja bahan baku dan faktur supplier.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('599', 'reports.profit_loss', 'Laporan Laba Rugi', 'reports', 'Laporan & Keuangan', 'Melihat margin keuntungan kotor per produk dan total laba.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('600', 'reports.stock', 'Laporan Valuasi & Stok', 'reports', 'Laporan & Keuangan', 'Melihat nilai aset gudang dan peringatan stok kritis.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('601', 'services.manage', 'Kelola Layanan Jasa', 'content', 'Konten Web & CMS', 'CRUD layanan aluminium/kaca dan kategori layanan.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('602', 'portfolios.manage', 'Kelola Portofolio Proyek', 'content', 'Konten Web & CMS', 'CRUD galeri proyek hasil pengerjaan tim.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('603', 'articles.manage', 'Kelola Artikel Blog', 'content', 'Konten Web & CMS', 'CRUD artikel edukasi dan tips aluminium/interior.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('604', 'testimonials.manage', 'Kelola Testimoni Klien', 'content', 'Konten Web & CMS', 'CRUD ulasan dan kepuasan pelanggan.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('605', 'pages.manage', 'Kelola Halaman Statis', 'content', 'Konten Web & CMS', 'Mengatur halaman tentang kami dan kebijakan.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('606', 'messages.view', 'Lihat Pesan Masuk', 'messages', 'Pesan Masuk', 'Membaca formulir kontak dari pengunjung website.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('607', 'messages.manage', 'Tindak Lanjut & Hapus Pesan', 'messages', 'Pesan Masuk', 'Mengubah status pesan atau menghapus pesan masuk.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('608', 'settings.profile', 'Kelola Profil & Kontak Perusahaan', 'settings', 'Sistem & Pengaturan', 'Mengubah nomor WhatsApp, alamat workshop, dan jam kerja.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('609', 'settings.seo', 'Kelola Pengaturan SEO', 'settings', 'Sistem & Pengaturan', 'Mengubah meta title, description, dan kata kunci.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('610', 'users.view', 'Lihat Daftar Pengguna', 'settings', 'Sistem & Pengaturan', 'Melihat daftar akun administrator dan staf.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('611', 'users.manage', 'Kelola Akun Pengguna', 'settings', 'Sistem & Pengaturan', 'Menambah akun, mengganti role, blokir, dan reset password.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('612', 'roles.manage', 'Kelola Peran & Hak Akses (RBAC)', 'settings', 'Sistem & Pengaturan', 'Membuat role baru dan mencentang matriks permissions.', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `portfolio_categories`
INSERT INTO `portfolio_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES 
('52', 'Residensial', 'residensial', 'Proyek pemasangan aluminium dan kaca untuk rumah tinggal, cluster, dan perumahan.', '1', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('53', 'Komersial & Kantor', 'komersial-kantor', 'Pengerjaan partisi kantor, gedung bertingkat, dan ruang kerja profesional.', '2', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('54', 'Ruko & Fasad Toko', 'ruko-fasad-toko', 'Fasad etalase kaca, pintu kaca folding, dan kanopi ruko.', '3', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `portfolio_images`
INSERT INTO `portfolio_images` (`id`, `portfolio_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES 
('103', '103', '/assets/images/portfolios/proyek-rumah-mewah-bsd.svg', 'Dokumentasi Proyek: Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('104', '104', '/assets/images/portfolios/partisi-kantor-scbd.svg', 'Dokumentasi Proyek: Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('105', '105', '/assets/images/portfolios/kanopi-kaca-villa-bogor.svg', 'Dokumentasi Proyek: Kanopi Kaca Tempered Laminated & Carport Modern', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('106', '106', '/assets/images/portfolios/shower-screen-apartemen-kemang.svg', 'Dokumentasi Proyek: Frameless Shower Screen Tempered Kamar Mandi', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('107', '107', '/assets/images/portfolios/pintu-lipat-folding-bintaro.svg', 'Dokumentasi Proyek: Pintu Lipat Aluminium 6 Daun Teras Belakang', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('108', '108', '/assets/images/portfolios/etalase-showroom-alam-sutera.svg', 'Dokumentasi Proyek: Fasad Kaca Display Showroom & Toko Modern', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `portfolios`
INSERT INTO `portfolios` (`id`, `portfolio_category_id`, `title`, `slug`, `client_name`, `location`, `completion_year`, `excerpt`, `description`, `main_image`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES 
('103', '52', 'Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal', 'proyek-rumah-mewah-bsd', 'Bpk. Hendra Wijaya', 'Cluster Greenwich Park, BSD City, Tangerang', '2025', 'Fabrikasi dan pemasangan kusen aluminium Alexindo hitam powder coating untuk seluruh jendela casement dan pintu sliding balkon.', 'Proyek ini mencakup pemasangan kusen aluminium tipe 4 inch dengan finishing hitam matte powder coating pada rumah 2 lantai.\n\nKlien menginginkan bukaan kaca yang lebar untuk memaksimalkan pemandangan taman samping dan sirkulasi udara alami. Seluruh kaca menggunakan kaca bening 6mm Asahimas dengan peredaman suara maksimal.', '/assets/images/portfolios/proyek-rumah-mewah-bsd.svg', '1', '1', '1', 'Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal – Portofolio AzkaMandiri', 'Fabrikasi dan pemasangan kusen aluminium Alexindo hitam powder coating untuk seluruh jendela casement dan pintu sliding balkon.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('104', '53', 'Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD', 'partisi-kantor-scbd', 'PT Sinergi Dinamika Abadi', 'Sudirman Central Business District (SCBD), Jakarta Selatan', '2025', 'Penyekat ruangan meeting dan direksi menggunakan kaca tempered 12mm frameless dengan aksesoris engsel tanam Dekkson.', 'Pengerjaan partisi kaca interior kantor seluas 180 m2. Menggunakan sistem frameless dengan profil U stainless tanam di lantai dan plafon akustik.\n\nDilengkapi pintu kaca ganda patch fitting floor hinge heavy duty serta stiker kaca sandblast bermotif garis minimalis untuk menjaga privasi rapat bisnis.', '/assets/images/portfolios/partisi-kantor-scbd.svg', '2', '1', '1', 'Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD – Portofolio AzkaMandiri', 'Penyekat ruangan meeting dan direksi menggunakan kaca tempered 12mm frameless dengan aksesoris engsel tanam Dekkson.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('105', '52', 'Kanopi Kaca Tempered Laminated & Carport Modern', 'kanopi-kaca-villa-bogor', 'Ibu Ratna Dewi', 'Sentul City, Bogor, Jawa Barat', '2025', 'Konstruksi kanopi kaca tempered laminated 5+5mm dengan rangka baja hollow galvanis 50x100mm cat hitam doff anti karat.', 'Kanopi carport dengan bentang 6 x 5 meter tanpa tiang tengah yang mengganggu ruang gerak manuver kendaraan. Menggunakan kaca laminated tahan benturan dengan lapisan film UV protection.\n\nSistem talang air tersembunyi dirancang rapi agar air hujan mengalir lancar tanpa resiko cipratan.', '/assets/images/portfolios/kanopi-kaca-villa-bogor.svg', '3', '1', '1', 'Kanopi Kaca Tempered Laminated & Carport Modern – Portofolio AzkaMandiri', 'Konstruksi kanopi kaca tempered laminated 5+5mm dengan rangka baja hollow galvanis 50x100mm cat hitam doff anti karat.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('106', '52', 'Frameless Shower Screen Tempered Kamar Mandi', 'shower-screen-apartemen-kemang', 'Bpk. Aris Pratama', 'Kemang, Jakarta Selatan', '2026', 'Pemasangan sekat kaca shower box L-shape kaca tempered 10mm dengan fitting stainless steel 304 gold satin finish.', 'Shower box sudut L-shape yang memisahkan area kering dan basah secara elegan. Engsel kaca menggunakan material SUS 304 tahan karat jangka panjang.\n\nDisertai sealing silikon antimikroba (anti jamur) sehingga sudut kaca selalu bersih, bening, dan tidak mudah menghitam.', '/assets/images/portfolios/shower-screen-apartemen-kemang.svg', '4', '0', '1', 'Frameless Shower Screen Tempered Kamar Mandi – Portofolio AzkaMandiri', 'Pemasangan sekat kaca shower box L-shape kaca tempered 10mm dengan fitting stainless steel 304 gold satin finish.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('107', '52', 'Pintu Lipat Aluminium 6 Daun Teras Belakang', 'pintu-lipat-folding-bintaro', 'Bpk. Dian Sastro', 'Kebayoran Residences, Bintaro Jaya Sektor 7', '2026', 'Pintu folding aluminium 6 daun menghubungkan ruang keluarga dengan kolam renang privat, bukaan 100% lapang.', 'Pintu folding aluminium dengan rel bawah rata lantai (flush track) agar aman saat dilintasi anak-anak dan lansia. Roda rel bearing stainless berputar sangat halus tanpa hentakan.\n\nMemberikan efek ruangan multifungsi: tertutup kedap AC atau terbuka penuh saat acara keluarga besar.', '/assets/images/portfolios/pintu-lipat-folding-bintaro.svg', '5', '1', '1', 'Pintu Lipat Aluminium 6 Daun Teras Belakang – Portofolio AzkaMandiri', 'Pintu folding aluminium 6 daun menghubungkan ruang keluarga dengan kolam renang privat, bukaan 100% lapang.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('108', '54', 'Fasad Kaca Display Showroom & Toko Modern', 'etalase-showroom-alam-sutera', 'CV Cahaya Gemilang', 'Ruko Prominence Alam Sutera, Tangerang', '2026', 'Pemasangan curtain wall kaca fasad dan pintu kaca geser otomatis untuk showroom otomotif & aksesoris.', 'Fasad toko 2 lantai dengan bentang kaca 8 meter menggunakan frame aluminium tebal warna silver anodized. Hasil akhir rapi dan menonjolkan produk jualan di dalam showroom secara maksimal.', '/assets/images/portfolios/etalase-showroom-alam-sutera.svg', '6', '0', '1', 'Fasad Kaca Display Showroom & Toko Modern – Portofolio AzkaMandiri', 'Pemasangan curtain wall kaca fasad dan pintu kaca geser otomatis untuk showroom otomotif & aksesoris.', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `unit_id` bigint unsigned NOT NULL,
  `cost_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stock` decimal(10,2) NOT NULL DEFAULT '0.00',
  `min_stock` decimal(10,2) NOT NULL DEFAULT '5.00',
  `rack_location` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('standard','custom_service') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_unit_id_foreign` (`unit_id`),
  KEY `products_barcode_index` (`barcode`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `inventory_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `sku`, `barcode`, `name`, `category_id`, `unit_id`, `cost_price`, `price`, `stock`, `min_stock`, `rack_location`, `image`, `type`, `is_active`, `description`, `created_at`, `updated_at`) VALUES 
('239', 'ALU-KS3-BLK', NULL, 'Kusen Aluminium 3\" Alexindo Hitam Anodize (6 Meter)', '86', '137', '125000.00', '175000.00', '45.00', '10.00', 'Rak A-01', NULL, 'standard', '1', 'Profil kusen 3 inch panjang 6 meter finishing hitam anodize standar perumahan modern.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('240', 'ALU-KS3-WHT', NULL, 'Kusen Aluminium 3\" Alexindo Putih Powder Coating (6 Meter)', '86', '137', '135000.00', '185000.00', '38.00', '10.00', 'Rak A-02', NULL, 'standard', '1', 'Profil kusen 3 inch putih glossy tahan cuaca dan anti luntur.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('241', 'ALU-KS4-BRN', NULL, 'Kusen Aluminium 4\" Alexindo Cokelat Anodize (6 Meter)', '86', '137', '170000.00', '235000.00', '26.00', '8.00', 'Rak A-03', NULL, 'standard', '1', 'Profil kusen tebal 4 inch cocok untuk ruko, partisi kantor, dan fasad utama.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('242', 'ALU-DP-SLD', NULL, 'Tiang Daun Pintu Sliding Aluminium Alexindo Hitam', '86', '137', '155000.00', '210000.00', '20.00', '6.00', 'Rak B-01', NULL, 'standard', '1', 'Profil profil tiang pintu geser aluminium.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('243', 'KAC-CLR-5MM', NULL, 'Kaca Polos Clear 5mm Asahi (Ukuran Standar 152 x 213 cm)', '87', '138', '195000.00', '285000.00', '18.00', '5.00', 'Gudang Kaca Rak 1', NULL, 'standard', '1', 'Lembaran kaca bening kejernihan tinggi untuk jendela dan ventilasi.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('244', 'KAC-RYB-5MM', NULL, 'Kaca Rayban Gelap 5mm Asahi (Ukuran Standar 152 x 213 cm)', '87', '138', '220000.00', '315000.00', '14.00', '5.00', 'Gudang Kaca Rak 2', NULL, 'standard', '1', 'Kaca pelindung sinar UV redup panas untuk jendela samping.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('245', 'KAC-TMP-8MM', NULL, 'Kaca Tempered 8mm Custom Partisi & Shower Screen', '87', '138', '450000.00', '650000.00', '4.00', '5.00', 'Gudang Kaca Khusus', NULL, 'standard', '1', 'Kaca tempered safety kekuatan 5x lipat kaca biasa, tepi gosok halus mesin.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('246', 'AKS-HDL-DKK', NULL, 'Handle Pintu Lever Dekkson Stainless Steel LHTR 0016', '88', '141', '180000.00', '260000.00', '25.00', '5.00', 'Lemari Aksesoris L-1', NULL, 'standard', '1', 'Handle pintu minimalis modern bahan SUS 304 anti karat.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('247', 'AKS-EGS-CS12', NULL, 'Friction Stay / Engsel Casement Jendela 12\" Stainless', '88', '141', '45000.00', '75000.00', '40.00', '10.00', 'Lemari Aksesoris L-2', NULL, 'standard', '1', 'Engsel jungkit jendela aluminium penahan angin kuat.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('248', 'AKS-KNC-SLD', NULL, 'Kunci Tanam Pintu Sliding Aluminium Hampton', '88', '141', '95000.00', '145000.00', '15.00', '5.00', 'Lemari Aksesoris L-3', NULL, 'standard', '1', 'Kunci kait pintu geser lengkap silinder dan anak kunci.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('249', 'AKS-RDA-HVY', NULL, 'Roda Pintu Geser Aluminium Heavy Duty Bearing Nilon', '88', '140', '28000.00', '45000.00', '50.00', '15.00', 'Kotak Part B-4', NULL, 'standard', '1', 'Roda bawah sliding dorong halus tanpa suara berdecit.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('250', 'SLN-DOW-BLK', NULL, 'Silikon Sealant Dowsil 791 Weatherproofing Hitam 300ml', '89', '140', '42000.00', '60000.00', '3.00', '12.00', 'Rak Sealant C-1', NULL, 'standard', '1', 'Sealant netral elastisitas tinggi tahan panas terik matahari dan hujan lebat.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('251', 'KRT-KUS-BLK', NULL, 'Karet Kancing Profil Kusen Aluminium EPDM Hitam (50m/roll)', '89', '143', '85000.00', '130000.00', '12.00', '4.00', 'Rak Sealant C-2', NULL, 'standard', '1', 'Karet peredam getaran dan kedap suara untuk penjepit kaca ke kusen.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('252', 'CST-PNT-SPK', NULL, 'Pesanan Custom Daun Pintu Aluminium Spandrel / Kaca', '90', '142', '950000.00', '1650000.00', '999.00', '0.00', 'Area Fabrikasi Workshop', NULL, 'custom_service', '1', 'Paket pintu aluminium custom rakitan lengkap aksesoris sesuai ukuran konsumen.', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `purchase_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `purchase_items`;
CREATE TABLE `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '1.00',
  `unit_cost` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `purchase_items`
INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `quantity`, `unit_cost`, `subtotal`, `created_at`, `updated_at`) VALUES 
('52', '35', '239', '20.00', '125000.00', '2500000.00', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('53', '35', '240', '15.00', '135000.00', '2025000.00', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('54', '36', '243', '10.00', '195000.00', '1950000.00', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `purchases`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned NOT NULL,
  `purchase_date` date NOT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_status` enum('paid','partial','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_invoice_number_unique` (`invoice_number`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `purchases`
INSERT INTO `purchases` (`id`, `invoice_number`, `supplier_id`, `purchase_date`, `total_amount`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES 
('35', 'PO-202611-0001', '69', '2026-11-09', '4525000.00', 'paid', 'Restock mingguan profil kusen aluminium 3 inch Alexindo.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('36', 'PO-202611-0002', '70', '2026-11-11', '1950000.00', 'paid', 'Pembelian bahan kaca lembaran bening 5mm.', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `role_has_permissions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `role_id` bigint unsigned NOT NULL,
  `permission_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `role_has_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `role_has_permissions`
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES 
('52', '579'),
('53', '579'),
('52', '580'),
('53', '580'),
('52', '581'),
('53', '581'),
('52', '582'),
('53', '582'),
('52', '583'),
('53', '583'),
('52', '584'),
('53', '584'),
('52', '585'),
('53', '585'),
('52', '586'),
('53', '586'),
('54', '586'),
('52', '587'),
('54', '587'),
('52', '588'),
('54', '588'),
('52', '589'),
('52', '590'),
('54', '590'),
('52', '591'),
('54', '591'),
('52', '592'),
('54', '592'),
('52', '593'),
('54', '593'),
('52', '594'),
('54', '594'),
('52', '595'),
('54', '595'),
('52', '596'),
('54', '596'),
('52', '597'),
('53', '597'),
('52', '598'),
('54', '598'),
('52', '599'),
('52', '600'),
('54', '600'),
('52', '601'),
('52', '602'),
('52', '603'),
('52', '604'),
('52', '605'),
('52', '606'),
('52', '607');
INSERT INTO `role_has_permissions` (`role_id`, `permission_id`) VALUES 
('52', '608'),
('52', '609'),
('52', '610'),
('52', '611'),
('52', '612');

-- --------------------------------------------------------
-- Table structure for table `roles`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `roles`
INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `is_system`, `created_at`, `updated_at`) VALUES 
('52', 'Super Admin', 'super-admin', 'Memiliki hak akses penuh ke seluruh modul, pengaturan, dan database sistem.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('53', 'Kasir', 'kasir', 'Petugas kasir toko untuk transaksi POS, cetak struk, direktori pelanggan, dan monitoring stok.', '0', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('54', 'Staff Gudang', 'staff-gudang', 'Pengelola persediaan material aluminium/kaca, restock belanja supplier, dan stok opname.', '0', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `service_categories`
INSERT INTO `service_categories` (`id`, `name`, `slug`, `description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES 
('103', 'Kusen & Pintu', 'kusen-pintu', 'Kusen dan daun pintu aluminium berbagai model untuk interior dan eksterior.', '1', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('104', 'Jendela Modern', 'jendela-modern', 'Jendela aluminium model geser, jungkit, casement, dan pivot.', '2', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('105', 'Partisi & Kaca', 'partisi-kaca', 'Penyekat ruangan kantor, ruko, dan kaca tempered standar arsitektur.', '3', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('106', 'Kanopi & Eksterior', 'kanopi-eksterior', 'Kanopi kaca tempered laminated dan fasad arsitektur modern.', '4', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('107', 'Interior & Kamar Mandi', 'interior-kamar-mandi', 'Shower screen kaca, kitchen set aluminium anti rayap, dan etalase toko.', '5', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('108', 'Pekerjaan Custom', 'pekerjaan-custom', 'Pembuatan profil khusus aluminium dan kaca sesuai spesifikasi arsitek.', '6', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `service_images`
INSERT INTO `service_images` (`id`, `service_id`, `image_path`, `caption`, `sort_order`, `created_at`, `updated_at`) VALUES 
('171', '171', '/assets/images/services/kusen-aluminium.svg', 'Pemasangan Kusen Aluminium oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('172', '172', '/assets/images/services/jendela-aluminium.svg', 'Pemasangan Jendela Aluminium oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('173', '173', '/assets/images/services/pintu-aluminium.svg', 'Pemasangan Pintu Aluminium oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('174', '174', '/assets/images/services/partisi-aluminium.svg', 'Pemasangan Partisi Aluminium oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('175', '175', '/assets/images/services/kaca-tempered.svg', 'Pemasangan Kaca Tempered oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('176', '176', '/assets/images/services/kanopi-kaca.svg', 'Pemasangan Kanopi Kaca oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('177', '177', '/assets/images/services/shower-box.svg', 'Pemasangan Shower Box oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('178', '178', '/assets/images/services/etalase-kaca.svg', 'Pemasangan Etalase Kaca oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('179', '179', '/assets/images/services/lemari-aluminium.svg', 'Pemasangan Lemari Aluminium oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('180', '180', '/assets/images/services/custom-aluminium-kaca.svg', 'Pemasangan Aluminium dan Kaca Custom oleh AzkaMandiri', '1', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `services`
INSERT INTO `services` (`id`, `service_category_id`, `name`, `slug`, `excerpt`, `description`, `thumbnail`, `main_image`, `price_info`, `features`, `sort_order`, `is_featured`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES 
('171', '103', 'Kusen Aluminium', 'kusen-aluminium', 'Pemasangan kusen aluminium 3 inch dan 4 inch berkualitas tinggi dengan finishing rapi, presisi miter joint, dan tahan cuaca.', 'AzkaMandiri melayani pembuatan dan pemasangan kusen aluminium untuk berbagai kebutuhan bangunan seperti rumah tinggal, kantor, ruko, hingga gedung bertingkat.\n\nKami menyediakan pilihan profil merek terpercaya seperti Alexindo, YKK AP, Dacon, Inkalum, dan Forta. Setiap sambungan dipotong dengan mesin presisi miter saw sehingga sambungan sudut rapat tanpa celah kasar.\n\nPilihan warna meliputi Anodized Silver, Anodized Hitam, Anodized Cokelat, serta Powder Coating Putih, Cream, Urat Kayu (Wood Grain), dan warna custom lainnya.', '/assets/images/services/kusen-aluminium.svg', '/assets/images/services/kusen-aluminium.svg', 'Mulai Rp 120.000 / meter lari', '[\"Pilihan Profil 3\\\" dan 4\\\"\",\"Merek Alexindo, YKK, Dacon\",\"Powder Coating & Anodized\",\"Anti Rayap & Anti Karat\",\"Garansi Pemasangan Rapi\"]', '1', '1', '1', 'Kusen Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pemasangan kusen aluminium 3 inch dan 4 inch berkualitas tinggi dengan finishing rapi, presisi miter joint, dan tahan cuaca.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('172', '104', 'Jendela Aluminium', 'jendela-aluminium', 'Jendela aluminium modern model casement (jungkit), sliding (geser), pivot, dan fixed glass dengan seal kedap suara dan air.', 'Jendela aluminium AzkaMandiri dirancang untuk memaksimalkan sirkulasi udara dan pencahayaan alami tanpa mengorbankan estetika dan keamanan rumah Anda.\n\nDilengkapi dengan karet gasket EPDM berkualitas dan aksesoris handle kunci mutakhir (Kinlong, Dekkson, Hampton), jendela kami memastikan kekedapan suara yang prima serta proteksi anti bocor saat hujan lebat.', '/assets/images/services/jendela-aluminium.svg', '/assets/images/services/jendela-aluminium.svg', 'Mulai Rp 650.000 / unit', '[\"Model Casement, Sliding, Jungkit\",\"Karet Seal EPDM Tahan Bocor\",\"Kunci Kinlong & Dekkson Kokoh\",\"Bisa Custom Ukuran\",\"Kaca Polos \\/ Rayban \\/ Es\"]', '2', '1', '1', 'Jendela Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Jendela aluminium modern model casement (jungkit), sliding (geser), pivot, dan fixed glass dengan seal kedap suara dan air.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('173', '103', 'Pintu Aluminium', 'pintu-aluminium', 'Pintu swing, sliding, hingga pintu lipat (folding door) aluminium dengan desain minimalis elegan dan engsel berkualitas berat.', 'Pintu aluminium merupakan solusi ideal untuk pintu utama, pintu balkon, pintu taman, maupun pintu kamar mandi. Kami memproduksi berbagai model pintu aluminium yang kokoh dan awet.\n\nKeunggulan pintu aluminium kami adalah konstruksi sudut yang diperkuat siku baja internal, pergerakan roda bearing yang halus tanpa suara berdecit, serta daya tahan tinggi terhadap kelembapan dan serangan rayap.', '/assets/images/services/pintu-aluminium.svg', '/assets/images/services/pintu-aluminium.svg', 'Mulai Rp 1.400.000 / daun pintu', '[\"Pintu Swing, Geser, & Lipat\",\"Hardware Heavy-Duty\",\"Panel Kaca Tempered \\/ Aluminium Composite\",\"Tersedia Model Minimalis Modern\",\"Tahan Cuaca & Rayap\"]', '3', '1', '1', 'Pintu Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pintu swing, sliding, hingga pintu lipat (folding door) aluminium dengan desain minimalis elegan dan engsel berkualitas berat.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('174', '105', 'Partisi Aluminium', 'partisi-aluminium', 'Penyekat ruangan kantor dan komersial dengan frame aluminium kokoh dan kaca bening/buram yang memberikan kesan luas dan profesional.', 'Maksimalkan efisiensi ruang kantor atau ruko Anda dengan partisi aluminium dan kaca dari AzkaMandiri. Partisi ini memisahkan area kerja dengan tetap menjaga suasana terang, bersih, dan terbuka.\n\nKami juga menyediakan instalasi sandblast sticker untuk privasi ruang meeting serta integrasi jalur instalasi kabel elektrikal secara rapi.', '/assets/images/services/partisi-aluminium.svg', '/assets/images/services/partisi-aluminium.svg', 'Mulai Rp 450.000 / m2', '[\"Rangka Aluminium Kokoh\",\"Kombinasi Kaca Polos \\/ Buram \\/ Sandblast\",\"Peredaman Suara yang Baik\",\"Pengerjaan Cepat & Bersih\",\"Cocok untuk Kantor & Ruko\"]', '4', '1', '1', 'Partisi Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Penyekat ruangan kantor dan komersial dengan frame aluminium kokoh dan kaca bening/buram yang memberikan kesan luas dan profesional.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('175', '105', 'Kaca Tempered', 'kaca-tempered', 'Pemasangan kaca tempered 8mm, 10mm, 12mm bersertifikasi SNI dengan kekuatan benturan 5x lebih tangguh dari kaca biasa.', 'Kaca tempered adalah kaca safety yang telah diproses pemanasan termal tinggi hingga 700°C lalu didinginkan secara cepat. Menghasilkan kekuatan mekanis dan ketahanan panas yang luar biasa.\n\nSangat direkomendasikan untuk pintu frameless patch fitting, railing tangga, void balkon, kanopi, dan partisi dinding kaca gedung. Jika pecah, kaca tempered akan menjadi butiran tumpul kecil yang meminimalisir risiko cedera.', '/assets/images/services/kaca-tempered.svg', '/assets/images/services/kaca-tempered.svg', 'Mulai Rp 550.000 / m2 (8mm-12mm)', '[\"Standar Kaca SNI Resmi\",\"Kekuatan 5x Kaca Biasa\",\"Toleransi Suhu Ekstrem\",\"Tepian Polish Halus (Bevel\\/Flat)\",\"Aksesoris Stainless 304\"]', '5', '1', '1', 'Kaca Tempered – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pemasangan kaca tempered 8mm, 10mm, 12mm bersertifikasi SNI dengan kekuatan benturan 5x lebih tangguh dari kaca biasa.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('176', '106', 'Kanopi Kaca', 'kanopi-kaca', 'Kanopi carport dan teras dengan kaca tempered atau laminated dipadu rangka hollow besi/baja WF yang modern dan mewah.', 'Hadirkan tampilan fasad rumah mewah bergaya modern tropis dengan kanopi kaca AzkaMandiri. Struktur kanopi kami dihitung dengan cermat agar mampu menahan beban angin dan air hujan dengan aman.\n\nPenggunaan kaca tempered laminated dengan lembaran interlayer PVB memastikan perlindungan maksimal dari sinar UV sekaligus keamanan mutlak jika terjadi insiden kejatuhan benda.', '/assets/images/services/kanopi-kaca.svg', '/assets/images/services/kanopi-kaca.svg', 'Mulai Rp 1.350.000 / m2', '[\"Kaca Tempered Laminated 10mm-16mm\",\"Rangka Hollow Galvanis Anti Karat \\/ WF\",\"Sealant Khusus Struktural Anti Bocor\",\"Desain Modern & Bernilai Estetika Tinggi\",\"Garansi Kebocoran\"]', '6', '1', '1', 'Kanopi Kaca – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Kanopi carport dan teras dengan kaca tempered atau laminated dipadu rangka hollow besi/baja WF yang modern dan mewah.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('177', '107', 'Shower Box', 'shower-box', 'Penyekat kaca kamar mandi frameless tempered 10mm dengan aksesoris engsel dan pipa header stainless steel 304 anti karat.', 'Shower box atau shower screen kaca menjadikan kamar mandi Anda kering, bersih, dan berkelas hotel berbintang. Kami menyediakan model pintu swing dengan engsel glass-to-wall maupun sliding shower door yang hemat tempat.\n\nSemua aksesoris penjepit dan engsel menggunakan material stainless steel SUS 304 yang tahan terhadap kelembapan tinggi dan sabun kimia tanpa mengalami korosi.', '/assets/images/services/shower-box.svg', '/assets/images/services/shower-box.svg', 'Mulai Rp 2.200.000 / set', '[\"Kaca Tempered 10mm Safety\",\"Hardware Full Stainless SUS 304\",\"Karet Magnet Penutup Rapat\",\"Model Sudut L, U, atau Straight\",\"Bebas Kerak & Mudah Dibersihkan\"]', '7', '1', '1', 'Shower Box – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Penyekat kaca kamar mandi frameless tempered 10mm dengan aksesoris engsel dan pipa header stainless steel 304 anti karat.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('178', '107', 'Etalase Kaca', 'etalase-kaca', 'Etalase kaca display jualan untuk toko, apotek, konter HP, bakery, dan showroom dengan frame aluminium kokoh dan rapi.', 'Tingkatkan daya tarik produk jualan Anda dengan etalase kaca display custom buatan AzkaMandiri. Dibuat presisi dengan rak kaca bertingkat, pintu sliding beroda rel halus, dan kunci silinder aman.\n\nKami dapat menambahkan lampu LED strip tersembunyi untuk memberikan efek pencahayaan produk yang memukau calon pembeli Anda.', '/assets/images/services/etalase-kaca.svg', '/assets/images/services/etalase-kaca.svg', 'Mulai Rp 950.000 / unit', '[\"Custom Ukuran & Jumlah Rak\",\"Roda Kunci \\/ Roda Nylon Bergerak\",\"Lampu LED Showcase Opsional\",\"Kaca Bening Bervariasi 5-8mm\",\"Kunci Silinder Keamanan\"]', '8', '0', '1', 'Etalase Kaca – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Etalase kaca display jualan untuk toko, apotek, konter HP, bakery, dan showroom dengan frame aluminium kokoh dan rapi.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('179', '107', 'Lemari Aluminium', 'lemari-aluminium', 'Kitchen set bawah/atas dan lemari pakaian berbahan aluminium composite panel (ACP) 100% anti rayap, tahan air, dan awet puluhan tahun.', 'Bosan dengan lemari kayu atau partikel board yang mudah lapuk dan dimakan rayap? Lemari aluminium dan kitchen set dari AzkaMandiri adalah solusi abadi untuk hunian Anda.\n\nDilapisi Aluminium Composite Panel (ACP) berkualitas dengan aneka pilihan warna glossy, matte, marmer, atau corak kayu, lemari ini sangat higienis, mudah dilap, dan tidak berbau jamur.', '/assets/images/services/lemari-aluminium.svg', '/assets/images/services/lemari-aluminium.svg', 'Mulai Rp 2.100.000 / meter lari', '[\"100% Bebas Rayap & Jamur\",\"Tahan Air & Lembap\",\"Panel ACP Aneka Corak & Warna\",\"Engsel Slow-Motion (Soft-Close)\",\"Konstruksi Kuat & Ringan\"]', '9', '0', '1', 'Lemari Aluminium – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Kitchen set bawah/atas dan lemari pakaian berbahan aluminium composite panel (ACP) 100% anti rayap, tahan air, dan awet puluhan tahun.', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('180', '108', 'Aluminium dan Kaca Custom', 'custom-aluminium-kaca', 'Pengerjaan spesialis desain khusus aluminium dan kaca sesuai gambar kerja arsitek, interior designer, atau kebutuhan unik proyek Anda.', 'Apakah Anda memiliki desain arsitektural yang unik dan membutuhkan ketelitian fabrikasi khusus? AzkaMandiri siap menerjemahkan sketsa atau gambar kerja AutoCAD Anda menjadi kenyataan.\n\nKami melayani pembuatan louvre kisi-kisi aluminium, curtain wall gedung mini, skylight kaca atap, aquarium raksasa, hingga booth pameran custom dengan standar presisi tinggi.', '/assets/images/services/custom-aluminium-kaca.svg', '/assets/images/services/custom-aluminium-kaca.svg', 'Berdasarkan Spesifikasi & Gambar Proyek', '[\"Konsultasi Desain & Gambar Kerja\",\"Fleksibilitas Bentuk & Dimensi\",\"Pilihan Paduan Material Lengkap\",\"Survei Lapangan Gratis\",\"Garansi Kepuasan Pelanggan\"]', '10', '1', '1', 'Aluminium dan Kaca Custom – Jasa Pemasangan & Pembuatan AzkaMandiri', 'Pengerjaan spesialis desain khusus aluminium dan kaca sesuai gambar kerja arsitek, interior designer, atau kebutuhan unik proyek Anda.', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

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
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `settings`
INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES 
('426', 'site_name', 'AzkaMandiri', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('427', 'brand_title', 'AzkaMandiri – Jasa Aluminium & Kaca', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('428', 'tagline', 'Solusi Aluminium & Kaca untuk Hunian dan Bangunan Anda', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('429', 'business_type', 'Jasa Pemasangan & Pembuatan Aluminium, Kaca & Custom Bangunan', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('430', 'about_short', 'AzkaMandiri hadir memberikan layanan pemasangan, pembuatan, dan pengerjaan aluminium serta kaca berkualitas dengan hasil rapi dan profesional untuk rumah, ruko, kantor, hingga gedung komersial.', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('431', 'business_history', 'Berawal dari dedikasi dan pengalaman bertahun-tahun para teknisi aluminium dan kaca, AzkaMandiri tumbuh sebagai mitra terpercaya bagi ratusan pemilik rumah, kontraktor, dan arsitek di area Jabodetabek. Kami mengutamakan ketepatan dimensi, kerapian sambungan, dan ketahanan material.', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('432', 'vision', 'Menjadi penyedia jasa aluminium dan kaca terdepan yang dipercaya atas kualitas pengerjaan presisi, integritas tinggi, dan kepuasan pelanggan menyeluruh.', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('433', 'mission', '1. Memberikan hasil instalasi aluminium dan kaca yang rapi, kokoh, dan presisi.\n2. Menggunakan material berkualitas dari merek terpercaya (Alexindo, YKK, Dacon, dll).\n3. Menawarkan harga yang transparan, kompetitif, dan sebanding dengan mutu layanan.\n4. Memberikan konsultasi teknis yang solutif serta pelayanan ramah dan responsif.', 'general', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('434', 'whatsapp_number', '6281234567890', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('435', 'phone_number', '+62 812-3456-7890', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('436', 'email', 'kontak@azkamandiri.com', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('437', 'address', 'Jl. Aria Putra No. 45, Sarua Indah, Ciputat, Tangerang Selatan, Banten 15414', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('438', 'service_areas', 'Jakarta Selatan, Jakarta Barat, Tangerang Selatan, Tangerang Kota, BSD City, Bintaro, Depok, Bekasi, dan sekitarnya', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('439', 'business_hours', 'Senin – Sabtu: 08.00 – 17.00 WIB (Konsultasi WhatsApp 24 Jam)', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('440', 'google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63456.63583272671!2d106.68060868846395!3d-6.308351543884898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fa0679883581%3A0x6758622f309a4d80!2sTangerang%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid', 'contact', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('441', 'instagram_url', 'https://instagram.com/azkamandiri.aluminium', 'social', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('442', 'facebook_url', 'https://facebook.com/azkamandiri.aluminium', 'social', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('443', 'tiktok_url', 'https://tiktok.com/@azkamandiri', 'social', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('444', 'youtube_url', 'https://youtube.com/@azkamandiri', 'social', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('445', 'meta_title', 'AzkaMandiri – Jasa Aluminium & Kaca Berkualitas Profesional', 'seo', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('446', 'meta_description', 'Jasa pembuatan dan pemasangan kusen aluminium, jendela aluminium, pintu kaca tempered, partisi ruko, kanopi kaca, dan shower box terpercaya di Jabodetabek.', 'seo', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('447', 'meta_keywords', 'kusen aluminium, jendela aluminium, pintu aluminium, partisi kaca, kaca tempered jabodetabek, kanopi kaca, shower box bintaro, azkamandiri', 'seo', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('448', 'logo_path', '/assets/brand/logo-horizontal.svg', 'assets', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('449', 'logo_dark_path', '/assets/brand/logo-horizontal-dark.svg', 'assets', '2026-11-14 21:41:07', '2026-11-14 21:41:07'),
('450', 'favicon_path', '/assets/brand/favicon.svg', 'assets', '2026-11-14 21:41:07', '2026-11-14 21:41:07');

-- --------------------------------------------------------
-- Table structure for table `stock_adjustments`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `stock_adjustments`;
CREATE TABLE `stock_adjustments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `adjustment_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `date` date NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `reason` enum('stock_opname','damaged','project_usage','return','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'stock_opname',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_adjustments_adjustment_code_unique` (`adjustment_code`),
  KEY `stock_adjustments_product_id_foreign` (`product_id`),
  KEY `stock_adjustments_user_id_foreign` (`user_id`),
  CONSTRAINT `stock_adjustments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stock_adjustments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `stock_adjustments`
INSERT INTO `stock_adjustments` (`id`, `adjustment_code`, `product_id`, `user_id`, `date`, `type`, `quantity`, `reason`, `notes`, `created_at`, `updated_at`) VALUES 
('18', 'ADJ-202611-0001', '250', '52', '2026-11-10', 'out', '1.00', 'damaged', 'Satu tube sealant bocor kemasan saat bongkar muat.', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `suppliers`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `suppliers`
INSERT INTO `suppliers` (`id`, `name`, `company_name`, `phone`, `email`, `address`, `notes`, `is_active`, `created_at`, `updated_at`) VALUES 
('69', 'Bpk. Surya Wijaya', 'PT Duta Aluminium Nusantara', '081299887766', 'sales@dutaaluminium.co.id', 'Kawasan Industri Jatake, Blok C No. 12, Tangerang', 'Distributor utama profil aluminium Alexindo, Dacon, dan Inkalum. Tempo 30 hari.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('70', 'Ibu Liana Tan', 'Toko Kaca Asahi Prima Mandiri', '081388776655', 'order@asahiprima.com', 'Jl. Daan Mogot Km. 14, Jakarta Barat', 'Supplier kaca lembaran polos, tempered, dan laminated standar Asahi Mas.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('71', 'Bpk. Hendry Salim', 'CV Mitra Hardware Aluminium', '085711223344', 'mitra.hardware@gmail.com', 'Pusat Niaga Roxy Mas Lt. 2 No. 45, Jakarta Pusat', 'Aksesoris merek Dekkson, Hampton, Kinlong, dan Belleza.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('72', 'Bpk. Budi Santoso', 'UD Sinar Makmur Sealant & Bahan', '087822334455', 'sinarmakmur.sealant@gmail.com', 'Jl. Raya Serpong No. 88, Tangerang Selatan', 'Sealant Dowsil 791/795, karet hitam EPDM, dan sekrup stainless.', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `testimonials`
INSERT INTO `testimonials` (`id`, `client_name`, `client_role`, `photo`, `content`, `rating`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES 
('52', 'Bpk. Bambang S.', 'Pemilik Rumah – BSD City (Sample Demo)', NULL, 'Pemasangan kusen dan jendela aluminium untuk renovasi rumah sangat rapi, siku-sikunya presisi dan tidak ada goresan. Komunikasi lewat WhatsApp sangat cepat dan jelas.', '5', '1', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('53', 'Ibu Maya Larasati', 'Desainer Interior – Jakarta (Sample Demo)', NULL, 'Sering bekerja sama dengan AzkaMandiri untuk partisi kaca kantor dan shower box apartemen. Kualitas material sesuai pesanan dan waktu pengerjaan on time.', '5', '2', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('54', 'Bpk. Ferry Kurniawan', 'Pemilik Ruko – Tangerang (Sample Demo)', NULL, 'Pintu sliding kaca ruko saya terpasang dengan baik. Relnya halus, aksesoris kunci juga kokoh. Harga sangat wajar dibandingkan kompetitor.', '5', '3', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `transaction_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `transaction_items`;
CREATE TABLE `transaction_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '1.00',
  `unit_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `cost_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `specification` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_items_transaction_id_foreign` (`transaction_id`),
  KEY `transaction_items_product_id_foreign` (`product_id`),
  CONSTRAINT `transaction_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transaction_items_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `transaction_items`
INSERT INTO `transaction_items` (`id`, `transaction_id`, `product_id`, `quantity`, `unit_price`, `cost_price`, `subtotal`, `specification`, `created_at`, `updated_at`) VALUES 
('69', '35', '239', '2.00', '175000.00', '125000.00', '350000.00', 'Panjang utuh 6m', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('70', '35', '250', '3.00', '60000.00', '42000.00', '180000.00', 'Warna hitam', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('71', '36', '252', '2.00', '1650000.00', '950000.00', '3300000.00', 'Ukuran 210 x 90 cm, aluminium putih coating, kaca es 5mm', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('72', '36', '246', '2.00', '260000.00', '180000.00', '520000.00', 'Handle Dekkson SUS 304', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `transactions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `invoice_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `transaction_date` datetime NOT NULL,
  `order_type` enum('retail','project_custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'retail',
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `change_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_type` enum('cash','transfer','qris') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `payment_status` enum('paid','partial','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `due_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_invoice_code_unique` (`invoice_code`),
  KEY `transactions_customer_id_foreign` (`customer_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `transactions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `transactions`
INSERT INTO `transactions` (`id`, `invoice_code`, `customer_id`, `user_id`, `transaction_date`, `order_type`, `subtotal`, `discount_amount`, `tax_amount`, `total_amount`, `paid_amount`, `change_amount`, `payment_type`, `payment_status`, `due_date`, `notes`, `created_at`, `updated_at`) VALUES 
('35', 'INV-202611-0001', '69', '52', '2026-11-12 10:30:00', 'retail', '530000.00', '30000.00', '0.00', '500000.00', '500000.00', '0.00', 'cash', 'paid', NULL, 'Pembelian eceran bahan aluminium kusen dan sealant.', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('36', 'INV-202611-0002', '70', '52', '2026-11-13 14:15:00', 'project_custom', '3820000.00', '20000.00', '0.00', '3800000.00', '2000000.00', '0.00', 'transfer', 'partial', '2026-11-21', 'Pesanan 2 unit pintu swing aluminium klinik estetika Bintaro. DP 2 juta via Transfer BCA, sisa 1.8 juta dilunasi saat serah terima.', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `units`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `units`
INSERT INTO `units` (`id`, `name`, `symbol`, `description`, `is_active`, `created_at`, `updated_at`) VALUES 
('137', 'Batang', 'btg', 'Satuan panjang standar profil aluminium (6 meter)', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('138', 'Lembar', 'lbr', 'Satuan bidang lembaran kaca atau panel aluminium', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('139', 'Meter', 'm', 'Satuan panjang linier pemotongan bahan', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('140', 'Pcs', 'pcs', 'Satuan per biji/buah komponen', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('141', 'Set', 'set', 'Satuan kelengkapan sepasang (handle, kunci, engsel)', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('142', 'Unit', 'unit', 'Satuan barang jadi atau rakitan siap pasang', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('143', 'Roll', 'roll', 'Satuan gulungan karet atau pelindung profil', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('144', 'Dus', 'dus', 'Satuan kemasan kotak sekrup atau aksesoris massal', '1', '2026-11-14 21:41:08', '2026-11-14 21:41:08');

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES 
('52', 'Administrator AzkaMandiri', 'admin@azkamandiri.com', '081932735383', '2026-11-14 21:41:07', '$2y$12$GiYv/UUgwKIUgcMAMS3IjeckYejCdEKKUFy1qHXVqkW/pXwmrmTN6', '1', NULL, '2026-11-14 21:41:07', '2026-11-14 21:41:08'),
('53', 'Siti Kasir', 'kasir@azkamandiri.com', '081298765432', NULL, '$2y$12$YHLFAH6P4no2SgfGd784TOLHNNxFenOOU079kjpDP5mIHJI0GwaKu', '1', NULL, '2026-11-14 21:41:08', '2026-11-14 21:41:08'),
('54', 'Budi Gudang', 'gudang@azkamandiri.com', '081345678901', NULL, '$2y$12$LR9H7Rtce4MUiSJzRPu0IueaFQcJqOuzFdRX1pu51PjgydbJW8rmK', '1', NULL, '2026-11-14 21:41:09', '2026-11-14 21:41:09');

SET FOREIGN_KEY_CHECKS = 1;
