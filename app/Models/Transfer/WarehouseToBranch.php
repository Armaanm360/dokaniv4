<?php

namespace App\Models\Transfer;

use App\Models\Branch\Branch;
use App\Models\Warehouse\Warehouse;
use Illuminate\Database\Eloquent\Model;

class WarehouseToBranch extends Model
{
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
