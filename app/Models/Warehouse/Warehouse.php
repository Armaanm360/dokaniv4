<?php

namespace App\Models\Warehouse;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{

    protected $table = "warehouses";
    protected $primaryKey = 'warehouse_id';
    protected $guarded = [];


    public function getWareHouseName($id)
    {
        $warehouse = Warehouse::where('warehouse_id',$id)->get();

        if (isset($warehouse[0])) {
            return $warehouse[0]->warehouse_name;
        }
    }
    public static function warehouseName($id)
    {
        $data = Warehouse::where('warehouse_id',$id)->select('warehouse_name')->first();
        return $data;
    }
}
