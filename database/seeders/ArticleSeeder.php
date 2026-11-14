<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tips & Panduan',
                'slug' => 'tips-panduan',
                'description' => 'Tips bermanfaat seputar pemilihan, perawatan, dan instalasi aluminium kaca.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Material & Spesifikasi',
                'slug' => 'material-spesifikasi',
                'description' => 'Mengenal kualitas profil aluminium, jenis kaca, dan aksesoris bangunan.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Inspirasi Desain',
                'slug' => 'inspirasi-desain',
                'description' => 'Inspirasi model pintu, jendela, partisi, dan kanopi arsitektur modern.',
                'sort_order' => 3,
            ],
        ];

        $catMap = [];
        foreach ($categories as $cat) {
            $created = ArticleCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
            $catMap[$cat['slug']] = $created->id;
        }

        $articles = [
            [
                'category_slug' => 'material-spesifikasi',
                'title' => 'Panduan Memilih Kusen Aluminium: YKK vs Alexindo vs Dacon',
                'slug' => 'panduan-memilih-kusen-aluminium-ykk-vs-alexindo',
                'excerpt' => 'Bingung menentukan merek kusen aluminium untuk rumah Anda? Simak perbandingan ketebalan profil, warna, kelebihan, dan kisaran harganya di sini.',
                'content' => "Dalam memilih kusen aluminium untuk rumah tinggal maupun ruko, ada tiga merek ternama yang paling sering digunakan di Indonesia: YKK AP, Alexindo, dan Dacon.\n\n### 1. Profil YKK AP (Kualitas Premium)\nYKK AP dikenal sebagai standar tertinggi kusen aluminium di Indonesia. Keunggulannya terletak pada ketebalan dinding profil (mencapai 1.35mm - 1.4mm), komposisi paduan aluminium murni (Alloy 6063), dan finishing anodizing yang sangat tahan gores serta tahan paparan asam garam pantai. Kusen YKK memiliki harga paling tinggi namun memiliki durabilitas paling panjang.\n\n### 2. Profil Alexindo (Pilihan Terpopuler)\nAlexindo adalah merek yang paling populer dan banyak digunakan oleh kontraktor maupun pemilik rumah pribadi. Menawarkan ketebalan ideal (sekitar 1.0mm - 1.15mm) dengan variasi warna powder coating yang luas. Nilai keekonomisannya sangat baik dengan kualitas yang kokoh dan tahan puluhan tahun.\n\n### 3. Profil Dacon & Inkalum (Ekonomis)\nBagi Anda yang memiliki anggaran terukur, profil Dacon atau Inkalum memberikan alternatif yang sangat baik. Ketebalan profil berkisar 0.8mm - 0.95mm yang cukup kokoh untuk jendela dan sekat partisi interior.\n\nAzkaMandiri siap membantu Anda memilih profil yang paling tepat sesuai kebutuhan desain dan anggaran proyek Anda. Hubungi kami untuk konsultasi gratis!",
                'thumbnail' => '/assets/images/articles/panduan-memilih-kusen-aluminium-ykk-vs-alexindo.svg',
                'author_name' => 'Tim Teknis AzkaMandiri',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'views_count' => 142,
            ],
            [
                'category_slug' => 'tips-panduan',
                'title' => '5 Keunggulan Kaca Tempered untuk Pintu, Kanopi, dan Partisi Rumah',
                'slug' => 'keunggulan-kaca-tempered-untuk-hunian',
                'excerpt' => 'Mengapa arsitek modern selalu merekomendasikan kaca tempered untuk area rawan benturan? Ketahui alasan keamanan dan estetika di balik kepopulerannya.',
                'content' => "Kaca tempered kini menjadi standar keselamatan wajib dalam arsitektur modern. Berikut adalah 5 alasan utama mengapa Anda wajib mempertimbangkan kaca tempered:\n\n1. **Kekuatan Mekanis Hingga 5 Kali Lipat:** Kaca tempered diproses dengan pemanasan termal terkontrol hingga 700°C yang mengubah struktur molekulnya menjadi jauh lebih padat dan tahan benturan keras.\n2. **Toleransi Perubahan Suhu Ekstrem:** Mampu menahan perbedaan suhu hingga 200°C tanpa retak, sangat aman untuk kanopi atap yang terpapar sinar matahari terik.\n3. **Faktor Keamanan Tingkat Tinggi (Safety Glass):** Jika terkena benturan luar biasa melampaui batas elastisitasnya, kaca tempered tidak pecah menjadi pecahan tajam meruncing, melainkan butiran-butiran tumpul seperti jagung yang minim resiko melukai tubuh.\n4. **Tampilan Bersih & Minimalis:** Ketebalannya yang kokoh memungkinkan pembuatan pintu dan sekat frameless (tanpa kusen bingkai) yang elegan.\n5. **Meningkatkan Nilai Properti:** Hunian dengan instalasi kaca tempered berkualitas memiliki nilai jual dan prestise yang lebih tinggi.",
                'thumbnail' => '/assets/images/articles/keunggulan-kaca-tempered-untuk-hunian.svg',
                'author_name' => 'Tim Arsitektur AzkaMandiri',
                'status' => 'published',
                'published_at' => now()->subDays(6),
                'views_count' => 98,
            ],
            [
                'category_slug' => 'tips-panduan',
                'title' => 'Cara Merawat Pintu dan Jendela Aluminium Agar Selalu Halus dan Berkilau',
                'slug' => 'tips-merawat-pintu-dan-jendela-aluminium',
                'excerpt' => 'Perawatan aluminium sebenarnya sangat mudah jika Anda mengetahui trik dasarnya. Hindari cairan kimia keras yang dapat merusak lapisan cat.',
                'content' => "Kusen dan pintu aluminium terkenal minim perawatan, namun dengan langkah perawatan sederhana berikut, tampilannya akan selalu seperti baru:\n\n- **Bersihkan Rel Sliding Secara Berkala:** Debu dan pasir kecil pada rel geser sering menjadi penyebab roda macet. Cukup sedot debu dengan vacuum cleaner atau sikat kecil seminggu sekali.\n- **Gunakan Sabun Lembut (Netral):** Campurkan air hangat dengan sedikit sabun cuci piring lembut. Hindari pembersih berbahan asam tinggi atau tiner yang dapat merusak lapisan powder coating.\n- **Pelumasan Hardware:** Berikan beberapa tetes oli mesin jahit atau pelumas silikon spray pada engsel dan silinder kunci setiap 6 bulan sekali.\n- **Periksa Karet Kaca (Gasket):** Pastikan karet penjepit kaca tetap elastis dan tidak getas agar kekedapan air tetap optimal saat musim hujan.",
                'thumbnail' => '/assets/images/articles/tips-merawat-pintu-dan-jendela-aluminium.svg',
                'author_name' => 'Admin AzkaMandiri',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'views_count' => 67,
            ],
            [
                'category_slug' => 'inspirasi-desain',
                'title' => 'Inspirasi Partisi Kaca Minimalis untuk Kantor Nyaman dan Kedap Suara',
                'slug' => 'inspirasi-partisi-kaca-kantor-minimalis',
                'excerpt' => 'Ciptakan suasana kantor modern yang kolaboratif namun tetap tenang dengan kombinasi partisi kaca frameless dan profil aluminium ramping.',
                'content' => "Tata ruang kantor terbuka (open plan) sering menghadapi kendala kebisingan yang mengganggu konsentrasi karyawan. Penggunaan partisi aluminium kaca tempered adalah solusi paling seimbang.\n\nDengan partisi kaca, cahaya alami bebas masuk ke seluruh penjuru ruangan kerja sehingga menghemat biaya listrik pencahayaan, sementara ruangan tetap kedap suara saat meeting penting berlangsung. Tambahan aksen stiker sandblast bermotif korporat dapat memberikan sentuhan elegan dan profesional bagi setiap klien yang berkunjung.",
                'thumbnail' => '/assets/images/articles/inspirasi-partisi-kaca-kantor-minimalis.svg',
                'author_name' => 'Tim Desain AzkaMandiri',
                'status' => 'published',
                'published_at' => now()->subDay(),
                'views_count' => 54,
            ],
        ];

        foreach ($articles as $artData) {
            $catId = $catMap[$artData['category_slug']] ?? null;
            unset($artData['category_slug']);
            $artData['article_category_id'] = $catId;
            $artData['meta_title'] = "{$artData['title']} – Artikel AzkaMandiri";
            $artData['meta_description'] = Str::limit($artData['excerpt'], 155);

            Article::updateOrCreate(['slug' => $artData['slug']], $artData);
        }
    }
}

