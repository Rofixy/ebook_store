<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'produk_id',       // Pastikan ini ditambahkan
        'produk',
        'harga',
        'berat',
        'asal',
        'tujuan',
        'tanggal_pesanan',
        'jumlah_pesanan',
        'jumlah_harga',
        'pemesan',
    ];
}
