<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Village;
use Illuminate\Support\Str;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villages = [
            [
                'name' => 'BUMDes Maju Jaya',
                'slug' => 'bumdes-maju-jaya',
                'description' => 'Pusat produk pertanian organik dan kerajinan tangan berkualitas tinggi dari Lembang. Terkenal dengan sayuran segar, buah-buahan lokal, dan kerajinan bambu.',
                'address' => 'Jl. Raya Lembang No. 123, Desa Cibodas',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
                'district' => 'Lembang',
                'phone' => '0226201234',
                'email' => 'info@bumdes-majujaya.id',
                'whatsapp' => '6281234567890',
                'status' => 'active',
            ],
            [
                'name' => 'BUMDes Sejahtera Ungaran',
                'slug' => 'bumdes-sejahtera-ungaran',
                'description' => 'Spesialis produk olahan makanan tradisional Jawa Tengah. Menyediakan jenang, wingko, lunpia, dan berbagai makanan ringan khas Semarang.',
                'address' => 'Jl. Raya Ungaran No. 45, Desa Genuk',
                'province' => 'Jawa Tengah',
                'city' => 'Semarang',
                'district' => 'Ungaran',
                'phone' => '0248901234',
                'email' => 'kontak@sejahtera-ungaran.id',
                'whatsapp' => '6281234567891',
                'status' => 'active',
            ],
            [
                'name' => 'Desa Kreatif Sidoarjo',
                'slug' => 'desa-kreatif-sidoarjo',
                'description' => 'Sentra UMKM kreatif dengan produk inovatif. Menyediakan tas, sepatu, fashion muslim, dan berbagai produk kreatif buatan tangan pengrajin lokal.',
                'address' => 'Jl. Industri Kreatif No. 78, Desa Tanggulangin',
                'province' => 'Jawa Timur',
                'city' => 'Sidoarjo',
                'district' => 'Tanggulangin',
                'phone' => '0318771234',
                'email' => 'hello@kreatif-sidoarjo.id',
                'whatsapp' => '6281234567892',
                'status' => 'active',
            ],
            [
                'name' => 'BUMDes Mandiri Ubud',
                'slug' => 'bumdes-mandiri-ubud',
                'description' => 'Pelopor produk pertanian organik dan eco-friendly di Bali. Menawarkan kopi organik, beras merah, virgin coconut oil, dan produk ramah lingkungan.',
                'address' => 'Jl. Raya Ubud No. 90, Desa Mas',
                'province' => 'Bali',
                'city' => 'Gianyar',
                'district' => 'Ubud',
                'phone' => '0361975123',
                'email' => 'admin@mandiri-ubud.id',
                'whatsapp' => '6281234567893',
                'status' => 'active',
            ],
            [
                'name' => 'Desa Berkah Bantul',
                'slug' => 'desa-berkah-bantul',
                'description' => 'Produsen fashion dan kerajinan khas Yogyakarta. Terkenal dengan batik tulis, kerajinan kulit, gerabah, dan produk seni tradisional.',
                'address' => 'Jl. Parangtritis Km. 12, Desa Manding',
                'province' => 'Daerah Istimewa Yogyakarta',
                'city' => 'Bantul',
                'district' => 'Bambanglipuro',
                'phone' => '0274367123',
                'email' => 'cs@berkah-bantul.id',
                'whatsapp' => '6281234567894',
                'status' => 'active',
            ],
            [
                'name' => 'BUMDes Makmur Bogor',
                'slug' => 'bumdes-makmur-bogor',
                'description' => 'Sentra agrowisata dengan produk olahan buah dan sayur khas Puncak. Menyediakan selai, manisan, keripik buah, dan produk herbal alami.',
                'address' => 'Jl. Raya Puncak KM 87, Desa Tugu Utara',
                'province' => 'Jawa Barat',
                'city' => 'Bogor',
                'district' => 'Cisarua',
                'phone' => '0251825123',
                'email' => 'info@makmur-bogor.id',
                'whatsapp' => '6281234567895',
                'status' => 'active',
            ],
            [
                'name' => 'Desa Mekar Magelang',
                'slug' => 'desa-mekar-magelang',
                'description' => 'Produsen kopi robusta dan arabika premium dari lereng Merapi. Dilengkapi dengan produk teh, madu hutan, dan camilan tradisional.',
                'address' => 'Jl. Kopikita No. 21, Desa Ngablak',
                'province' => 'Jawa Tengah',
                'city' => 'Magelang',
                'district' => 'Ngablak',
                'phone' => '0293598123',
                'email' => 'contact@mekar-magelang.id',
                'whatsapp' => '6281234567896',
                'status' => 'active',
            ],
            [
                'name' => 'BUMDes Harapan Lombok',
                'slug' => 'bumdes-harapan-lombok',
                'description' => 'Spesialis kerajinan tenun dan produk anyaman khas Lombok. Menawarkan kain tenun ikat, tas anyaman, dan souvenir khas Nusa Tenggara Barat.',
                'address' => 'Jl. Pariwisata No. 56, Desa Sukarara',
                'province' => 'Nusa Tenggara Barat',
                'city' => 'Lombok Tengah',
                'district' => 'Jonggat',
                'phone' => '0370663123',
                'email' => 'support@harapan-lombok.id',
                'whatsapp' => '6281234567897',
                'status' => 'active',
            ],
            [
                'name' => 'Desa Subur Malang',
                'slug' => 'desa-subur-malang',
                'description' => 'Penghasil sayuran hidroponik dan buah apel premium Malang. Menyediakan sayuran segar, buah organik, dan produk olahan buah berkualitas.',
                'address' => 'Jl. Agro No. 34, Desa Bumiaji',
                'province' => 'Jawa Timur',
                'city' => 'Malang',
                'district' => 'Batu',
                'phone' => '0341599123',
                'email' => 'info@subur-malang.id',
                'whatsapp' => '6281234567898',
                'status' => 'active',
            ],
            [
                'name' => 'BUMDes Sentosa Solo',
                'slug' => 'bumdes-sentosa-solo',
                'description' => 'Produsen batik tulis dan cap khas Solo. Menyediakan kain batik, kemeja batik, kebaya, dan berbagai produk fashion batik berkualitas tinggi.',
                'address' => 'Jl. Batik Heritage No. 99, Desa Laweyan',
                'province' => 'Jawa Tengah',
                'city' => 'Surakarta',
                'district' => 'Laweyan',
                'phone' => '0271730123',
                'email' => 'order@sentosa-solo.id',
                'whatsapp' => '6281234567899',
                'status' => 'active',
            ],
        ];

        foreach ($villages as $village) {
            Village::create($village);
        }
    }
}
