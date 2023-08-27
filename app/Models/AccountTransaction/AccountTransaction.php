<?php

namespace App\Models\AccountTransaction;

use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    protected $table = "account_transactions";
    protected $primaryKey = "transaction_id";
//    protected $fillable = ["transaction_last_balance","transaction_account_id"];
    protected $guarded = []; 
}
