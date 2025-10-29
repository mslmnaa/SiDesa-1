<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product\Category;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call Village seeder first (must be before users)
        $this->call([
            \Database\Seeders\System\SettingSeeder::class,
            \Database\Seeders\Product\CategoryTypeSeeder::class,
            VillageSeeder::class,
        ]);

        // Create SuperAdmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bumdes.com',
            'password' => Hash::make('123'),
            'role' => 'superadmin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin Pusat No. 1',
            'village_id' => null // SuperAdmin tidak terikat desa
        ]);

        // Create Admin for each village (first 5 villages)
        $villages = \App\Models\Village::take(5)->get();

        foreach ($villages as $index => $village) {
            User::create([
                'name' => 'Admin ' . $village->name,
                'email' => 'admin' . ($index + 1) . '@bumdes.com',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'phone' => '0812345678' . (91 + $index),
                'address' => $village->address,
                'village_id' => $village->id // Admin terikat ke desa tertentu
            ]);
        }

        // Create regular users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('123'),
            'role' => 'user',
            'phone' => '081234567899',
            'address' => 'Jl. Mawar No. 3, Jakarta',
            'village_id' => null
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('123'),
            'role' => 'user',
            'phone' => '081234567898',
            'address' => 'Jl. Melati No. 5, Bandung',
            'village_id' => null
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Makanan & Minuman', 'type' => 'barang', 'description' => 'Produk makanan dan minuman lokal', 'image' => 'images/categories/makanan-minuman.png'],
            ['name' => 'Kerajinan Tangan', 'type' => 'barang', 'description' => 'Hasil kerajinan tangan masyarakat desa', 'image' => 'images/categories/kerajinan-tangan.png'],
            ['name' => 'Pertanian', 'type' => 'barang', 'description' => 'Produk hasil pertanian segar', 'image' => 'images/categories/pertanian.png'],
            ['name' => 'Peternakan', 'type' => 'barang', 'description' => 'Produk hasil peternakan', 'image' => 'images/categories/peternakan.png'],
            ['name' => 'Fashion', 'type' => 'barang', 'description' => 'Pakaian dan aksesoris buatan lokal', 'image' => 'images/categories/fashion.png'],
            ['name' => 'Oleh-oleh', 'type' => 'barang', 'description' => 'Souvenir dan oleh-oleh khas desa', 'image' => 'images/categories/oleh-oleh.png'],
            ['name' => 'Konsultasi', 'type' => 'jasa', 'description' => 'Layanan konsultasi dan bimbingan', 'image' => 'images/categories/konsultasi.png'],
            ['name' => 'Perawatan', 'type' => 'jasa', 'description' => 'Layanan perawatan dan maintenance', 'image' => 'images/categories/perawatan.png']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Products
        $products = [
            [
                'name' => 'Keripik Singkong Original',
                'slug' => 'keripik-singkong-original',
                'description' => 'Keripik singkong renyah dengan rasa original yang gurih. Dibuat dari singkong pilihan langsung dari kebun petani.',
                'price' => 15000,
                'stock' => 50,
                'category_id' => 1,
                'type' => 'barang',
                'whatsapp_number' => '081234567890',
                'images' => [
                    'images/products/keripik-singkong-1.jpg',
                    'images/products/keripik-singkong-2.jpg'
                ]
            ],
            [
                'name' => 'Tas Anyaman Pandan',
                'slug' => 'tas-anyaman-pandan',
                'description' => 'Tas cantik hasil anyaman pandan berkualitas tinggi. Ramah lingkungan dan tahan lama.',
                'price' => 75000,
                'stock' => 20,
                'category_id' => 2,
                'type' => 'barang',
                'whatsapp_number' => '081234567891',
                'images' => [
                    'images/products/tas-anyaman-pandan-1.jpg',
                    'images/products/tas-anyaman-pandan-2.jpg'
                ]
            ],
            [
                'name' => 'Beras Organik 5kg',
                'slug' => 'beras-organik-5kg',
                'description' => 'Beras organik berkualitas premium tanpa pestisida. Langsung dari sawah petani lokal.',
                'price' => 85000,
                'stock' => 100,
                'category_id' => 3,
                'type' => 'barang',
                'whatsapp_number' => '081234567892',
                'images' => [
                    'images/products/beras-organik-1.jpg'
                ]
            ],
            [
                'name' => 'Telur Ayam Kampung',
                'slug' => 'telur-ayam-kampung',
                'description' => 'Telur ayam kampung segar, kaya nutrisi dan protein. Langsung dari peternakan lokal.',
                'price' => 25000,
                'stock' => 200,
                'category_id' => 4,
                'type' => 'barang',
                'whatsapp_number' => '081234567893',
                'images' => [
                    'images/products/telur-ayam-kampung-1.jpg'
                ]
            ],
            [
                'name' => 'Kaos Batik Handmade',
                'slug' => 'kaos-batik-handmade',
                'description' => 'Kaos dengan motif batik khas daerah, dibuat dengan teknik handmade berkualitas tinggi.',
                'price' => 120000,
                'stock' => 30,
                'category_id' => 5,
                'type' => 'barang',
                'whatsapp_number' => '081234567894',
                'images' => [
                    'images/products/kaos-batik-1.jpg',
                    'images/products/kaos-batik-2.jpg'
                ]
            ],
            [
                'name' => 'Gula Aren Murni',
                'slug' => 'gula-aren-murni',
                'description' => 'Gula aren murni 100% tanpa campuran bahan kimia. Manis alami dari pohon aren.',
                'price' => 35000,
                'stock' => 80,
                'category_id' => 6,
                'type' => 'barang',
                'whatsapp_number' => '081234567895',
                'images' => [
                    'images/products/gula-aren-1.jpg',
                    'images/products/gula-aren-2.jpg'
                ]
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Call Product seeder last
        $this->call([
            ProductSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Database seeding completed!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Villages: ' . \App\Models\Village::count());
        $this->command->info('   - Categories: ' . Category::count());
        $this->command->info('   - Products: ' . Product::count());
        $this->command->info('');
        $this->command->info('🔐 Login credentials:');
        $this->command->info('   SuperAdmin: superadmin@bumdes.com / 123');
        $this->command->info('   Admin Desa 1: admin1@bumdes.com / 123 (BUMDes Maju Jaya)');
        $this->command->info('   Admin Desa 2: admin2@bumdes.com / 123 (BUMDes Sejahtera Ungaran)');
        $this->command->info('   Admin Desa 3: admin3@bumdes.com / 123 (Desa Kreatif Sidoarjo)');
        $this->command->info('   Admin Desa 4: admin4@bumdes.com / 123 (BUMDes Mandiri Ubud)');
        $this->command->info('   Admin Desa 5: admin5@bumdes.com / 123 (Desa Berkah Bantul)');
        $this->command->info('   User: budi@example.com / 123');
        $this->command->info('   User: siti@example.com / 123');
    }
}
