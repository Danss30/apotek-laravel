<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturModel extends Model
{
    use HasFactory;

    protected $table = 'faktur';
    protected $fillable = [
    'no_faktur', 'tgl_faktur', 'due_date', 'metode_pembayaran',
    'ppn', 'dp', 'grand_total', 'id_user', 'id_customer', 'id_perusahaan'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user', 'id_user');
    }

    // Relasi ke Customer
  public function customer()
{
    return $this->belongsTo(CustomerModel::class, 'id_customer', 'id_customer')->withDefault();
}

    // Relasi ke Perusahaan
  public function perusahaan()
{
    return $this->belongsTo(\App\Models\Perusahaan::class, 'id_perusahaan', 'id_perusahaan')->withDefault();
}

    // Relasi ke Detail Faktur
    public function detail()
    {
        return $this->hasMany(\App\Models\DetailFakturModel::class, 'no_faktur', 'no_faktur');
    }
}
