<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    // use HasFactory;

    protected $fillable = ['id_user', 'total_harga', 'id_produk', 'jumlah_produk'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item(){
        return $this->hasMany(InvoiceItem::class);
    }
}
