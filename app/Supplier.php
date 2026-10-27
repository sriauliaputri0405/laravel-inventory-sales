<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // Mendaftarkan kolom yang boleh diisi
    protected $fillable = ['name', 'phone', 'email', 'address'];

    // Relasi ke tabel purchases (pembelian)
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}