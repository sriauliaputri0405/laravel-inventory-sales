<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    // Kolom-kolom detail barang yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'purchase_id', 
        'product_id', 
        'quantity', 
        'unit_price', 
        'subtotal'
    ];

    // Relasi kembali ke Produk
    public function product() {
        return $this->belongsTo(Product::class);
    }
}