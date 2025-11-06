<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = "perusahaan";
    protected $primaryKey = 'id_perusahaan';


    protected $fillable = [
    'nama_perusahaan',
    'alamat',
    'no_telp',
    'fax',
];

}
