<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'master_products';
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $fillable = ['product_code','product_name','price','stock_quantity','is_active'];
    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
