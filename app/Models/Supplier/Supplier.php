<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
   protected $table = "suppliers";
   protected $primaryKey = 'supplier_id';
   protected $guarded = [];
   public static function supplier($id)
   {
        $supplier = Supplier::where('supplier_id',$id)->select('suuplier_name')->first();
        return $supplier;
   }
}
