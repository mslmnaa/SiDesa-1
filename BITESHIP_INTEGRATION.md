# 📦 Biteship Integration Guide

Dokumentasi lengkap integrasi Biteship API untuk sistem pengiriman SiDesa.

## 📋 Table of Contents

1. [Overview](#overview)
2. [Setup & Configuration](#setup--configuration)
3. [Features](#features)
4. [API Endpoints](#api-endpoints)
5. [Service Methods](#service-methods)
6. [Usage Examples](#usage-examples)
7. [Testing](#testing)

---

## 🎯 Overview

Biteship adalah platform shipping aggregator yang menyediakan:
- **Multiple couriers**: JNE, J&T, SiCepat, TIKI, AnterAja, Ninja, dll
- **Real-time shipping rates**: Perbandingan harga dari berbagai kurir
- **Order creation**: Buat order pengiriman langsung ke kurir
- **Tracking**: Live tracking pengiriman
- **Geocoding**: Search postal code & coordinates

### Why Biteship?

✅ **Akurat**: Menggunakan latitude/longitude untuk perhitungan ongkir yang lebih akurat
✅ **Lengkap**: 15+ kurir dalam 1 API
✅ **Real-time**: Harga langsung dari kurir
✅ **Order Management**: Bisa buat order langsung ke kurir
✅ **Live Tracking**: Update status real-time

---

## ⚙️ Setup & Configuration

### 1. Dapatkan API Key

1. Daftar di [https://biteship.com/](https://biteship.com/)
2. Login ke dashboard
3. Navigate to **Settings** → **API Keys**
4. Copy your API Key

### 2. Environment Variables

Edit file `.env` Anda dan tambahkan:

```env
# Biteship API Configuration
BITESHIP_API_KEY=biteship_test_xxxxxxxxxxxxxxxx
BITESHIP_BASE_URL=https://api.biteship.com/v1
BITESHIP_ENVIRONMENT=development

# Default Origin (Optional - Jakarta coordinates as example)
BITESHIP_DEFAULT_ORIGIN_LAT=-6.175110
BITESHIP_DEFAULT_ORIGIN_LNG=106.865036
```

**Notes:**
- Gunakan `development` untuk testing (tidak akan create order real)
- Gunakan `production` untuk production (akan create order real ke kurir)
- Default origin bisa diset per village di admin panel

### 3. Configuration File

File config sudah dibuat di: `config/biteship.php`

```php
return [
    'api_key' => env('BITESHIP_API_KEY'),
    'base_url' => env('BITESHIP_BASE_URL', 'https://api.biteship.com/v1'),
    'environment' => env('BITESHIP_ENVIRONMENT', 'development'),
    'couriers' => [
        'jne' => 'JNE',
        'jnt' => 'J&T Express',
        'sicepat' => 'SiCepat',
        // ... more couriers
    ],
];
```

---

## 🚀 Features

### 1. Get Shipping Rates ✅

Calculate shipping cost dari berbagai kurir berdasarkan:
- Origin coordinates (latitude/longitude)
- Destination coordinates (latitude/longitude)
- Item weight & dimensions
- Postal codes (optional)

### 2. Create Order ✅

Buat order pengiriman langsung ke kurir:
- Automatic waybill generation
- Shipper & recipient details
- Item information
- Tracking number

### 3. Live Tracking ✅

Track pengiriman real-time:
- Current status
- History/timeline
- Estimated delivery
- Proof of delivery

### 4. Postal Code Search ✅

Search area dan postal code:
- By city name
- By district name
- Returns coordinates

---

## 🔌 API Endpoints

### 1. Get Shipping Rates

**Endpoint:** `POST /api/biteship/rates`

**Request Body:**
```json
{
  "origin_latitude": -6.175110,
  "origin_longitude": 106.865036,
  "destination_latitude": -6.200000,
  "destination_longitude": 106.816666,
  "destination_postal_code": "12530",
  "couriers": "jne,jnt,sicepat,tiki",
  "items": [
    {
      "name": "Kerajinan Rotan",
      "description": "Keranjang rotan ukuran medium",
      "value": 150000,
      "length": 30,
      "width": 30,
      "height": 20,
      "weight": 1000,
      "quantity": 2
    }
  ]
}
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "courier_code": "jne",
      "courier_name": "JNE",
      "courier_service_code": "reg",
      "courier_service_name": "Reguler",
      "description": "Layanan reguler",
      "duration": "2 - 3 hari",
      "price": 25000,
      "type": "reg"
    },
    {
      "courier_code": "jnt",
      "courier_name": "J&T Express",
      "courier_service_code": "ez",
      "courier_service_name": "EZ",
      "description": "Layanan ekonomis",
      "duration": "3 - 4 hari",
      "price": 20000,
      "type": "ez"
    }
  ]
}
```

### 2. Search Postal Code

**Endpoint:** `GET /api/biteship/postal-code/search?q={search}`

**Example:** `GET /api/biteship/postal-code/search?q=Jakarta Selatan`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": "6371",
      "name": "Jakarta Selatan",
      "postal_code": "12110",
      "latitude": -6.2608232,
      "longitude": 106.8106038,
      "administrative_division": {
        "province": "DKI Jakarta",
        "city": "Jakarta Selatan",
        "district": "Tebet"
      }
    }
  ]
}
```

### 3. Get Tracking

**Endpoint:** `GET /api/biteship/tracking/{trackingId}`

**Example:** `GET /api/biteship/tracking/ORD20231125ABC123`

**Response:**
```json
{
  "success": true,
  "data": {
    "status": "delivered",
    "waybill_id": "JNE123456789",
    "courier": {
      "company": "jne",
      "name": "JNE"
    },
    "history": [
      {
        "note": "Paket telah diterima oleh John Doe",
        "status": "delivered",
        "updated_at": "2023-11-27 14:30:00"
      },
      {
        "note": "Paket dalam pengiriman",
        "status": "dropping_off",
        "updated_at": "2023-11-27 08:00:00"
      }
    ]
  }
}
```

---

## 🛠️ Service Methods

### BiteshipService Class

File: `app/Services/BiteshipService.php`

#### 1. getShippingRates($params)

Get shipping rates dari multiple couriers.

```php
$params = [
    'origin_latitude' => -6.175110,
    'origin_longitude' => 106.865036,
    'destination_latitude' => -6.200000,
    'destination_longitude' => 106.816666,
    'destination_postal_code' => '12530',
    'couriers' => 'jne,jnt,sicepat',
    'items' => [
        [
            'name' => 'Product Name',
            'value' => 100000,
            'weight' => 1000, // gram
            'length' => 10,   // cm
            'width' => 10,    // cm
            'height' => 10,   // cm
            'quantity' => 1
        ]
    ]
];

$result = app(BiteshipService::class)->getShippingRates($params);

if ($result['success']) {
    $rates = $result['data'];
    // Process rates
}
```

#### 2. createOrder($params)

Create order langsung ke kurir.

```php
$params = [
    'reference_id' => 'ORD20231125ABC123',
    'shipper_name' => 'Toko Desa ABC',
    'shipper_phone' => '081234567890',
    'shipper_email' => 'desa@example.com',
    'origin_name' => 'Pak Budi',
    'origin_phone' => '081234567890',
    'origin_address' => 'Jl. Desa No. 123',
    'origin_postal_code' => '12345',
    'origin_latitude' => -6.175110,
    'origin_longitude' => 106.865036,
    'destination_name' => 'John Doe',
    'destination_phone' => '081987654321',
    'destination_email' => 'john@example.com',
    'destination_address' => 'Jl. Customer No. 456',
    'destination_postal_code' => '12530',
    'destination_latitude' => -6.200000,
    'destination_longitude' => 106.816666,
    'courier_company' => 'jne',
    'courier_type' => 'reg',
    'items' => [
        [
            'name' => 'Kerajinan Rotan',
            'description' => 'Keranjang rotan',
            'value' => 150000,
            'weight' => 1000,
            'quantity' => 1
        ]
    ]
];

$result = app(BiteshipService::class)->createOrder($params);

if ($result['success']) {
    $orderId = $result['data']['id'];
    $waybillId = $result['data']['courier']['waybill_id'];
}
```

#### 3. track($trackingId)

Track shipment by order ID atau waybill.

```php
$result = app(BiteshipService::class)->track('ORD20231125ABC123');

if ($result['success']) {
    $status = $result['data']['status'];
    $history = $result['data']['history'];
}
```

#### 4. searchPostalCode($search)

Search postal code by area name.

```php
$result = app(BiteshipService::class)->searchPostalCode('Jakarta Selatan');

if ($result['success']) {
    $areas = $result['data'];
    foreach ($areas as $area) {
        echo $area['name'] . ' - ' . $area['postal_code'];
    }
}
```

---

## 💡 Usage Examples

### Example 1: Get Shipping Rates di Checkout

```javascript
// Frontend JavaScript
async function getShippingRates() {
    const response = await fetch('/api/biteship/rates', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            origin_latitude: villageLatitude,
            origin_longitude: villageLongitude,
            destination_latitude: destinationLatitude,
            destination_longitude: destinationLongitude,
            destination_postal_code: postalCode,
            couriers: 'jne,jnt,sicepat,tiki',
            items: cartItems.map(item => ({
                name: item.name,
                value: item.price,
                weight: item.weight * item.quantity,
                quantity: item.quantity
            }))
        })
    });

    const result = await response.json();

    if (result.success) {
        displayShippingOptions(result.data);
    }
}
```

### Example 2: Create Order saat Admin Input Resi

```php
// In ShippingController or OrderController
use App\Services\BiteshipService;

public function createShipment(Order $order)
{
    $biteshipService = app(BiteshipService::class);

    // Get village origin data
    $village = $order->items->first()->village;

    $params = [
        'reference_id' => $order->order_number,
        'shipper_name' => $village->name,
        'shipper_phone' => $village->phone ?? '081234567890',
        'origin_name' => $village->admin_name,
        'origin_phone' => $village->phone,
        'origin_address' => $village->address,
        'origin_postal_code' => $village->postal_code,
        'origin_latitude' => $village->latitude,
        'origin_longitude' => $village->longitude,
        'destination_name' => $order->shippingAddress->recipient_name,
        'destination_phone' => $order->shippingAddress->phone,
        'destination_address' => $order->shippingAddress->full_address,
        'destination_postal_code' => $order->shippingAddress->postal_code,
        'destination_latitude' => $order->destination_latitude,
        'destination_longitude' => $order->destination_longitude,
        'courier_company' => 'jne',
        'courier_type' => 'reg',
        'items' => $order->items->map(fn($item) => [
            'name' => $item->product_name,
            'description' => $item->product_name,
            'value' => $item->price,
            'weight' => $item->product->weight * $item->quantity,
            'quantity' => $item->quantity
        ])->toArray()
    ];

    $result = $biteshipService->createOrder($params);

    if ($result['success']) {
        $order->update([
            'biteship_order_id' => $result['data']['id'],
            'shipping_resi' => $result['data']['courier']['waybill_id'],
            'shipping_courier' => $result['data']['courier']['company'],
        ]);

        return redirect()->back()
            ->with('success', 'Order berhasil dibuat di Biteship!');
    }

    return redirect()->back()
        ->with('error', 'Gagal membuat order: ' . $result['message']);
}
```

---

## 🧪 Testing

### Test API Connection

Buat test route untuk verify API key:

```php
// routes/web.php
Route::get('/test-biteship', function() {
    $service = new \App\Services\BiteshipService();

    // Test get rates
    $result = $service->getShippingRates([
        'origin_latitude' => -6.175110,
        'origin_longitude' => 106.865036,
        'destination_latitude' => -6.200000,
        'destination_longitude' => 106.816666,
        'destination_postal_code' => '12530',
        'couriers' => 'jne,jnt',
        'items' => [
            [
                'name' => 'Test Product',
                'description' => 'Test',
                'value' => 100000,
                'weight' => 1000,
                'length' => 10,
                'width' => 10,
                'height' => 10,
                'quantity' => 1
            ]
        ]
    ]);

    return response()->json([
        'test' => 'Biteship API Test',
        'result' => $result
    ]);
})->name('test.biteship');
```

Access: `http://localhost:8000/test-biteship`

### Expected Success Response:

```json
{
  "test": "Biteship API Test",
  "result": {
    "success": true,
    "data": [
      {
        "courier_code": "jne",
        "courier_name": "JNE",
        "price": 25000,
        "duration": "2 - 3 hari"
      }
    ]
  }
}
```

---

## 🔄 Migration from Binderbyte to Biteship

### Comparison

| Feature | Binderbyte | Biteship |
|---------|-----------|----------|
| **Tracking Only** | ✅ Yes | ✅ Yes |
| **Get Rates** | ❌ No | ✅ Yes |
| **Create Order** | ❌ No | ✅ Yes |
| **Accuracy** | City-based | ✅ Coordinates-based |
| **Couriers** | 9 | ✅ 15+ |
| **Pricing** | Free tier | Paid (with free tier) |

### Recommended Approach

**Keep Both Services:**
- **Biteship**: For getting shipping rates di checkout (accurate pricing)
- **Binderbyte**: For tracking only (cheaper/free)

**OR Full Biteship:**
- Use Biteship for everything (rates + tracking + order creation)

---

## 📝 Notes

### Important Points

1. **API Key Security**: Jangan commit API key ke git. Gunakan `.env`
2. **Environment**: Pastikan set `development` saat testing
3. **Coordinates**: Biteship lebih akurat dengan lat/lng daripada postal code saja
4. **Weight Unit**: Weight dalam **gram** (1kg = 1000)
5. **Dimension Unit**: Length/width/height dalam **cm**
6. **Logging**: Semua API call dicatat di log untuk debugging

### Troubleshooting

**Error: Invalid API Key**
- Check `.env` file
- Verify API key di Biteship dashboard
- Run `php artisan config:clear`

**Error: Invalid coordinates**
- Coordinates harus decimal (-6.175110, bukan "-6.175110")
- Latitude range: -90 to 90
- Longitude range: -180 to 180

**No rates returned**
- Check if destination is supported
- Verify weight & dimensions are correct
- Try different courier combinations

---

## 📚 Resources

- **Biteship Dashboard**: [https://biteship.com/](https://biteship.com/)
- **API Documentation**: [https://biteship.com/docs](https://biteship.com/docs)
- **Support**: support@biteship.com

---

## ✅ Checklist Setup

- [ ] Daftar akun Biteship
- [ ] Get API key dari dashboard
- [ ] Update `.env` dengan API key
- [ ] Test API connection (`/test-biteship`)
- [ ] Set village coordinates di admin panel
- [ ] Test shipping rates di checkout
- [ ] Test order creation (optional)
- [ ] Test tracking

---

**Happy Shipping! 🚚📦**
