@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center text-green-600 hover:text-green-700 mb-3">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Pesanan
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan #{{ $order->order_number }}</h1>
        <p class="text-sm text-gray-600 mt-1">Dibuat {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="ml-3 text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content (2 columns) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-green-600 text-white">
                    <h3 class="text-lg font-semibold">Produk yang Dipesan</h3>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                            @if($item->product)
                                                <div class="text-xs text-gray-500">Desa: {{ $item->product->village->name }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3 text-center text-sm">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-4 py-3 text-right font-medium">Subtotal Produk:</td>
                                    <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td colspan="3" class="px-4 py-3 text-right">
                                        <div class="font-medium">Ongkos Kirim:</div>
                                        <div class="text-xs text-gray-500">{{ $order->shipping_service }} (ETD: {{ $order->shipping_etd }})</div>
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="bg-green-50">
                                    <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-900">TOTAL:</td>
                                    <td class="px-4 py-3 text-right font-bold text-green-600 text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-blue-600 text-white">
                    <h3 class="text-lg font-semibold">Informasi Pengiriman</h3>
                </div>
                <div class="p-6">
                    @if($order->shippingAddress)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Penerima:</h4>
                                <p class="text-gray-700">{{ $order->shippingAddress->recipient_name }}</p>
                                <p class="text-gray-600 text-sm mt-1">
                                    <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $order->shippingAddress->phone }}
                                </p>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-2">Alamat:</h4>
                                <p class="text-gray-700 text-sm">{{ $order->shippingAddress->full_address }}</p>
                                <p class="text-gray-700 text-sm">{{ $order->shippingAddress->district }}, {{ $order->shippingAddress->city_name }}</p>
                                <p class="text-gray-700 text-sm">{{ $order->shippingAddress->province_name }}, {{ $order->shippingAddress->postal_code }}</p>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Jasa Pengiriman:</h4>
                                    <p class="text-gray-700">{{ $order->shipping_service }}</p>
                                    <p class="text-sm text-gray-500">Estimasi: {{ $order->shipping_etd }}</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-2">Ongkos Kirim:</h4>
                                    <p class="text-gray-700 font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking Info with Binderbyte -->
                        @if($order->hasTracking())
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                        </svg>
                                        <div>
                                            <span class="font-medium text-green-800">Nomor Resi:</span>
                                            <span class="ml-2 text-green-900 font-mono">{{ $order->shipping_resi }}</span>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $order->getShippingStatusColor() }}">
                                        {{ $order->shipping_status ? ucfirst(str_replace('_', ' ', $order->shipping_status)) : 'Pending' }}
                                    </span>
                                </div>
                                <div class="text-sm text-green-700">
                                    <span class="font-medium">Kurir:</span> {{ strtoupper($order->shipping_courier) }}
                                    @if($order->shipped_at)
                                        <span class="ml-4"><span class="font-medium">Dikirim:</span> {{ $order->shipped_at->format('d M Y, H:i') }}</span>
                                    @endif
                                </div>
                                @if($order->tracking_updated_at)
                                    <div class="text-xs text-green-600 mt-2">
                                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Terakhir diupdate: {{ $order->tracking_updated_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        @elseif($order->payment_status === 'paid' && in_array($order->status, ['pending', 'processing']))
                            <!-- Show Input Resi button if paid but not shipped -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <span class="text-yellow-800 font-medium">Belum ada nomor resi</span>
                                    </div>
                                    <a href="{{ route('admin.shipping.create', $order) }}"
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors font-medium text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Input Nomor Resi
                                    </a>
                                </div>
                                <p class="text-xs text-yellow-700 mt-2 ml-7">Silakan input nomor resi untuk mengaktifkan tracking pengiriman</p>
                            </div>
                        @endif

                        <!-- Update Shipping Form -->
                        <div class="border-t pt-4 mt-4">
                            <button @click="showShippingForm = !showShippingForm" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Update Informasi Pengiriman
                            </button>
                            <div x-show="showShippingForm" x-cloak class="mt-4 bg-gray-50 p-4 rounded-lg">
                                <form action="{{ route('admin.orders.update-shipping', $order) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Resi / Tracking Number</label>
                                        <input type="text" name="shipping_tracking_number" value="{{ old('shipping_tracking_number', $order->shipping_tracking_number) }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Masukkan nomor resi pengiriman">
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pengiriman</label>
                                        <textarea name="shipping_notes" rows="2"
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                  placeholder="Catatan tambahan mengenai pengiriman"></textarea>
                                    </div>
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                        </svg>
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada informasi pengiriman</p>
                    @endif
                </div>
            </div>

            <!-- Customer Notes -->
            @if($order->customer_notes)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-700 text-white">
                        <h3 class="text-lg font-semibold">Catatan Customer</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700">{{ $order->customer_notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Admin Notes -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-700 text-white">
                    <h3 class="text-lg font-semibold">Catatan Admin</h3>
                </div>
                <div class="p-6">
                    @if($order->admin_notes)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <pre class="text-sm text-gray-700 whitespace-pre-wrap font-sans">{{ $order->admin_notes }}</pre>
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada catatan admin</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar (1 column) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-yellow-500 text-white">
                    <h3 class="text-lg font-semibold">Status Pesanan</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Saat Ini:</label>
                            <div class="mb-3">
                                @if($order->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Processing</span>
                                @elseif($order->status === 'shipped')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">Shipped</span>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Completed</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Cancelled</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status:</label>
                            <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Status akan otomatis update pada halaman customer</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Admin (Optional):</label>
                            <textarea name="admin_notes" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                      placeholder="Tambahkan catatan untuk perubahan status ini..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-green-600 text-white">
                    <h3 class="text-lg font-semibold">Status Pembayaran</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status:</label>
                        @if($order->payment_status === 'paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">✓ Lunas</span>
                            @if($order->paid_at)
                                <p class="text-xs text-gray-500 mt-2">Dibayar: {{ $order->paid_at->format('d M Y, H:i') }}</p>
                            @endif
                        @elseif($order->payment_status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pending</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Belum Bayar</span>
                        @endif
                    </div>

                    @if($order->midtrans_transaction_id)
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Transaction ID:</label>
                            <p class="text-xs text-gray-600 break-all">{{ $order->midtrans_transaction_id }}</p>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran:</label>
                        <p class="text-sm text-gray-800">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                    </div>

                    @if($order->payment_status !== 'paid')
                        <div class="border-t pt-4">
                            <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ubah Status Pembayaran:</label>
                                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Lunas</option>
                                        <option value="failed">Gagal</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm">
                                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Pembayaran
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-700 text-white">
                    <h3 class="text-lg font-semibold">Informasi Customer</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nama:</label>
                        <p class="text-sm text-gray-800">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Email:</label>
                        <p class="text-sm text-gray-800">{{ $order->user->email }}</p>
                    </div>
                    @if($order->user->phone)
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Telepon:</label>
                            <p class="text-sm text-gray-800">{{ $order->user->phone }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="px-6 py-4 bg-gray-700 text-white">
                    <h3 class="text-lg font-semibold">Ringkasan</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-medium">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Ongkir:</span>
                            <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-2 border-t flex justify-between">
                            <span class="font-bold text-gray-900">Total:</span>
                            <span class="font-bold text-green-600 text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('orderDetail', () => ({
        showShippingForm: false
    }))
})
</script>
@endsection
