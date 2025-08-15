@extends('layouts.admin')

@section('title', 'Kelola Konten Landing Page')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 sm:mb-8 gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Konten Landing Page</h1>
        <p class="text-gray-600 mt-2 text-sm sm:text-base">Kelola semua konten yang tampil di halaman utama website</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
        <a href="{{ route('home') }}" target="_blank"
           class="bg-blue-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors text-center text-sm sm:text-base">
            Preview Website
        </a>
        <a href="{{ route('admin.landing-contents.create') }}" 
           class="bg-green-600 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors text-center text-sm sm:text-base">
            Tambah Konten
        </a>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-lg shadow p-4 sm:p-6 mb-6">
    <form method="GET" action="{{ route('admin.landing-contents.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Search -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari Konten</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Judul atau section..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
        </div>
        
        <!-- Section Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
            <select name="section" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                <option value="">Semua Section</option>
                @foreach($sections as $section)
                    <option value="{{ $section }}" {{ request('section') == $section ? 'selected' : '' }}>
                        {{ ucfirst($section) }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Status Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        
        <!-- Actions -->
        <div class="sm:col-span-2 lg:col-span-1 flex flex-col sm:flex-row items-stretch sm:items-end gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm font-medium">
                Filter
            </button>
            <a href="{{ route('admin.landing-contents.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors text-center text-sm font-medium">
                Reset
            </a>
        </div>
    </form>
</div>

@if($contents->count() > 0)
    <!-- Contents Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
        @foreach($contents as $content)
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                <!-- Content Image -->
                <div class="h-32 sm:h-48 bg-gray-200">
                    @if($content->image)
                        <img src="{{ Storage::url($content->image) }}" 
                             alt="{{ $content->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="h-full flex items-center justify-center">
                            <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Content Info -->
                <div class="p-4 sm:p-6">
                    <!-- Section & Status -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($content->section) }}
                        </span>
                        <form method="POST" action="{{ route('admin.landing-contents.toggle-status', $content) }}" class="inline-block">
                            @csrf
                            <select name="status" onchange="this.form.submit()" 
                                    class="text-xs rounded-full px-2 py-1 font-semibold border-0 focus:ring-2 focus:ring-green-500
                                        {{ $content->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <option value="active" {{ $content->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $content->status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </form>
                    </div>
                    
                    <!-- Title & Subtitle -->
                    <div class="mb-3 sm:mb-4">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 line-clamp-2">{{ $content->title }}</h3>
                        @if($content->subtitle)
                            <p class="text-xs sm:text-sm text-gray-600 line-clamp-2">{{ Str::limit($content->subtitle, 60) }}</p>
                        @endif
                    </div>
                    
                    <!-- Content Preview -->
                    @if($content->content)
                        <div class="mb-3 sm:mb-4">
                            <p class="text-xs sm:text-sm text-gray-700 line-clamp-2">{{ Str::limit(strip_tags($content->content), 80) }}</p>
                        </div>
                    @endif
                    
                    <!-- Button Info -->
                    @if($content->button_text)
                        <div class="mb-3 sm:mb-4 p-2 sm:p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-1">Button:</p>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                <span class="text-xs sm:text-sm font-medium text-blue-600 truncate">{{ $content->button_text }}</span>
                                @if($content->button_link)
                                    <span class="text-xs text-gray-500">→ {{ Str::limit($content->button_link, 15) }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Meta Info -->
                    <div class="flex items-center justify-between text-xs text-gray-500 mb-3 sm:mb-4">
                        <span>Order: {{ $content->order }}</span>
                        <span>{{ $content->updated_at->format('d M Y') }}</span>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                        <a href="{{ route('admin.landing-contents.show', $content) }}" 
                           class="flex-1 bg-blue-600 text-white py-1.5 sm:py-2 px-2 sm:px-3 rounded text-center text-xs sm:text-sm font-medium hover:bg-blue-700 transition-colors">
                            Lihat
                        </a>
                        <a href="{{ route('admin.landing-contents.edit', $content) }}" 
                           class="flex-1 bg-green-600 text-white py-1.5 sm:py-2 px-2 sm:px-3 rounded text-center text-xs sm:text-sm font-medium hover:bg-green-700 transition-colors">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.landing-contents.destroy', $content) }}" 
                              class="flex-1" 
                              onsubmit="return confirm('Yakin ingin menghapus konten {{ $content->title }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 text-white py-1.5 sm:py-2 px-2 sm:px-3 rounded text-xs sm:text-sm font-medium hover:bg-red-700 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $contents->appends(request()->query())->links() }}
    </div>
@else
    <!-- Empty State -->
    <div class="bg-white rounded-lg shadow p-12 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">
            {{ request()->hasAny(['search', 'section', 'status']) ? 'Konten Tidak Ditemukan' : 'Belum Ada Konten Landing Page' }}
        </h3>
        <p class="text-gray-600 mb-6">
            {{ request()->hasAny(['search', 'section', 'status']) ? 'Tidak ada konten yang cocok dengan filter yang dipilih.' : 'Belum ada konten untuk landing page. Mulai tambahkan konten untuk mempercantik halaman utama website.' }}
        </p>
        @if(!request()->hasAny(['search', 'section', 'status']))
            <div class="space-x-4">
                <a href="{{ route('admin.landing-contents.create') }}" 
                   class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Tambah Konten Pertama
                </a>
                <a href="{{ route('home') }}" target="_blank"
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Lihat Website
                </a>
            </div>
        @else
            <div class="space-x-4">
                <a href="{{ route('admin.landing-contents.create') }}" 
                   class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Tambah Konten
                </a>
                <a href="{{ route('admin.landing-contents.index') }}" 
                   class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                    Lihat Semua Konten
                </a>
            </div>
        @endif
    </div>
@endif

<!-- Common Sections Info -->
<div class="mt-6 sm:mt-8 bg-blue-50 rounded-lg p-4 sm:p-6">
    <h3 class="font-semibold text-blue-900 mb-3 text-sm sm:text-base">Panduan Section Landing Page</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 text-xs sm:text-sm text-blue-800">
        <div>
            <h4 class="font-medium mb-1">Hero Section</h4>
            <p>Bagian utama dengan headline dan call-to-action</p>
        </div>
        <div>
            <h4 class="font-medium mb-1">About</h4>
            <p>Tentang BUMDes dan visi misi</p>
        </div>
        <div>
            <h4 class="font-medium mb-1">Services</h4>
            <p>Layanan dan produk unggulan</p>
        </div>
        <div>
            <h4 class="font-medium mb-1">Features</h4>
            <p>Keunggulan dan fasilitas</p>
        </div>
        <div>
            <h4 class="font-medium mb-1">Testimonial</h4>
            <p>Testimoni pelanggan</p>
        </div>
        <div>
            <h4 class="font-medium mb-1">Contact</h4>
            <p>Informasi kontak dan alamat</p>
        </div>
    </div>
</div>
@endsection