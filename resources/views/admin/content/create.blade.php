@extends('layouts.admin')

@section('title', 'Tambah Konten Landing Page')

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Tambah Konten Landing Page</h1>
        <p class="text-gray-600 mt-2">Tambahkan konten baru untuk halaman utama website</p>
    </div>
    <div class="space-x-3">
        <a href="{{ route('home') }}" target="_blank"
           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Preview Website
        </a>
        <a href="{{ route('admin.content.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
            Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <!-- Key -->
                    <div>
                        <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                            Key/Section *
                        </label>
                        <select id="key" name="key" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('key') border-red-500 @enderror">
                            <option value="">Pilih Section</option>
                            <option value="hero" {{ old('key') === 'hero' ? 'selected' : '' }}>Hero - Bagian Utama</option>
                            <option value="about-us" {{ old('key') === 'about-us' ? 'selected' : '' }}>About Us - Tentang BUMDes</option>
                            <option value="services" {{ old('key') === 'services' ? 'selected' : '' }}>Services - Layanan</option>
                            <option value="features" {{ old('key') === 'features' ? 'selected' : '' }}>Features - Keunggulan</option>
                            <option value="testimonial" {{ old('key') === 'testimonial' ? 'selected' : '' }}>Testimonial - Testimoni</option>
                            <option value="contact" {{ old('key') === 'contact' ? 'selected' : '' }}>Contact - Kontak</option>
                            <option value="gallery" {{ old('key') === 'gallery' ? 'selected' : '' }}>Gallery - Galeri</option>
                        </select>
                        @error('key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul *
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                               placeholder="Contoh: Selamat Datang di BUMDes Maju Bersama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('title') border-red-500 @enderror">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Subtitle -->
                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Sub Judul
                        </label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}"
                               placeholder="Contoh: Membangun Ekonomi Desa Bersama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('subtitle') border-red-500 @enderror">
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Konten/Deskripsi
                        </label>
                        <textarea id="content" name="content" rows="5"
                                  placeholder="Tulis konten atau deskripsi detail di sini..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Button & Link -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Button & Link (Opsional)</h2>
                
                <div class="space-y-4">
                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Teks Button
                        </label>
                        <input type="text" id="button_text" name="button_text" value="{{ old('button_text') }}"
                               placeholder="Contoh: Mulai Belanja, Pelajari Lebih Lanjut"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('button_text') border-red-500 @enderror">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Button Link -->
                    <div>
                        <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">
                            Link Button
                        </label>
                        <input type="text" id="button_link" name="button_link" value="{{ old('button_link') }}"
                               placeholder="Contoh: /products, https://example.com, #about"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('button_link') border-red-500 @enderror">
                        @error('button_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Bisa berupa URL lengkap, path internal (/products), atau anchor (#section)
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Image -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Gambar</h2>
                
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Gambar (Opsional)
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Gambar akan digunakan sesuai dengan layout section.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Display Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Pengaturan Tampilan</h2>
                
                <div class="space-y-4">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Tampil
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                               placeholder="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('order') border-red-500 @enderror">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Angka lebih kecil akan tampil lebih dahulu. Default: 0
                        </p>
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                            Status *
                        </label>
                        <select id="is_active" name="is_active" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('is_active') border-red-500 @enderror">
                            <option value="1" {{ old('is_active', '1') === '1' ? 'selected' : '' }}>Aktif - Tampil di website</option>
                            <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif - Disembunyikan</option>
                        </select>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Section Guide -->
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="font-semibold text-blue-900 mb-3">Panduan Section</h3>
                <div class="text-sm text-blue-800 space-y-2">
                    <div>
                        <strong>Hero:</strong> Bagian paling atas dengan headline utama
                    </div>
                    <div>
                        <strong>About:</strong> Penjelasan tentang BUMDes
                    </div>
                    <div>
                        <strong>Services:</strong> Layanan dan produk yang ditawarkan
                    </div>
                    <div>
                        <strong>Features:</strong> Keunggulan dan fasilitas
                    </div>
                    <div>
                        <strong>Testimonial:</strong> Testimoni dari pelanggan
                    </div>
                    <div>
                        <strong>Contact:</strong> Informasi kontak dan alamat
                    </div>
                </div>
            </div>
            
            <!-- Additional Data (JSON) -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Data Tambahan (Advanced)</h2>
                
                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700 mb-2">
                        JSON Data (Opsional)
                    </label>
                    <textarea id="data" name="data[custom_field]" rows="3"
                              placeholder='{"icon": "fa-home", "color": "#green"}'
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-sm font-mono">{{ old('data.custom_field') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        Data tambahan dalam format key-value untuk customisasi lanjutan
                    </p>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow p-6">
                <button type="submit" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Simpan Konten
                </button>
            </div>
        </div>
    </div>
</form>
@endsection