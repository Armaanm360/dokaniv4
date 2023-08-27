<?php

namespace App\Models\Product;

use App\Models\Supplier\Supplier;
use App\Models\Warehouse\Warehouse;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $table = "purchases";
    protected $primaryKey = "purchase_id";
    protected $guarded = [];



    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
