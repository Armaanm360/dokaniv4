<?php

namespace App\Models\SupplierPayment;

use Illuminate\Database\Eloquent\Model;

class SupplierPayment extends Model
{
    protected $table = "supplier_payments";
    protected $primaryKey = "payment_id";
    protected $guarded = [];
}
