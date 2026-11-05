@extends('layouts.admin')

@section('title', 'Tambah Desa')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Tambah Desa/Bumdes Baru</h1>
        <p class="text-gray-600 mt-2">Daftarkan desa atau bumdes baru ke marketplace</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.villages.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Desa -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Desa/Bumdes *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E] @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E] @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">{{ old('address') }}</textarea>
                </div>

                <!-- Provinsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                </div>

                <!-- Kota/Kabupaten -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                </div>

                <!-- Kecamatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                    <input type="text" name="district" value="{{ old('district') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                </div>

                <!-- WhatsApp -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="628xxxxxxxxxx"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                </div>

                <!-- Logo URL (optional for now) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo URL (opsional)</label>
                    <input type="text" name="logo" value="{{ old('logo') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                    <p class="text-sm text-gray-500 mt-1">Masukkan URL gambar logo desa</p>
                </div>

                <!-- Cover Photo URL -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Sampul / Cover URL (opsional)</label>
                    <input type="text" name="cover_photo" value="{{ old('cover_photo') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                    <p class="text-sm text-gray-500 mt-1">Contoh: images/villages/cover-desa.jpg</p>
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-[#3BB77E] focus:border-[#3BB77E]">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('admin.villages.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                    class="bg-[#3BB77E] text-white px-6 py-2 rounded-md hover:bg-[#2F9960]">
                    Simpan Desa
                </button>
            </div>
        </form>
    </div>
@endsection
