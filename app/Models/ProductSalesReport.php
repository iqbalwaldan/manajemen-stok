<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSalesReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'datetime_report' => 'datetime',
    ];
}
