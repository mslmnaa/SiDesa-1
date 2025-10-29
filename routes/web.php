<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\Product\ProductController;
use App\Http\Controllers\User\Cart\CartController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Product\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\SuperAdmin\User\UserController as AdminUserController;
use App\Http\Controllers\Admin\Village\VillageController;
use App\Http\Controllers\User\Village\VillageController as UserVillageController;
use App\Http\Controllers\User\Contact\ContactController;
use App\Http\Controllers\User\Order\OrderController as UserOrderController;
use App\Http\Controllers\SuperAdmin\System\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Villages Routes
Route::get('/villages', [UserVillageController::class, 'index'])->name('villages.index');
Route::get('/villages/{slug}', [UserVillageController::class, 'show'])->name('villages.show');

// Products Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/type/{type}', [ProductController::class, 'byType'])->name('products.type');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/category/{category}', [ProductController::class, 'category'])->name('products.category');
Route::post('/products/{product}/whatsapp-inquiry', [ProductController::class, 'whatsappInquiry'])->name('products.whatsapp-inquiry');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes (Authentication Required)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('user.cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('user.cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('user.cart.remove');

    // Order Routes
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
    Route::get('/checkout', [UserOrderController::class, 'checkout'])->name('user.orders.checkout');
    Route::post('/checkout', [UserOrderController::class, 'store'])->name('user.orders.store');
    Route::post('/orders/{order}/payment-proof', [UserOrderController::class, 'uploadPaymentProof'])->name('user.orders.payment-proof');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    
    // Category Management
    Route::resource('categories', AdminCategoryController::class);

    // Admin Management (SuperAdmin Only)
    Route::resource('admins', AdminManagementController::class);

    // User Management (Super Admin Only)
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    
    // Settings Management (Super Admin Only)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/test-email', [SettingController::class, 'testEmail'])->name('settings.test-email');

    // Village Management (SuperAdmin Only)
    Route::resource('villages', VillageController::class);
    Route::post('villages/{village}/toggle-status', [VillageController::class, 'toggleStatus'])->name('villages.toggle-status');
});
