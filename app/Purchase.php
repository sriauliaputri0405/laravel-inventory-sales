<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    // Kolom-kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'supplier_id', 
        'user_id', 
        'purchase_number', 
        'total', 
        'purchased_at'
    ];

    // Relasi ke Supplier
    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi ke User (Kasir/Admin)
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Item Pembelian
    public function items() {
        return $this->hasMany(PurchaseItem::class);
    }
}