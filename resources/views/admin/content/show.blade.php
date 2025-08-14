@extends('layouts.admin')

@section('title', 'Konten: ' . $landingContent->title)

@section('content')
<!-- Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">{{ $landingContent->title }}</h1>
        <p class="text-gray-600 mt-2">Detail konten landing page - Section: {{ ucfirst($landingContent->section) }}</p>
    </div>
    <div class="space-x-3">
        <a href="{{ route('home') }}" target="_blank"
           class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
            Lihat di Website
        </a>
        <a href="{{ route('admin.landing-contents.edit', $landingContent) }}" 
           class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
            Edit Konten
        </a>
        <a href="{{ route('admin.landing-contents.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Content Image -->
        @if($landingContent->image)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ Storage::url($landingContent->image) }}" 
                     alt="{{ $landingContent->title }}" 
                     class="w-full h-96 object-cover">
            </div>
        @endif
        
        <!-- Content Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($landingContent->section) }}
                    </span>
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $landingContent->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $landingContent->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $landingContent->title }}</h2>
                
                @if($landingContent->subtitle)
                    <p class="text-xl text-gray-600 mb-4">{{ $landingContent->subtitle }}</p>
                @endif
            </div>
            
            @if($landingContent->content)
                <div class="prose prose-green max-w-none mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Konten/Deskripsi</h3>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $landingContent->content }}
                    </div>
                </div>
            @endif
            
            @if($landingContent->button_text || $landingContent->button_link)
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Button & Link</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($landingContent->button_text)
                            <div class="mb-2">
                                <span class="text-sm font-medium text-gray-700">Teks Button:</span>
                                <span class="ml-2 inline-flex px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded">
                                    {{ $landingContent->button_text }}
                                </span>
                            </div>
                        @endif
                        
                        @if($landingContent->button_link)
                            <div>
                                <span class="text-sm font-medium text-gray-700">Link:</span>
                                <a href="{{ $landingContent->button_link }}" target="_blank" 
                                   class="ml-2 text-blue-600 hover:text-blue-800 text-sm underline">
                                    {{ $landingContent->button_link }}
                                </a>
                            </div>
                        @endif
                        
                        @if($landingContent->button_text && $landingContent->button_link)
                            <div class="mt-3 pt-3 border-t">
                                <span class="text-sm font-medium text-gray-700">Preview:</span>
                                <a href="{{ $landingContent->button_link }}" target="_blank"
                                   class="ml-2 inline-flex px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                                    {{ $landingContent->button_text }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Additional Data -->
        @if($landingContent->data && count($landingContent->data) > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Tambahan</h3>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <pre class="text-sm text-gray-700 overflow-x-auto">{{ json_encode($landingContent->data, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Content Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Konten</h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">ID:</span>
                    <span class="font-medium">#{{ $landingContent->id }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Section:</span>
                    <span class="font-medium">{{ ucfirst($landingContent->section) }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-medium {{ $landingContent->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $landingContent->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Urutan:</span>
                    <span class="font-medium">{{ $landingContent->order }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Dibuat:</span>
                    <span class="font-medium">{{ $landingContent->created_at->format('d M Y, H:i') }}</span>
                </div>
                
                @if($landingContent->updated_at != $landingContent->created_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diupdate:</span>
                        <span class="font-medium">{{ $landingContent->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Content Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Konten</h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Panjang Judul:</span>
                    <span class="font-medium">{{ strlen($landingContent->title) }} karakter</span>
                </div>
                
                @if($landingContent->subtitle)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Panjang Subtitle:</span>
                        <span class="font-medium">{{ strlen($landingContent->subtitle) }} karakter</span>
                    </div>
                @endif
                
                @if($landingContent->content)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Panjang Konten:</span>
                        <span class="font-medium">{{ strlen($landingContent->content) }} karakter</span>
                    </div>
                @endif
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Memiliki Gambar:</span>
                    <span class="font-medium {{ $landingContent->image ? 'text-green-600' : 'text-red-600' }}">
                        {{ $landingContent->image ? 'Ya' : 'Tidak' }}
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Memiliki Button:</span>
                    <span class="font-medium {{ $landingContent->button_text ? 'text-green-600' : 'text-red-600' }}">
                        {{ $landingContent->button_text ? 'Ya' : 'Tidak' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.landing-contents.edit', $landingContent) }}" 
                   class="w-full bg-green-600 text-white py-2 px-4 rounded-lg text-center font-medium hover:bg-green-700 transition-colors block">
                    Edit Konten
                </a>
                
                <form method="POST" action="{{ route('admin.landing-contents.toggle-status', $landingContent) }}" class="w-full">
                    @csrf
                    <input type="hidden" name="status" value="{{ $landingContent->status === 'active' ? 'inactive' : 'active' }}">
                    <button type="submit" 
                            class="w-full {{ $landingContent->status === 'active' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        {{ $landingContent->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                
                <a href="{{ route('home') }}" target="_blank"
                   class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg text-center font-medium hover:bg-purple-700 transition-colors block">
                    Lihat di Website
                </a>
            </div>
        </div>
        
        <!-- Section Guide -->
        <div class="bg-blue-50 rounded-lg p-6">
            <h3 class="font-semibold text-blue-900 mb-3">Section: {{ ucfirst($landingContent->section) }}</h3>
            <div class="text-sm text-blue-800">
                @switch($landingContent->section)
                    @case('hero')
                        <p>Bagian paling atas website dengan headline utama dan call-to-action. Biasanya memiliki gambar background yang menarik.</p>
                        @break
                    @case('about')
                        <p>Bagian yang menjelaskan tentang BUMDes, sejarah, visi, misi, dan tujuan organisasi.</p>
                        @break
                    @case('services')
                        <p>Menampilkan layanan dan produk yang ditawarkan oleh BUMDes kepada masyarakat.</p>
                        @break
                    @case('features')
                        <p>Menampilkan keunggulan, fasilitas, atau nilai tambah yang dimiliki BUMDes.</p>
                        @break
                    @case('testimonial')
                        <p>Berisi testimoni atau ulasan dari pelanggan yang puas dengan layanan BUMDes.</p>
                        @break
                    @case('contact')
                        <p>Informasi kontak, alamat, dan cara menghubungi BUMDes.</p>
                        @break
                    @default
                        <p>Section khusus yang dapat disesuaikan dengan kebutuhan konten landing page.</p>
                @endswitch
            </div>
        </div>
        
        <!-- Danger Zone -->
        <div class="bg-red-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-2">Zona Bahaya</h3>
            <p class="text-red-700 text-sm mb-4">
                Menghapus konten akan menghapus semua data terkait. Aksi ini tidak dapat dibatalkan.
            </p>
            <form method="POST" action="{{ route('admin.landing-contents.destroy', $landingContent) }}" 
                  onsubmit="return confirm('Yakin ingin menghapus konten {{ $landingContent->title }}? Aksi ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                    Hapus Konten
                </button>
            </form>
        </div>
    </div>
</div>
@endsection