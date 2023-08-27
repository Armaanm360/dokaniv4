<?php

namespace App\Models\Transfer;

use Illuminate\Database\Eloquent\Model;

class WarehouseToBranchItems extends Model
{
    public static function quantity($id)
    {
        $data = WarehouseToBranchItems::where('warehouse_to_branch_transfer_number',$id)->sum('transfer_product_amount');
        return $data;
    }
}
