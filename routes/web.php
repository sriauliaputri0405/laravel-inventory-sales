<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// ========================================================================
// RUTE KHUSUS ADMIN / OWNER (Akses Penuh: Kategori, Laporan, & Pembatalan)
// ========================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Manajemen Produk (Tambah, Edit, Hapus)
    Route::get('/products/create', 'ProductController@create')->name('products.create');
    Route::post('/products', 'ProductController@store')->name('products.store');
    Route::get('/products/{product}/edit', 'ProductController@edit')->name('products.edit');
    Route::put('/products/{product}', 'ProductController@update')->name('products.update');
    Route::delete('/products/{product}', 'ProductController@destroy')->name('products.destroy');

    // Master Data Khusus Admin / Owner
    Route::resource('staff', 'StaffController');
    Route::resource('categories', 'CategoryController'); // Kategori hanya untuk Admin/Owner
    Route::resource('suppliers', 'SupplierController');

    // Laporan & Pembatalan Transaksi
    Route::get('/sales/report', 'SaleController@report')->name('sales.report');
    Route::post('/sales/{id}/cancel', 'SaleController@cancel')->name('sales.cancel');
});

// ========================================================================
// RUTE UMUM: Bisa diakses oleh Admin & Staff (Kasir)
// ========================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    
    // Produk: Semua user yang login bisa melihat daftar dan detail produk
    Route::resource('products', 'ProductController')->only(['index', 'show']);
    
    // Keranjang Belanja & Transaksi POS
    Route::post('/cart', 'CartController@store')->name('cart.store');
    Route::delete('/cart/{id}', 'CartController@destroy')->name('cart.destroy');

    Route::get('/sales/create', 'SaleController@create')->name('sales.create');
    Route::get('/sales/{id}/receipt', 'SaleController@receipt')->name('sales.receipt');
    Route::post('/sales/checkout', 'SaleController@checkout')->name('sales.checkout');
    Route::resource('sales', 'SaleController')->except(['create', 'store', 'destroy', 'edit', 'update']);
    
    // Transaksi Pembelian / Restock Stok Masuk
    Route::resource('purchases', 'PurchaseController');
});