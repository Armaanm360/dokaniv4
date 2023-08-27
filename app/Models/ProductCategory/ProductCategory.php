<?php

namespace App\Models\ProductCategory;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = "product_categories";
    protected $primaryKey = 'product_category_id';
    protected $guarded = [];
}