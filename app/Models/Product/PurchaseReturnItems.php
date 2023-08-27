<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PurchaseReturnItems extends Model
{
    public static function productBalance($data3,$product_id)
    {
        // $data = DB::table('purchase_items')
        // ->join('purchases','purchase_items.purchase_id','purchases.purchase_id')
        // ->where('purchase_items.purchase_id',$purchase_id)
        // ->select('purchases.purchase_number')
        // ->first();


        $fetchData = PurchaseReturnItems::where('purchase_number',$data3)->where('purchase_product_id',$product_id)->sum('purchase_product_return_quantity');
        return $fetchData;
    }
}
