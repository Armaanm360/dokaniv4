<?php

namespace App\Models\Product;

use App\Models\Transfer\WarehouseToBranchItems;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = "products";
    protected $primaryKey = 'product_id';
    protected $guarded = [];


    public static function product($id)
    {
        $data = Product::where('product_id', $id)->first();
        return $data;
    }
    public static function productName($product_id)
    {
        $data = Product::where('product_id', $product_id)->select('products.product_name')->first();

        return $data;
    }
    public static function productBal($product_id, $warehouse_id)
    {
        $productpurchaseQuantity = PurchaseItems::where('purchase_product_id', $product_id)->where('warehouse_id', $warehouse_id)->sum('purchase_product_quantity');
        $productreturnQuantity = PurchaseReturnItems::where('purchase_product_id', $product_id)->where('warehouse_id', $warehouse_id)->sum('purchase_product_return_quantity');
        $producttransferQuantity = WarehouseToBranchItems::where('warehouse_id', $warehouse_id)->where('transfer_product_id', $product_id)->sum('transfer_product_amount');
        $productQuantity = $productpurchaseQuantity - ($productreturnQuantity + $producttransferQuantity);

        return $productQuantity;
    }
    public  function productNameGet($product_id)
    {
        $data = Product::where('product_id', $product_id)->first();

        return $data->product_name;
    }
}
