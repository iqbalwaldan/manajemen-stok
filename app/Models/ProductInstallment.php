<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime_payment',
        'product_incoming_id',
    ];

    public function productIncoming()
    {
        return $this->belongsTo(ProductIncoming::class);
    }
}
