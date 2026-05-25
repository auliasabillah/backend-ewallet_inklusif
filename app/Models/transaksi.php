<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'jenis',
        'kategori',
        'nominal',
        'deskripsi'
    ];
}