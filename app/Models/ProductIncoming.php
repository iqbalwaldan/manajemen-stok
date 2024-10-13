<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIncoming extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'datetime_incoming' => 'datetime', // Mengonversi ke objek Carbon
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productInstallments()
    {
        return $this->hasMany(ProductInstallment::class);
    }
}
