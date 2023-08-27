<?php

namespace App\Models\ClientTransaction;

use Illuminate\Database\Eloquent\Model;

class ClientTransaction extends Model
{
    protected $table = "client_transactions";
    protected $primaryKey = "client_transaction_id";
    protected $guarded = [];
//    protected $fillable = ['client_transaction_type'];
}