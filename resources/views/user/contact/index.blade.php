@extends('layouts.app')

@section('title', 'Kontak - BUMDes Marketplace')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">Hubungi Kami</h1>
            <p class="text-base sm:text-lg lg:text-xl text-gray-600">
                Kirim pesan Anda langsung ke kepala desa
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6 lg:p-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Kirim Pesan</h2>
                
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap *
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            Subjek *
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('subject') border-red-500 @enderror">
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Pesan *
                        </label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-green-700 transition-colors">
                            Kirim Pesan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Informasi Kontak</h3>
                    
                    <div class="space-y-6">
                        <!-- Village Office -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 21V5a2 2 0 012-2h6a2 2 0 012 2v16"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Kantor Desa</h4>
                                <p class="text-gray-600">Pesan akan dikirim langsung ke email kepala desa</p>
                            </div>
                        </div>
                        
                        <!-- Response Time -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Waktu Respon</h4>
                                <p class="text-gray-600">Kami akan merespon dalam 1-2 hari kerja</p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-600">Sistem kontak terintegrasi langsung</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guidelines Card -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">Panduan Mengirim Pesan</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3"></span>
                            Gunakan subjek yang jelas dan spesifik
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3"></span>
                            Tulis pesan dengan bahasa yang sopan dan formal
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3"></span>
                            Sertakan detail yang relevan dengan pertanyaan Anda
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2 mr-3"></span>
                            Pastikan email Anda aktif untuk menerima balasan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection