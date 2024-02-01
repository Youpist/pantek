<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    // use HasFactory;

    protected $fillable = ['invoice_id', 'desc', 'qty', 'harga_produk'];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
