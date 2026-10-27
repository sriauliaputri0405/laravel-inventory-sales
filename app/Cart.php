<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Relasi ke Model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}