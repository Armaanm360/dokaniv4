<?php

namespace App\Models\PosTransferProduct;

use Illuminate\Database\Eloquent\Model;

class PosTransferProduct extends Model
{
    protected $table = "pos_transfer_products";
    protected $primaryKey = "transfer_product_id";
    protected $guarded = [];

    public static function quantity($id)
    {
        $data = PosTransferProduct::where('transferNo',$id)->sum('quantity');
        return $data;
    }
}
