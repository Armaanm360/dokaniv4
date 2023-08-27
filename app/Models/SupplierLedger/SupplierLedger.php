<?php

namespace App\Models\SupplierLedger;

use Illuminate\Database\Eloquent\Model;

class SupplierLedger extends Model
{
    protected $table = "supplier_ledgers";
    protected $primaryKey = "supplier_ledger_id";
    protected $guarded = [];
}
