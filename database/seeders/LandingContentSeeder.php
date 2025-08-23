<?php

namespace Database\Seeders;

use App\Models\Content\LandingContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LandingContentSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        LandingContent::truncate();
        
        // Create storage directory if not exists
        if (!Storage::disk('public')->exists('landing-content')) {
            Storage::disk('public')->makeDirectory('landing-content');
        }

        // Download and store images from unsplash
        $this->downloadImage('https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1200&h=800&fit=crop&q=80', 'hero-bg.jpg');
        $this->downloadImage('https://images.unsplash.com/photo-1556740758-90de374c12ad?w=800&h=600&fit=crop&q=80', 'about-us.jpg');
        $this->downloadImage('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop&q=80', 'services.jpg');
        $this->downloadImage('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&h=600&fit=crop&q=80', 'features.jpg');
        $this->downloadImage('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop&q=80', 'contact.jpg');

        $contents = [
            [
                'key' => 'hero',
                'title' => 'Selamat Datang di BUMDes Marketplace',
                'content' => 'Temukan dan beli produk lokal berkualitas langsung dari desa. Dukung ekonomi desa dan nikmati produk segar dari petani dan pengrajin lokal.',
                'image' => 'landing-content/hero-bg.jpg',
                'data' => json_encode([
                    'button_text' => 'Mulai Berbelanja',
                    'button_link' => '/products',
                    'subtitle' => 'Produk Lokal Berkualitas dari Desa untuk Anda'
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'about-us',
                'title' => 'Tentang BUMDes Kami',
                'content' => 'BUMDes (Badan Usaha Milik Desa) adalah lembaga ekonomi desa yang dikelola oleh masyarakat dan pemerintahan desa. Kami berkomitmen untuk membangun ekonomi desa yang mandiri dan berkelanjutan melalui produk-produk unggulan lokal.',
                'image' => 'landing-content/about-us.jpg',
                'data' => json_encode([
                    'vision' => 'Menjadi pusat ekonomi desa yang mandiri dan berkelanjutan',
                    'mission' => 'Memberdayakan masyarakat desa melalui usaha produktif dan inovatif',
                    'established' => '2020'
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'services',
                'title' => 'Layanan Unggulan Kami',
                'content' => 'Kami menyediakan berbagai layanan untuk mendukung ekonomi desa, mulai dari produk pertanian, kerajinan tangan, hingga produk olahan makanan khas daerah.',
                'image' => 'landing-content/services.jpg',
                'data' => json_encode([
                    'services' => [
                        'Produk Pertanian Organik',
                        'Kerajinan Tangan Tradisional',
                        'Makanan Olahan Khas',
                        'Produk UMKM Lokal'
                    ]
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'features',
                'title' => 'Keunggulan Berbelanja di BUMDes',
                'content' => 'Nikmati berbagai keunggulan berbelanja produk lokal dengan kualitas terjamin, harga terjangkau, dan dukungan langsung kepada ekonomi desa.',
                'image' => 'landing-content/features.jpg',
                'data' => json_encode([
                    'features' => [
                        [
                            'icon' => 'shield-check',
                            'title' => 'Kualitas Terjamin',
                            'description' => 'Produk berkualitas langsung dari produsen'
                        ],
                        [
                            'icon' => 'truck',
                            'title' => 'Pengiriman Cepat',
                            'description' => 'Pengiriman ke seluruh Indonesia'
                        ],
                        [
                            'icon' => 'heart',
                            'title' => 'Dukung Ekonomi Desa',
                            'description' => 'Setiap pembelian mendukung ekonomi lokal'
                        ],
                        [
                            'icon' => 'leaf',
                            'title' => 'Ramah Lingkungan',
                            'description' => 'Produk alami dan ramah lingkungan'
                        ]
                    ]
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'contact',
                'title' => 'Hubungi Kami',
                'content' => 'Punya pertanyaan atau butuh bantuan? Tim customer service kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami.',
                'image' => 'landing-content/contact.jpg',
                'data' => json_encode([
                    'phone' => '+62 812-3456-7890',
                    'email' => 'info@bumdesmarketplace.com',
                    'whatsapp' => '+62 812-3456-7890',
                    'address' => 'Desa Maju Bersama, Kecamatan Sejahtera, Kabupaten Berkembang',
                    'office_hours' => 'Senin - Jumat: 08:00 - 17:00 WIB'
                ]),
                'is_active' => true,
            ],
            [
                'key' => 'testimonial',
                'title' => 'Apa Kata Pelanggan Kami',
                'content' => 'Kepuasan pelanggan adalah prioritas utama kami. Berikut testimoni dari pelanggan yang telah merasakan kualitas produk dan layanan kami.',
                'image' => null,
                'data' => json_encode([
                    'testimonials' => [
                        [
                            'name' => 'Ibu Sari',
                            'location' => 'Jakarta',
                            'rating' => 5,
                            'comment' => 'Produk organik yang sangat segar! Kualitasnya benar-benar terjaga dari petani langsung.',
                            'avatar' => 'https://images.unsplash.com/photo-1494790108755-2616b612b608?w=150&h=150&fit=crop&q=80'
                        ],
                        [
                            'name' => 'Bapak Ahmad',
                            'location' => 'Bandung',
                            'rating' => 5,
                            'comment' => 'Kerajinan tangannya bagus sekali! Kualitas premium dengan harga yang sangat terjangkau.',
                            'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&q=80'
                        ],
                        [
                            'name' => 'Ibu Rina',
                            'location' => 'Surabaya',
                            'rating' => 5,
                            'comment' => 'Makanan olahannya enak banget! Rasanya otentik dan packaging-nya juga rapi.',
                            'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&q=80'
                        ]
                    ]
                ]),
                'is_active' => true,
            ],
        ];

        foreach ($contents as $content) {
            LandingContent::create($content);
        }
    }

    private function downloadImage($url, $filename)
    {
        try {
            $imageContent = file_get_contents($url);
            if ($imageContent !== false) {
                Storage::disk('public')->put('landing-content/' . $filename, $imageContent);
                echo "Downloaded: $filename\n";
            }
        } catch (Exception $e) {
            echo "Failed to download $filename: " . $e->getMessage() . "\n";
        }
    }
}