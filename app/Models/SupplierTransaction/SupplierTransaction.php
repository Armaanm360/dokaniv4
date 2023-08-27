<?php

namespace App\Models\SupplierTransaction;

use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{
    protected $table = "supplier_transactions";
    protected $primaryKey = "supplier_transaction_id";
    protected $guarded = [];
}
