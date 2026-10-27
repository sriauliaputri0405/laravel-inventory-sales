<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'sale_number',
        'total',
        'status',
        'sold_at'
    ];

    // Relasi ke detail item penjualan
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relasi ke User/Kasir
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}