<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kusen & Pintu',
                'slug' => 'kusen-pintu',
                'description' => 'Kusen dan daun pintu aluminium berbagai model untuk interior dan eksterior.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Jendela Modern',
                'slug' => 'jendela-modern',
                'description' => 'Jendela aluminium model geser, jungkit, casement, dan pivot.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Partisi & Kaca',
                'slug' => 'partisi-kaca',
                'description' => 'Penyekat ruangan kantor, ruko, dan kaca tempered standar arsitektur.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Kanopi & Eksterior',
                'slug' => 'kanopi-eksterior',
                'description' => 'Kanopi kaca tempered laminated dan fasad arsitektur modern.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Interior & Kamar Mandi',
                'slug' => 'interior-kamar-mandi',
                'description' => 'Shower screen kaca, kitchen set aluminium anti rayap, dan etalase toko.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Pekerjaan Custom',
                'slug' => 'pekerjaan-custom',
                'description' => 'Pembuatan profil khusus aluminium dan kaca sesuai spesifikasi arsitek.',
                'sort_order' => 6,
            ],
        ];

        $catMap = [];
        foreach ($categories as $cat) {
            $created = ServiceCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
            $catMap[$cat['slug']] = $created->id;
        }

        $services = [
            [
                'category_slug' => 'kusen-pintu',
                'name' => 'Kusen Aluminium',
                'slug' => 'kusen-aluminium',
                'excerpt' => 'Pemasangan kusen aluminium 3 inch dan 4 inch berkualitas tinggi dengan finishing rapi, presisi miter joint, dan tahan cuaca.',
                'description' => "AzkaMandiri melayani pembuatan dan pemasangan kusen aluminium untuk berbagai kebutuhan bangunan seperti rumah tinggal, kantor, ruko, hingga gedung bertingkat.\n\nKami menyediakan pilihan profil merek terpercaya seperti Alexindo, YKK AP, Dacon, Inkalum, dan Forta. Setiap sambungan dipotong dengan mesin presisi miter saw sehingga sambungan sudut rapat tanpa celah kasar.\n\nPilihan warna meliputi Anodized Silver, Anodized Hitam, Anodized Cokelat, serta Powder Coating Putih, Cream, Urat Kayu (Wood Grain), dan warna custom lainnya.",
                'thumbnail' => '/assets/images/services/kusen-aluminium.svg',
                'main_image' => '/assets/images/services/kusen-aluminium.svg',
                'price_info' => 'Mulai Rp 120.000 / meter lari',
                'features' => ['Pilihan Profil 3" dan 4"', 'Merek Alexindo, YKK, Dacon', 'Powder Coating & Anodized', 'Anti Rayap & Anti Karat', 'Garansi Pemasangan Rapi'],
                'sort_order' => 1,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'jendela-modern',
                'name' => 'Jendela Aluminium',
                'slug' => 'jendela-aluminium',
                'excerpt' => 'Jendela aluminium modern model casement (jungkit), sliding (geser), pivot, dan fixed glass dengan seal kedap suara dan air.',
                'description' => "Jendela aluminium AzkaMandiri dirancang untuk memaksimalkan sirkulasi udara dan pencahayaan alami tanpa mengorbankan estetika dan keamanan rumah Anda.\n\nDilengkapi dengan karet gasket EPDM berkualitas dan aksesoris handle kunci mutakhir (Kinlong, Dekkson, Hampton), jendela kami memastikan kekedapan suara yang prima serta proteksi anti bocor saat hujan lebat.",
                'thumbnail' => '/assets/images/services/jendela-aluminium.svg',
                'main_image' => '/assets/images/services/jendela-aluminium.svg',
                'price_info' => 'Mulai Rp 650.000 / unit',
                'features' => ['Model Casement, Sliding, Jungkit', 'Karet Seal EPDM Tahan Bocor', 'Kunci Kinlong & Dekkson Kokoh', 'Bisa Custom Ukuran', 'Kaca Polos / Rayban / Es'],
                'sort_order' => 2,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'kusen-pintu',
                'name' => 'Pintu Aluminium',
                'slug' => 'pintu-aluminium',
                'excerpt' => 'Pintu swing, sliding, hingga pintu lipat (folding door) aluminium dengan desain minimalis elegan dan engsel berkualitas berat.',
                'description' => "Pintu aluminium merupakan solusi ideal untuk pintu utama, pintu balkon, pintu taman, maupun pintu kamar mandi. Kami memproduksi berbagai model pintu aluminium yang kokoh dan awet.\n\nKeunggulan pintu aluminium kami adalah konstruksi sudut yang diperkuat siku baja internal, pergerakan roda bearing yang halus tanpa suara berdecit, serta daya tahan tinggi terhadap kelembapan dan serangan rayap.",
                'thumbnail' => '/assets/images/services/pintu-aluminium.svg',
                'main_image' => '/assets/images/services/pintu-aluminium.svg',
                'price_info' => 'Mulai Rp 1.400.000 / daun pintu',
                'features' => ['Pintu Swing, Geser, & Lipat', 'Hardware Heavy-Duty', 'Panel Kaca Tempered / Aluminium Composite', 'Tersedia Model Minimalis Modern', 'Tahan Cuaca & Rayap'],
                'sort_order' => 3,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'partisi-kaca',
                'name' => 'Partisi Aluminium',
                'slug' => 'partisi-aluminium',
                'excerpt' => 'Penyekat ruangan kantor dan komersial dengan frame aluminium kokoh dan kaca bening/buram yang memberikan kesan luas dan profesional.',
                'description' => "Maksimalkan efisiensi ruang kantor atau ruko Anda dengan partisi aluminium dan kaca dari AzkaMandiri. Partisi ini memisahkan area kerja dengan tetap menjaga suasana terang, bersih, dan terbuka.\n\nKami juga menyediakan instalasi sandblast sticker untuk privasi ruang meeting serta integrasi jalur instalasi kabel elektrikal secara rapi.",
                'thumbnail' => '/assets/images/services/partisi-aluminium.svg',
                'main_image' => '/assets/images/services/partisi-aluminium.svg',
                'price_info' => 'Mulai Rp 450.000 / m2',
                'features' => ['Rangka Aluminium Kokoh', 'Kombinasi Kaca Polos / Buram / Sandblast', 'Peredaman Suara yang Baik', 'Pengerjaan Cepat & Bersih', 'Cocok untuk Kantor & Ruko'],
                'sort_order' => 4,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'partisi-kaca',
                'name' => 'Kaca Tempered',
                'slug' => 'kaca-tempered',
                'excerpt' => 'Pemasangan kaca tempered 8mm, 10mm, 12mm bersertifikasi SNI dengan kekuatan benturan 5x lebih tangguh dari kaca biasa.',
                'description' => "Kaca tempered adalah kaca safety yang telah diproses pemanasan termal tinggi hingga 700°C lalu didinginkan secara cepat. Menghasilkan kekuatan mekanis dan ketahanan panas yang luar biasa.\n\nSangat direkomendasikan untuk pintu frameless patch fitting, railing tangga, void balkon, kanopi, dan partisi dinding kaca gedung. Jika pecah, kaca tempered akan menjadi butiran tumpul kecil yang meminimalisir risiko cedera.",
                'thumbnail' => '/assets/images/services/kaca-tempered.svg',
                'main_image' => '/assets/images/services/kaca-tempered.svg',
                'price_info' => 'Mulai Rp 550.000 / m2 (8mm-12mm)',
                'features' => ['Standar Kaca SNI Resmi', 'Kekuatan 5x Kaca Biasa', 'Toleransi Suhu Ekstrem', 'Tepian Polish Halus (Bevel/Flat)', 'Aksesoris Stainless 304'],
                'sort_order' => 5,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'kanopi-eksterior',
                'name' => 'Kanopi Kaca',
                'slug' => 'kanopi-kaca',
                'excerpt' => 'Kanopi carport dan teras dengan kaca tempered atau laminated dipadu rangka hollow besi/baja WF yang modern dan mewah.',
                'description' => "Hadirkan tampilan fasad rumah mewah bergaya modern tropis dengan kanopi kaca AzkaMandiri. Struktur kanopi kami dihitung dengan cermat agar mampu menahan beban angin dan air hujan dengan aman.\n\nPenggunaan kaca tempered laminated dengan lembaran interlayer PVB memastikan perlindungan maksimal dari sinar UV sekaligus keamanan mutlak jika terjadi insiden kejatuhan benda.",
                'thumbnail' => '/assets/images/services/kanopi-kaca.svg',
                'main_image' => '/assets/images/services/kanopi-kaca.svg',
                'price_info' => 'Mulai Rp 1.350.000 / m2',
                'features' => ['Kaca Tempered Laminated 10mm-16mm', 'Rangka Hollow Galvanis Anti Karat / WF', 'Sealant Khusus Struktural Anti Bocor', 'Desain Modern & Bernilai Estetika Tinggi', 'Garansi Kebocoran'],
                'sort_order' => 6,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'interior-kamar-mandi',
                'name' => 'Shower Box',
                'slug' => 'shower-box',
                'excerpt' => 'Penyekat kaca kamar mandi frameless tempered 10mm dengan aksesoris engsel dan pipa header stainless steel 304 anti karat.',
                'description' => "Shower box atau shower screen kaca menjadikan kamar mandi Anda kering, bersih, dan berkelas hotel berbintang. Kami menyediakan model pintu swing dengan engsel glass-to-wall maupun sliding shower door yang hemat tempat.\n\nSemua aksesoris penjepit dan engsel menggunakan material stainless steel SUS 304 yang tahan terhadap kelembapan tinggi dan sabun kimia tanpa mengalami korosi.",
                'thumbnail' => '/assets/images/services/shower-box.svg',
                'main_image' => '/assets/images/services/shower-box.svg',
                'price_info' => 'Mulai Rp 2.200.000 / set',
                'features' => ['Kaca Tempered 10mm Safety', 'Hardware Full Stainless SUS 304', 'Karet Magnet Penutup Rapat', 'Model Sudut L, U, atau Straight', 'Bebas Kerak & Mudah Dibersihkan'],
                'sort_order' => 7,
                'is_featured' => true,
            ],
            [
                'category_slug' => 'interior-kamar-mandi',
                'name' => 'Etalase Kaca',
                'slug' => 'etalase-kaca',
                'excerpt' => 'Etalase kaca display jualan untuk toko, apotek, konter HP, bakery, dan showroom dengan frame aluminium kokoh dan rapi.',
                'description' => "Tingkatkan daya tarik produk jualan Anda dengan etalase kaca display custom buatan AzkaMandiri. Dibuat presisi dengan rak kaca bertingkat, pintu sliding beroda rel halus, dan kunci silinder aman.\n\nKami dapat menambahkan lampu LED strip tersembunyi untuk memberikan efek pencahayaan produk yang memukau calon pembeli Anda.",
                'thumbnail' => '/assets/images/services/etalase-kaca.svg',
                'main_image' => '/assets/images/services/etalase-kaca.svg',
                'price_info' => 'Mulai Rp 950.000 / unit',
                'features' => ['Custom Ukuran & Jumlah Rak', 'Roda Kunci / Roda Nylon Bergerak', 'Lampu LED Showcase Opsional', 'Kaca Bening Bervariasi 5-8mm', 'Kunci Silinder Keamanan'],
                'sort_order' => 8,
                'is_featured' => false,
            ],
            [
                'category_slug' => 'interior-kamar-mandi',
                'name' => 'Lemari Aluminium',
                'slug' => 'lemari-aluminium',
                'excerpt' => 'Kitchen set bawah/atas dan lemari pakaian berbahan aluminium composite panel (ACP) 100% anti rayap, tahan air, dan awet puluhan tahun.',
                'description' => "Bosan dengan lemari kayu atau partikel board yang mudah lapuk dan dimakan rayap? Lemari aluminium dan kitchen set dari AzkaMandiri adalah solusi abadi untuk hunian Anda.\n\nDilapisi Aluminium Composite Panel (ACP) berkualitas dengan aneka pilihan warna glossy, matte, marmer, atau corak kayu, lemari ini sangat higienis, mudah dilap, dan tidak berbau jamur.",
                'thumbnail' => '/assets/images/services/lemari-aluminium.svg',
                'main_image' => '/assets/images/services/lemari-aluminium.svg',
                'price_info' => 'Mulai Rp 2.100.000 / meter lari',
                'features' => ['100% Bebas Rayap & Jamur', 'Tahan Air & Lembap', 'Panel ACP Aneka Corak & Warna', 'Engsel Slow-Motion (Soft-Close)', 'Konstruksi Kuat & Ringan'],
                'sort_order' => 9,
                'is_featured' => false,
            ],
            [
                'category_slug' => 'pekerjaan-custom',
                'name' => 'Aluminium dan Kaca Custom',
                'slug' => 'custom-aluminium-kaca',
                'excerpt' => 'Pengerjaan spesialis desain khusus aluminium dan kaca sesuai gambar kerja arsitek, interior designer, atau kebutuhan unik proyek Anda.',
                'description' => "Apakah Anda memiliki desain arsitektural yang unik dan membutuhkan ketelitian fabrikasi khusus? AzkaMandiri siap menerjemahkan sketsa atau gambar kerja AutoCAD Anda menjadi kenyataan.\n\nKami melayani pembuatan louvre kisi-kisi aluminium, curtain wall gedung mini, skylight kaca atap, aquarium raksasa, hingga booth pameran custom dengan standar presisi tinggi.",
                'thumbnail' => '/assets/images/services/custom-aluminium-kaca.svg',
                'main_image' => '/assets/images/services/custom-aluminium-kaca.svg',
                'price_info' => 'Berdasarkan Spesifikasi & Gambar Proyek',
                'features' => ['Konsultasi Desain & Gambar Kerja', 'Fleksibilitas Bentuk & Dimensi', 'Pilihan Paduan Material Lengkap', 'Survei Lapangan Gratis', 'Garansi Kepuasan Pelanggan'],
                'sort_order' => 10,
                'is_featured' => true,
            ],
        ];

        foreach ($services as $srvData) {
            $catId = $catMap[$srvData['category_slug']] ?? null;
            unset($srvData['category_slug']);
            $srvData['service_category_id'] = $catId;
            $srvData['meta_title'] = "{$srvData['name']} – Jasa Pemasangan & Pembuatan AzkaMandiri";
            $srvData['meta_description'] = Str::limit($srvData['excerpt'], 155);

            $service = Service::updateOrCreate(['slug' => $srvData['slug']], $srvData);

            // Add gallery images
            ServiceImage::firstOrCreate([
                'service_id' => $service->id,
                'image_path' => $service->main_image,
                'caption' => "Pemasangan {$service->name} oleh AzkaMandiri",
                'sort_order' => 1,
            ]);
        }
    }
}

