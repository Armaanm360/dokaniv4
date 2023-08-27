<?php

namespace App\Models\PosTransfer;

use App\Models\PosTransferProduct\PosTransferProduct;
use Illuminate\Database\Eloquent\Model;

class PosTransfer extends Model
{
    protected $table = "pos_transfers";
    protected $primaryKey = "transfer_id";
    protected $guarded = [];


    public function getTotalProductQuantity($transferNo)
    {
        $totalProduct = PosTransferProduct::where('transferNo', $transferNo)->sum('quantity');

        return $totalProduct;

   
    }

}
