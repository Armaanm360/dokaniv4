<?php

namespace App\Models\NonInvoiceIncome;

use Illuminate\Database\Eloquent\Model;

class NonInvoiceIncome extends Model
{
    protected $table = "non_invoice_income";
    protected $primaryKey = "non_invoice_id";
    protected $guarded = []; 
}
