<?php

namespace App\Models\InvoiceReturnProduct;

use Illuminate\Database\Eloquent\Model;

class InvoiceReturnProduct extends Model
{
    protected $table = "invoice_return_products";
    protected $primaryKey = "return_id";
    protected $guarded = []; 
}