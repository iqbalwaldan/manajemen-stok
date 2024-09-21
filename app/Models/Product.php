<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productOutgoing()
    {
        return $this->hasMany(ProductOutgoing::class);
    }

    public function productIncoming()
    {
        return $this->hasMany(ProductIncoming::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
}
