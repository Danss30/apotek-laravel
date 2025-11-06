<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailFakturModel extends Model
{
    use HasFactory;

    protected $table = 'detail_faktur';
    protected $fillable = [
        'no_faktur',
        'id_produk',
        'qty',
        'price',
        'subtotal'
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(\App\Models\ProdukModel::class, 'id_produk');
    }

    // Relasi ke Faktur
    public function faktur()
    {
        return $this->belongsTo(\App\Models\FakturModel::class, 'no_faktur', 'no_faktur');
    }
}
