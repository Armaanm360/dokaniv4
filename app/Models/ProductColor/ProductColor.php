<?php

namespace App\Models\ProductColor;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = "product_colors";
    protected $primaryKey = 'product_colors_id';
    protected $guarded = [];
}