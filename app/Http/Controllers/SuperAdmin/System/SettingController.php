<?php

namespace App\Http\Controllers\SuperAdmin\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'village_head_email' => Setting::get('village_head_email', ''),
            'village_name' => Setting::get('village_name', ''),
            'village_head_name' => Setting::get('village_head_name', ''),
            'village_phone' => Setting::get('village_phone', ''),
            'village_address' => Setting::get('village_address', ''),
            // SMTP Settings
            'smtp_host' => Setting::get('smtp_host', ''),
            'smtp_port' => Setting::get('smtp_port', ''),
            'smtp_username' => Setting::get('smtp_username', ''),
            'smtp_password' => Setting::get('smtp_password', ''),
            'smtp_encryption' => Setting::get('smtp_encryption', ''),
            'mail_from_name' => Setting::get('mail_from_name', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'village_head_email' => 'required|email',
            'village_name' => 'required|string|max:255',
            'village_head_name' => 'required|string|max:255',
            'village_phone' => 'nullable|string|max:20',
            'village_address' => 'nullable|string',
            // SMTP validation
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|email|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:tls,ssl',
            'mail_from_name' => 'nullable|string|max:255',
        ]);

        // Update village settings
        Setting::set('village_head_email', $request->village_head_email, 'Email Kepala Desa');
        Setting::set('village_name', $request->village_name, 'Nama Desa');
        Setting::set('village_head_name', $request->village_head_name, 'Nama Kepala Desa');
        Setting::set('village_phone', $request->village_phone, 'Telepon Desa');
        Setting::set('village_address', $request->village_address, 'Alamat Desa');

        // Update SMTP settings
        Setting::set('smtp_host', $request->smtp_host, 'SMTP Host');
        Setting::set('smtp_port', $request->smtp_port, 'SMTP Port');
        Setting::set('smtp_username', $request->smtp_username, 'SMTP Username');
        Setting::set('smtp_password', $request->smtp_password, 'SMTP Password');
        Setting::set('smtp_encryption', $request->smtp_encryption, 'SMTP Encryption');
        Setting::set('mail_from_name', $request->mail_from_name, 'Mail From Name');

        // Clear configuration cache to reload mail settings
        \Artisan::call('config:clear');

        return redirect()->route('admin.settings.index')
                        ->with('success', 'Pengaturan berhasil diperbarui. Konfigurasi email telah diperbarui.');
    }

    public function testEmail()
    {
        try {
            // Run the test email command
            \Artisan::call('test:smtp');
            $output = \Artisan::output();
            
            // Check if SMTP was successful or using log
            if (str_contains($output, 'Email sent successfully')) {
                if (str_contains($output, 'log driver')) {
                    return redirect()->route('admin.settings.index')
                                   ->with('success', 'Email test berhasil! Email disimpan di log (SMTP belum dikonfigurasi). Periksa storage/logs/laravel.log untuk melihat email.');
                } else {
                    return redirect()->route('admin.settings.index')
                                   ->with('success', 'Email test berhasil dikirim ke email kepala desa! Periksa inbox untuk konfirmasi.');
                }
            } else {
                // Parse specific error messages
                if (str_contains($output, 'Username and Password not accepted')) {
                    return redirect()->route('admin.settings.index')
                                   ->with('error', 'SMTP Authentication gagal. Pastikan email dan App Password Gmail benar. Periksa apakah 2FA sudah aktif dan App Password sudah di-generate.');
                } elseif (str_contains($output, 'Village head email not set')) {
                    return redirect()->route('admin.settings.index')
                                   ->with('error', 'Email kepala desa belum diatur. Silakan isi email kepala desa terlebih dahulu.');
                } elseif (str_contains($output, 'SMTP settings incomplete')) {
                    return redirect()->route('admin.settings.index')
                                   ->with('error', 'Konfigurasi SMTP tidak lengkap. Pastikan semua field SMTP terisi atau kosongkan untuk menggunakan log driver.');
                } else {
                    return redirect()->route('admin.settings.index')
                                   ->with('error', 'Test email gagal. Periksa konfigurasi SMTP Anda atau hubungi administrator.');
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                           ->with('error', 'Error saat test email: ' . $e->getMessage());
        }
    }
}
