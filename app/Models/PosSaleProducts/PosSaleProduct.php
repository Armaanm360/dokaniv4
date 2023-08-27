<?php

namespace App\Models\PosSaleProducts;

use Illuminate\Database\Eloquent\Model;

class PosSaleProduct extends Model
{
    protected $table = "pos_sale_products";
    protected $primaryKey = "sale_product_id";
    protected $guarded = []; 
}
