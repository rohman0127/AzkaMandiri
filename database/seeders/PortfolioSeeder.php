<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Residensial',
                'slug' => 'residensial',
                'description' => 'Proyek pemasangan aluminium dan kaca untuk rumah tinggal, cluster, dan perumahan.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Komersial & Kantor',
                'slug' => 'komersial-kantor',
                'description' => 'Pengerjaan partisi kantor, gedung bertingkat, dan ruang kerja profesional.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Ruko & Fasad Toko',
                'slug' => 'ruko-fasad-toko',
                'description' => 'Fasad etalase kaca, pintu kaca folding, dan kanopi ruko.',
                'sort_order' => 3,
            ],
        ];

        $catMap = [];
        foreach ($categories as $cat) {
            $created = PortfolioCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
            $catMap[$cat['slug']] = $created->id;
        }

        $portfolios = [
            [
                'category_slug' => 'residensial',
                'title' => 'Pemasangan Pintu Sliding & Jendela Casement Rumah Tinggal',
                'slug' => 'proyek-rumah-mewah-bsd',
                'client_name' => 'Bpk. Hendra Wijaya',
                'location' => 'Cluster Greenwich Park, BSD City, Tangerang',
                'completion_year' => '2025',
                'excerpt' => 'Fabrikasi dan pemasangan kusen aluminium Alexindo hitam powder coating untuk seluruh jendela casement dan pintu sliding balkon.',
                'description' => "Proyek ini mencakup pemasangan kusen aluminium tipe 4 inch dengan finishing hitam matte powder coating pada rumah 2 lantai.\n\nKlien menginginkan bukaan kaca yang lebar untuk memaksimalkan pemandangan taman samping dan sirkulasi udara alami. Seluruh kaca menggunakan kaca bening 6mm Asahimas dengan peredaman suara maksimal.",
                'main_image' => '/assets/images/portfolios/proyek-rumah-mewah-bsd.svg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'category_slug' => 'komersial-kantor',
                'title' => 'Partisi Kaca Tempered & Pintu Patch Fitting Office SCBD',
                'slug' => 'partisi-kantor-scbd',
                'client_name' => 'PT Sinergi Dinamika Abadi',
                'location' => 'Sudirman Central Business District (SCBD), Jakarta Selatan',
                'completion_year' => '2025',
                'excerpt' => 'Penyekat ruangan meeting dan direksi menggunakan kaca tempered 12mm frameless dengan aksesoris engsel tanam Dekkson.',
                'description' => "Pengerjaan partisi kaca interior kantor seluas 180 m2. Menggunakan sistem frameless dengan profil U stainless tanam di lantai dan plafon akustik.\n\nDilengkapi pintu kaca ganda patch fitting floor hinge heavy duty serta stiker kaca sandblast bermotif garis minimalis untuk menjaga privasi rapat bisnis.",
                'main_image' => '/assets/images/portfolios/partisi-kantor-scbd.svg',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'category_slug' => 'residensial',
                'title' => 'Kanopi Kaca Tempered Laminated & Carport Modern',
                'slug' => 'kanopi-kaca-villa-bogor',
                'client_name' => 'Ibu Ratna Dewi',
                'location' => 'Sentul City, Bogor, Jawa Barat',
                'completion_year' => '2025',
                'excerpt' => 'Konstruksi kanopi kaca tempered laminated 5+5mm dengan rangka baja hollow galvanis 50x100mm cat hitam doff anti karat.',
                'description' => "Kanopi carport dengan bentang 6 x 5 meter tanpa tiang tengah yang mengganggu ruang gerak manuver kendaraan. Menggunakan kaca laminated tahan benturan dengan lapisan film UV protection.\n\nSistem talang air tersembunyi dirancang rapi agar air hujan mengalir lancar tanpa resiko cipratan.",
                'main_image' => '/assets/images/portfolios/kanopi-kaca-villa-bogor.svg',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'category_slug' => 'residensial',
                'title' => 'Frameless Shower Screen Tempered Kamar Mandi',
                'slug' => 'shower-screen-apartemen-kemang',
                'client_name' => 'Bpk. Aris Pratama',
                'location' => 'Kemang, Jakarta Selatan',
                'completion_year' => '2026',
                'excerpt' => 'Pemasangan sekat kaca shower box L-shape kaca tempered 10mm dengan fitting stainless steel 304 gold satin finish.',
                'description' => "Shower box sudut L-shape yang memisahkan area kering dan basah secara elegan. Engsel kaca menggunakan material SUS 304 tahan karat jangka panjang.\n\nDisertai sealing silikon antimikroba (anti jamur) sehingga sudut kaca selalu bersih, bening, dan tidak mudah menghitam.",
                'main_image' => '/assets/images/portfolios/shower-screen-apartemen-kemang.svg',
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'category_slug' => 'residensial',
                'title' => 'Pintu Lipat Aluminium 6 Daun Teras Belakang',
                'slug' => 'pintu-lipat-folding-bintaro',
                'client_name' => 'Bpk. Dian Sastro',
                'location' => 'Kebayoran Residences, Bintaro Jaya Sektor 7',
                'completion_year' => '2026',
                'excerpt' => 'Pintu folding aluminium 6 daun menghubungkan ruang keluarga dengan kolam renang privat, bukaan 100% lapang.',
                'description' => "Pintu folding aluminium dengan rel bawah rata lantai (flush track) agar aman saat dilintasi anak-anak dan lansia. Roda rel bearing stainless berputar sangat halus tanpa hentakan.\n\nMemberikan efek ruangan multifungsi: tertutup kedap AC atau terbuka penuh saat acara keluarga besar.",
                'main_image' => '/assets/images/portfolios/pintu-lipat-folding-bintaro.svg',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'category_slug' => 'ruko-fasad-toko',
                'title' => 'Fasad Kaca Display Showroom & Toko Modern',
                'slug' => 'etalase-showroom-alam-sutera',
                'client_name' => 'CV Cahaya Gemilang',
                'location' => 'Ruko Prominence Alam Sutera, Tangerang',
                'completion_year' => '2026',
                'excerpt' => 'Pemasangan curtain wall kaca fasad dan pintu kaca geser otomatis untuk showroom otomotif & aksesoris.',
                'description' => "Fasad toko 2 lantai dengan bentang kaca 8 meter menggunakan frame aluminium tebal warna silver anodized. Hasil akhir rapi dan menonjolkan produk jualan di dalam showroom secara maksimal.",
                'main_image' => '/assets/images/portfolios/etalase-showroom-alam-sutera.svg',
                'is_featured' => false,
                'sort_order' => 6,
            ],
        ];

        foreach ($portfolios as $portData) {
            $catId = $catMap[$portData['category_slug']] ?? null;
            unset($portData['category_slug']);
            $portData['portfolio_category_id'] = $catId;
            $portData['meta_title'] = "{$portData['title']} – Portofolio AzkaMandiri";
            $portData['meta_description'] = Str::limit($portData['excerpt'], 155);

            $portfolio = Portfolio::updateOrCreate(['slug' => $portData['slug']], $portData);

            PortfolioImage::firstOrCreate([
                'portfolio_id' => $portfolio->id,
                'image_path' => $portfolio->main_image,
                'caption' => "Dokumentasi Proyek: {$portfolio->title}",
                'sort_order' => 1,
            ]);
        }
    }
}

