@extends('layouts.admin')

@section('title', 'Edit Konten: ' . $landingContent->title)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edit Konten: {{ $landingContent->title }}</h1>
        <p class="text-gray-600 mt-2">Edit konten landing page - Section: {{ ucfirst($landingContent->section) }}</p>
    </div>
    <div class="space-x-3">
        <a href="{{ route('admin.landing-contents.show', $landingContent) }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Lihat Detail
        </a>
        <a href="{{ route('admin.landing-contents.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
            Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.landing-contents.update', $landingContent) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Dasar</h2>
                
                <div class="space-y-4">
                    <!-- Section -->
                    <div>
                        <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                            Section *
                        </label>
                        <select id="section" name="section" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('section') border-red-500 @enderror">
                            <option value="">Pilih Section</option>
                            <option value="hero" {{ old('section', $landingContent->section) === 'hero' ? 'selected' : '' }}>Hero - Bagian Utama</option>
                            <option value="about" {{ old('section', $landingContent->section) === 'about' ? 'selected' : '' }}>About - Tentang BUMDes</option>
                            <option value="services" {{ old('section', $landingContent->section) === 'services' ? 'selected' : '' }}>Services - Layanan</option>
                            <option value="features" {{ old('section', $landingContent->section) === 'features' ? 'selected' : '' }}>Features - Keunggulan</option>
                            <option value="testimonial" {{ old('section', $landingContent->section) === 'testimonial' ? 'selected' : '' }}>Testimonial - Testimoni</option>
                            <option value="contact" {{ old('section', $landingContent->section) === 'contact' ? 'selected' : '' }}>Contact - Kontak</option>
                            <option value="custom" {{ old('section', $landingContent->section) === 'custom' ? 'selected' : '' }}>Custom - Section Khusus</option>
                        </select>
                        @error('section')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul *
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $landingContent->title) }}" required
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
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $landingContent->subtitle) }}"
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
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('content') border-red-500 @enderror">{{ old('content', $landingContent->content) }}</textarea>
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
                        <input type="text" id="button_text" name="button_text" value="{{ old('button_text', $landingContent->button_text) }}"
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
                        <input type="text" id="button_link" name="button_link" value="{{ old('button_link', $landingContent->button_link) }}"
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
            
            <!-- Current Image -->
            @if($landingContent->image)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Gambar Saat Ini</h2>
                    
                    <div class="relative group">
                        <img src="{{ Storage::url($landingContent->image) }}" alt="{{ $landingContent->title }}" 
                             class="w-full h-64 object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                            <div class="flex items-center justify-center h-full">
                                <label class="bg-red-600 text-white px-4 py-2 rounded cursor-pointer hover:bg-red-700">
                                    <input type="checkbox" name="remove_image" value="1" class="sr-only">
                                    Hapus Gambar
                                </label>
                            </div>
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Centang "Hapus Gambar" dan klik Simpan untuk menghapus gambar ini.
                    </p>
                </div>
            @endif
            
            <!-- Upload New Image -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">
                    {{ $landingContent->image ? 'Ganti Gambar' : 'Upload Gambar' }}
                </h2>
                
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $landingContent->image ? 'Upload Gambar Baru (Opsional)' : 'Upload Gambar (Opsional)' }}
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. 
                        {{ $landingContent->image ? 'Gambar baru akan menggantikan gambar lama.' : '' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Saat Ini</h3>
                
                <div class="text-center mb-4">
                    <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full 
                        {{ $landingContent->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $landingContent->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                
                <div class="text-sm text-gray-600 text-center space-y-1">
                    <p>Section: <span class="font-medium">{{ ucfirst($landingContent->section) }}</span></p>
                    <p>Order: <span class="font-medium">{{ $landingContent->order }}</span></p>
                    <p>Dibuat: {{ $landingContent->created_at->format('d M Y') }}</p>
                    @if($landingContent->updated_at != $landingContent->created_at)
                        <p>Diupdate: {{ $landingContent->updated_at->format('d M Y, H:i') }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Display Settings -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Pengaturan Tampilan</h2>
                
                <div class="space-y-4">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Urutan Tampil
                        </label>
                        <input type="number" id="order" name="order" value="{{ old('order', $landingContent->order) }}" min="0"
                               placeholder="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('order') border-red-500 @enderror">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Angka lebih kecil akan tampil lebih dahulu. Saat ini: {{ $landingContent->order }}
                        </p>
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status *
                        </label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status', $landingContent->status) === 'active' ? 'selected' : '' }}>Aktif - Tampil di website</option>
                            <option value="inactive" {{ old('status', $landingContent->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif - Disembunyikan</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Additional Data (JSON) -->
            @if($landingContent->data)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Data Tambahan</h2>
                    
                    <div>
                        <label for="data" class="block text-sm font-medium text-gray-700 mb-2">
                            JSON Data (Advanced)
                        </label>
                        <textarea id="data" name="data[custom_field]" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 text-sm font-mono">{{ old('data.custom_field', json_encode($landingContent->data, JSON_PRETTY_PRINT)) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">
                            Data tambahan dalam format JSON untuk customisasi lanjutan
                        </p>
                    </div>
                </div>
            @endif
            
            <!-- Submit Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="space-y-3">
                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Simpan Perubahan
                    </button>
                    
                    <a href="{{ route('admin.landing-contents.show', $landingContent) }}" 
                       class="w-full bg-gray-500 text-white py-3 px-4 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center block">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Danger Zone -->
<div class="mt-8 bg-red-50 rounded-lg p-6">
    <h3 class="text-lg font-semibold text-red-900 mb-2">Zona Bahaya</h3>
    <p class="text-red-700 mb-4">
        Menghapus konten akan menghapus semua data terkait termasuk gambar. Aksi ini tidak dapat dibatalkan.
    </p>
    <form method="POST" action="{{ route('admin.landing-contents.destroy', $landingContent) }}" 
          onsubmit="return confirm('Yakin ingin menghapus konten {{ $landingContent->title }}? Aksi ini tidak dapat dibatalkan!')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
            Hapus Konten
        </button>
    </form>
</div>
@endsection