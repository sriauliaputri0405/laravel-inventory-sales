<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    // Relasi ke tabel Sale (Penjualan Utama)
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relasi ke tabel Product (Produk yang dibeli)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}