<?php

namespace App\Models\InvoiceReturn;

use Illuminate\Database\Eloquent\Model;

class InvoiceReturn extends Model
{
    protected $table = "invoice_returns";
    protected $primaryKey = "sale_return_id";
    protected $guarded = []; 
}
