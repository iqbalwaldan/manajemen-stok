<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOutgoing extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'datetime_transaction' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
