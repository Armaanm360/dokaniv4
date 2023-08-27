<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class PurchaseItems extends Model
{
    public  function pruchaseItems($product_id)
    {
        $data = PurchaseItems::where('purchase_product_id', $product_id)->first();

        return $data->purchase_product_quantity;
    }
}
