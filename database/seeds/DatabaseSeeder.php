<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Category;
use App\Supplier;
use App\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Membuat akun Admin dan Staff untuk login
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@inventory.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // 2. Membuat Kategori Barang
        $cat1 = Category::create(['name' => 'Elektronik']);
        $cat2 = Category::create(['name' => 'Alat Tulis Kantor']);

        // 3. Membuat Data Supplier
        $sup1 = Supplier::create([
            'name' => 'PT Maju Jaya Abadi',
            'phone' => '081234567890',
            'email' => 'info@majujaya.com',
        ]);

        // 4. Membuat Data Produk Awal
        Product::create([
            'category_id' => $cat1->id,
            'supplier_id' => 1,
            'sku' => 'ELK-001',
            'name' => 'Mouse Wireless Logitech',
            'purchase_price' => 120000,
            'selling_price' => 150000,
            'stock' => 25,
            'minimum_stock' => 5,
        ]);
    }
}