<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukModel extends Model
{
    protected $table = "produk";
    protected $primaryKey = 'id_produk';


    protected $fillable = [
    'nama_produk',
    'price',
    'jenis',
    'stock'
    
];

}
