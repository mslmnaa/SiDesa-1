<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\LandingContent;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@bumdes.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1, Desa Maju'
        ]);

        User::create([
            'name' => 'Admin BUMDes',
            'email' => 'admin@bumdes.com', 
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '081234567891',
            'address' => 'Jl. BUMDes No. 2, Desa Sejahtera'
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '081234567892',
            'address' => 'Jl. Mawar No. 3, Desa Indah'
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Makanan & Minuman', 'description' => 'Produk makanan dan minuman lokal'],
            ['name' => 'Kerajinan Tangan', 'description' => 'Hasil kerajinan tangan masyarakat desa'],
            ['name' => 'Pertanian', 'description' => 'Produk hasil pertanian segar'],
            ['name' => 'Peternakan', 'description' => 'Produk hasil peternakan'],
            ['name' => 'Fashion', 'description' => 'Pakaian dan aksesoris buatan lokal'],
            ['name' => 'Oleh-oleh', 'description' => 'Souvenir dan oleh-oleh khas desa']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Products
        $products = [
            [
                'name' => 'Keripik Singkong Original',
                'description' => 'Keripik singkong renyah dengan rasa original yang gurih. Dibuat dari singkong pilihan langsung dari kebun petani.',
                'price' => 15000,
                'stock' => 50,
                'category_id' => 1,
                'whatsapp_number' => '081234567890'
            ],
            [
                'name' => 'Tas Anyaman Pandan',
                'description' => 'Tas cantik hasil anyaman pandan berkualitas tinggi. Ramah lingkungan dan tahan lama.',
                'price' => 75000,
                'stock' => 20,
                'category_id' => 2,
                'whatsapp_number' => '081234567891'
            ],
            [
                'name' => 'Beras Organik 5kg',
                'description' => 'Beras organik berkualitas premium tanpa pestisida. Langsung dari sawah petani lokal.',
                'price' => 85000,
                'stock' => 100,
                'category_id' => 3,
                'whatsapp_number' => '081234567892'
            ],
            [
                'name' => 'Telur Ayam Kampung',
                'description' => 'Telur ayam kampung segar, kaya nutrisi dan protein. Langsung dari peternakan lokal.',
                'price' => 25000,
                'stock' => 200,
                'category_id' => 4,
                'whatsapp_number' => '081234567893'
            ],
            [
                'name' => 'Kaos Batik Handmade',
                'description' => 'Kaos dengan motif batik khas daerah, dibuat dengan teknik handmade berkualitas tinggi.',
                'price' => 120000,
                'stock' => 30,
                'category_id' => 5,
                'whatsapp_number' => '081234567894'
            ],
            [
                'name' => 'Gula Aren Murni',
                'description' => 'Gula aren murni 100% tanpa campuran bahan kimia. Manis alami dari pohon aren.',
                'price' => 35000,
                'stock' => 80,
                'category_id' => 6,
                'whatsapp_number' => '081234567895'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create Landing Contents
        LandingContent::create([
            'key' => 'hero',
            'title' => 'Selamat Datang di BUMDes Marketplace',
            'content' => 'Platform jual beli produk lokal terpercaya yang menghubungkan konsumen dengan produk berkualitas dari desa-desa di Indonesia'
        ]);

        LandingContent::create([
            'key' => 'about-us',
            'title' => 'Tentang BUMDes Marketplace',
            'content' => 'Kami adalah platform digital yang berkomitmen untuk memajukan ekonomi desa melalui pemasaran produk lokal berkualitas. Bergabunglah dengan kami untuk mendukung UMKM dan produk desa Indonesia.'
        ]);
    }
}
