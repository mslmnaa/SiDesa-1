<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Models\Village;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada category dan village terlebih dahulu
        $categories = Category::all();
        $villages = Village::all();

        if ($categories->isEmpty() || $villages->isEmpty()) {
            $this->command->info('Silakan jalankan CategorySeeder dan VillageSeeder terlebih dahulu');
            return;
        }

        // Get random categories for variation
        $barangCategories = $categories->where('type', 'barang');
        $jasaCategories = $categories->where('type', 'jasa');

        $products = [
            // BUMDes Maju Jaya (Village 1) - Lembang Agricultural Products
            ['name' => 'Sayur Organik Paket A', 'description' => 'Paket sayur organik segar: kangkung, bayam, sawi. Langsung dari kebun Lembang.', 'price' => 35000, 'stock' => 150, 'village_id' => 1, 'type' => 'barang'],
            ['name' => 'Strawberry Segar 500gr', 'description' => 'Strawberry manis pilihan dari kebun Lembang. Segar dan berkualitas premium.', 'price' => 45000, 'stock' => 80, 'village_id' => 1, 'type' => 'barang'],
            ['name' => 'Kerajinan Bambu Lampu Gantung', 'description' => 'Lampu gantung dari bambu pilihan. Desain unik dan ramah lingkungan.', 'price' => 250000, 'stock' => 30, 'village_id' => 1, 'type' => 'barang'],
            ['name' => 'Selai Strawberry Homemade', 'description' => 'Selai strawberry buatan rumahan tanpa pengawet. Manis alami dan lezat.', 'price' => 35000, 'stock' => 100, 'village_id' => 1, 'type' => 'barang'],
            ['name' => 'Brokoli Organik Fresh', 'description' => 'Brokoli segar organik tanpa pestisida. Kaya nutrisi dan vitamin.', 'price' => 28000, 'stock' => 120, 'village_id' => 1, 'type' => 'barang'],

            // BUMDes Sejahtera Ungaran (Village 2) - Traditional Food
            ['name' => 'Lunpia Semarang Frozen', 'description' => 'Lunpia rebung khas Semarang dalam kemasan frozen. Tinggal goreng!', 'price' => 40000, 'stock' => 200, 'village_id' => 2, 'type' => 'barang'],
            ['name' => 'Wingko Babat Original', 'description' => 'Wingko babat asli Semarang dengan rasa kelapa yang khas.', 'price' => 25000, 'stock' => 180, 'village_id' => 2, 'type' => 'barang'],
            ['name' => 'Bandeng Presto Juwana', 'description' => 'Bandeng presto tanpa duri, bumbu khas Juwana. Siap santap!', 'price' => 55000, 'stock' => 90, 'village_id' => 2, 'type' => 'barang'],
            ['name' => 'Tahu Bakso Ungaran', 'description' => 'Tahu bakso khas Ungaran dengan isian bakso sapi pilihan.', 'price' => 30000, 'stock' => 150, 'village_id' => 2, 'type' => 'barang'],
            ['name' => 'Jenang Kudus Tradisional', 'description' => 'Jenang khas Kudus berbagai rasa: kacang, ketan hitam, gula merah.', 'price' => 35000, 'stock' => 120, 'village_id' => 2, 'type' => 'barang'],

            // Desa Kreatif Sidoarjo (Village 3) - Creative Fashion
            ['name' => 'Tas Kulit Sintetis Premium', 'description' => 'Tas kulit sintetis berkualitas tinggi buatan pengrajin Sidoarjo.', 'price' => 185000, 'stock' => 60, 'village_id' => 3, 'type' => 'barang'],
            ['name' => 'Sepatu Sneakers Lokal', 'description' => 'Sepatu sneakers kualitas ekspor dari Tanggulangin. Nyaman dan stylish.', 'price' => 275000, 'stock' => 45, 'village_id' => 3, 'type' => 'barang'],
            ['name' => 'Dompet Pria Kulit Asli', 'description' => 'Dompet kulit asli untuk pria. Desain minimalis dan elegan.', 'price' => 125000, 'stock' => 80, 'village_id' => 3, 'type' => 'barang'],
            ['name' => 'Hijab Segi Empat Premium', 'description' => 'Hijab premium bahan voal dengan jahitan rapi. Berbagai warna tersedia.', 'price' => 45000, 'stock' => 200, 'village_id' => 3, 'type' => 'barang'],
            ['name' => 'Ikat Pinggang Kulit', 'description' => 'Ikat pinggang kulit asli dengan gesper elegant. Awet dan berkualitas.', 'price' => 95000, 'stock' => 70, 'village_id' => 3, 'type' => 'barang'],

            // BUMDes Mandiri Ubud (Village 4) - Organic & Eco-Friendly
            ['name' => 'Kopi Arabika Bali 200gr', 'description' => 'Kopi arabika premium dari kebun Kintamani. Aroma khas dan rasa nikmat.', 'price' => 75000, 'stock' => 100, 'village_id' => 4, 'type' => 'barang'],
            ['name' => 'Beras Merah Organik 5kg', 'description' => 'Beras merah organik dari Bali. Kaya serat dan nutrisi.', 'price' => 85000, 'stock' => 120, 'village_id' => 4, 'type' => 'barang'],
            ['name' => 'Minyak Kelapa VCO 500ml', 'description' => 'Virgin Coconut Oil murni 100%. Baik untuk kesehatan dan kecantikan.', 'price' => 65000, 'stock' => 150, 'village_id' => 4, 'type' => 'barang'],
            ['name' => 'Teh Hijau Organik Bali', 'description' => 'Teh hijau organik dari perkebunan Bali. Segar dan menyehatkan.', 'price' => 45000, 'stock' => 130, 'village_id' => 4, 'type' => 'barang'],
            ['name' => 'Madu Hutan Bali 500ml', 'description' => 'Madu hutan murni dari pedalaman Bali. Kaya manfaat dan antioksidan.', 'price' => 95000, 'stock' => 80, 'village_id' => 4, 'type' => 'barang'],

            // Desa Berkah Bantul (Village 5) - Batik & Handicraft
            ['name' => 'Batik Tulis Motif Parang', 'description' => 'Kain batik tulis asli dengan motif parang khas Yogyakarta.', 'price' => 450000, 'stock' => 25, 'village_id' => 5, 'type' => 'barang'],
            ['name' => 'Kemeja Batik Cap Pria', 'description' => 'Kemeja batik cap untuk pria. Nyaman dan cocok untuk berbagai acara.', 'price' => 185000, 'stock' => 60, 'village_id' => 5, 'type' => 'barang'],
            ['name' => 'Gerabah Pot Tanaman Hias', 'description' => 'Pot gerabah khas Kasongan untuk tanaman hias. Tahan lama dan artistik.', 'price' => 45000, 'stock' => 100, 'village_id' => 5, 'type' => 'barang'],
            ['name' => 'Tas Anyaman Mendong', 'description' => 'Tas anyaman mendong buatan tangan. Eco-friendly dan fashionable.', 'price' => 125000, 'stock' => 50, 'village_id' => 5, 'type' => 'barang'],
            ['name' => 'Wayang Kulit Souvenir Mini', 'description' => 'Wayang kulit mini untuk souvenir atau dekorasi. Karya seniman lokal.', 'price' => 75000, 'stock' => 40, 'village_id' => 5, 'type' => 'barang'],

            // BUMDes Makmur Bogor (Village 6) - Fruit Products
            ['name' => 'Selai Strawberry Puncak 300gr', 'description' => 'Selai strawberry asli dari Puncak. Manis segar tanpa pengawet.', 'price' => 45000, 'stock' => 120, 'village_id' => 6, 'type' => 'barang'],
            ['name' => 'Manisan Carica Dieng', 'description' => 'Manisan carica khas Dieng dalam sirup. Segar dan unik.', 'price' => 35000, 'stock' => 100, 'village_id' => 6, 'type' => 'barang'],
            ['name' => 'Keripik Apel Manis', 'description' => 'Keripik apel renyah dari Malang. Camilan sehat dan lezat.', 'price' => 28000, 'stock' => 150, 'village_id' => 6, 'type' => 'barang'],
            ['name' => 'Teh Hijau Puncak 100gr', 'description' => 'Teh hijau dari perkebunan Puncak. Aroma harum dan menyegarkan.', 'price' => 40000, 'stock' => 130, 'village_id' => 6, 'type' => 'barang'],
            ['name' => 'Sirup Markisa Homemade', 'description' => 'Sirup markisa buatan rumahan. Asam manis segar untuk minuman.', 'price' => 35000, 'stock' => 110, 'village_id' => 6, 'type' => 'barang'],

            // Desa Mekar Magelang (Village 7) - Coffee & Tea
            ['name' => 'Kopi Robusta Merapi 250gr', 'description' => 'Kopi robusta dari lereng Merapi. Body kuat dan aroma khas.', 'price' => 55000, 'stock' => 140, 'village_id' => 7, 'type' => 'barang'],
            ['name' => 'Kopi Arabika Merapi 250gr', 'description' => 'Kopi arabika premium dengan keasaman seimbang. Cocok untuk pour over.', 'price' => 75000, 'stock' => 100, 'village_id' => 7, 'type' => 'barang'],
            ['name' => 'Madu Hutan Lereng Merapi', 'description' => 'Madu hutan murni dari pegunungan Merapi. Kaya nutrisi alami.', 'price' => 85000, 'stock' => 70, 'village_id' => 7, 'type' => 'barang'],
            ['name' => 'Teh Rosella Kering', 'description' => 'Teh rosella kering untuk minuman sehat. Kaya antioksidan.', 'price' => 30000, 'stock' => 120, 'village_id' => 7, 'type' => 'barang'],
            ['name' => 'Jahe Merah Bubuk Instan', 'description' => 'Jahe merah bubuk instant untuk minuman hangat. Praktis dan menyehatkan.', 'price' => 25000, 'stock' => 150, 'village_id' => 7, 'type' => 'barang'],

            // BUMDes Harapan Lombok (Village 8) - Woven Products
            ['name' => 'Kain Tenun Ikat Lombok', 'description' => 'Kain tenun ikat khas Lombok dengan motif tradisional. Cantik dan eksklusif.', 'price' => 350000, 'stock' => 30, 'village_id' => 8, 'type' => 'barang'],
            ['name' => 'Tas Anyaman Rotan Lombok', 'description' => 'Tas anyaman rotan untuk santai atau jalan-jalan. Kuat dan stylish.', 'price' => 145000, 'stock' => 60, 'village_id' => 8, 'type' => 'barang'],
            ['name' => 'Sandal Jepit Anyaman', 'description' => 'Sandal jepit anyaman khas Lombok. Nyaman untuk aktivitas sehari-hari.', 'price' => 45000, 'stock' => 100, 'village_id' => 8, 'type' => 'barang'],
            ['name' => 'Topi Anyaman Pantai', 'description' => 'Topi anyaman untuk ke pantai atau berkebun. Melindungi dari sinar matahari.', 'price' => 55000, 'stock' => 80, 'village_id' => 8, 'type' => 'barang'],
            ['name' => 'Tempat Tisu Anyaman Rotan', 'description' => 'Tempat tisu dari anyaman rotan. Dekorasi unik dan fungsional.', 'price' => 35000, 'stock' => 90, 'village_id' => 8, 'type' => 'barang'],

            // Desa Subur Malang (Village 9) - Hydroponic & Fruits
            ['name' => 'Sayur Hidroponik Paket Sehat', 'description' => 'Paket sayuran hidroponik: selada, pakchoy, kailan. Segar tanpa pestisida.', 'price' => 40000, 'stock' => 120, 'village_id' => 9, 'type' => 'barang'],
            ['name' => 'Apel Malang Premium 1kg', 'description' => 'Apel Malang manis dan renyah. Kualitas premium langsung dari kebun.', 'price' => 55000, 'stock' => 150, 'village_id' => 9, 'type' => 'barang'],
            ['name' => 'Brokoli Hidroponik Segar', 'description' => 'Brokoli hasil hidroponik. Bersih, segar, dan kaya nutrisi.', 'price' => 32000, 'stock' => 100, 'village_id' => 9, 'type' => 'barang'],
            ['name' => 'Selada Keriting Hidroponik', 'description' => 'Selada keriting hidroponik untuk salad. Renyah dan segar.', 'price' => 18000, 'stock' => 130, 'village_id' => 9, 'type' => 'barang'],
            ['name' => 'Sari Apel Murni 1 Liter', 'description' => 'Sari apel murni tanpa gula tambahan. Sehat dan menyegarkan.', 'price' => 45000, 'stock' => 90, 'village_id' => 9, 'type' => 'barang'],

            // BUMDes Sentosa Solo (Village 10) - Batik
            ['name' => 'Kain Batik Cap Motif Kawung', 'description' => 'Kain batik cap dengan motif kawung khas Solo. Elegan dan berkelas.', 'price' => 250000, 'stock' => 40, 'village_id' => 10, 'type' => 'barang'],
            ['name' => 'Kemeja Batik Lengan Panjang', 'description' => 'Kemeja batik lengan panjang untuk acara formal. Nyaman dan berkelas.', 'price' => 225000, 'stock' => 50, 'village_id' => 10, 'type' => 'barang'],
            ['name' => 'Dress Batik Wanita Modern', 'description' => 'Dress batik modern untuk wanita. Kombinasi tradisional dan kontemporer.', 'price' => 285000, 'stock' => 35, 'village_id' => 10, 'type' => 'barang'],
            ['name' => 'Scarf Batik Sutra', 'description' => 'Scarf batik dari sutra halus. Aksesoris mewah untuk penampilan elegan.', 'price' => 150000, 'stock' => 60, 'village_id' => 10, 'type' => 'barang'],
            ['name' => 'Sarung Batik Pria Premium', 'description' => 'Sarung batik untuk pria. Motif khas Solo dengan kualitas terbaik.', 'price' => 175000, 'stock' => 70, 'village_id' => 10, 'type' => 'barang'],
        ];

        foreach ($products as $product) {
            // Randomly assign category based on type
            $categoryId = $product['type'] === 'barang'
                ? $barangCategories->random()->id
                : $jasaCategories->random()->id;

            Product::create([
                'name' => $product['name'],
                'slug' => \Illuminate\Support\Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'village_id' => $product['village_id'],
                'category_id' => $categoryId,
                'type' => $product['type'],
                'images' => [],
                'whatsapp_number' => null,
                'status' => 'active',
            ]);
        }

        $this->command->info('✅ ' . count($products) . ' produk berhasil dibuat untuk 10 desa!');
    }
}
