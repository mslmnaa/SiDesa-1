<?php

namespace Database\Seeders\System;

use App\Models\System\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'village_head_email',
                'value' => 'kepala.desa@example.com',
                'description' => 'Email Kepala Desa untuk menerima pesan kontak'
            ],
            [
                'key' => 'village_name',
                'value' => 'Desa Maju Makmur',
                'description' => 'Nama Desa'
            ],
            [
                'key' => 'village_head_name',
                'value' => 'Bapak Kepala Desa',
                'description' => 'Nama Kepala Desa'
            ],
            [
                'key' => 'village_phone',
                'value' => '(021) 1234567',
                'description' => 'Telepon Kantor Desa'
            ],
            [
                'key' => 'village_address',
                'value' => 'Jl. Raya Desa No. 1, Kecamatan, Kabupaten, Provinsi',
                'description' => 'Alamat Kantor Desa'
            ],
            // SMTP Email Configuration
            [
                'key' => 'smtp_host',
                'value' => 'smtp.gmail.com',
                'description' => 'SMTP Host (contoh: smtp.gmail.com)'
            ],
            [
                'key' => 'smtp_port',
                'value' => '587',
                'description' => 'SMTP Port (587 untuk TLS, 465 untuk SSL)'
            ],
            [
                'key' => 'smtp_username',
                'value' => '',
                'description' => 'Email username untuk SMTP'
            ],
            [
                'key' => 'smtp_password',
                'value' => '',
                'description' => 'Password email atau App Password'
            ],
            [
                'key' => 'smtp_encryption',
                'value' => 'tls',
                'description' => 'Enkripsi SMTP (tls atau ssl)'
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'Website Desa',
                'description' => 'Nama pengirim email'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'description' => $setting['description']]
            );
        }

        $this->command->info('Default settings have been created successfully!');
    }
}
