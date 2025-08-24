@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori</h1>
            <p class="text-gray-600 mt-2">Kelola kategori produk di marketplace</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
            class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
            Tambah Kategori
        </a>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                Cari
            </button>
            <a href="{{ route('admin.categories.index') }}"
                class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                Reset
            </a>
        </form>
    </div>

    @if ($categories->count() > 0)
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach ($categories as $category)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Category Image -->
                    <div class="h-48 bg-gray-200">
                        @if ($category->image)
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Category Info -->
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $category->name }}</h3>
                            @if ($category->description)
                                <p class="text-gray-600 text-sm">{{ Str::limit($category->description, 100) }}</p>
                            @endif
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $category->products_count }} produk
                            </span>
                            <span>{{ $category->created_at->format('d M Y') }}</span>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.show', $category) }}"
                                class="flex-1 bg-blue-600 text-white py-2 px-3 rounded text-center text-sm font-medium hover:bg-blue-700 transition-colors">
                                Lihat
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="flex-1 bg-green-600 text-white py-2 px-3 rounded text-center text-sm font-medium hover:bg-green-700 transition-colors">
                                Edit
                            </a>
                            @if ($category->products_count == 0)
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                    class="flex-1"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full bg-red-600 text-white py-2 px-3 rounded text-sm font-medium hover:bg-red-700 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span
                                    class="flex-1 bg-gray-300 text-gray-500 py-2 px-3 rounded text-center text-sm cursor-not-allowed">
                                    Hapus
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                </path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                {{ request('search') ? 'Kategori Tidak Ditemukan' : 'Belum Ada Kategori' }}
            </h3>
            <p class="text-gray-600 mb-6">
                {{ request('search') ? 'Tidak ada kategori yang cocok dengan pencarian Anda.' : 'Belum ada kategori yang tersedia. Mulai tambahkan kategori untuk mengorganisir produk.' }}
            </p>
            @if (!request('search'))
                <a href="{{ route('admin.categories.create') }}"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Tambah Kategori Pertama
                </a>
            @else
                <div class="space-x-4">
                    <a href="{{ route('admin.categories.create') }}"
                        class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        Tambah Kategori
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition-colors">
                        Lihat Semua Kategori
                    </a>
                </div>
            @endif
        </div>
    @endif
@endsection
