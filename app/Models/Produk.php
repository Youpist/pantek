<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transaksis(){
        return $this->hasMany(Transaksi::class);
    }
    public function kategori(){

        return $this->belongsTo(Kategori::class, 'id_kategori'); 
    }
}
