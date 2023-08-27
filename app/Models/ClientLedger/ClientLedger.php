<?php

namespace App\Models\ClientLedger;

use Illuminate\Database\Eloquent\Model;

class ClientLedger extends Model
{
 protected $table = "client_ledgers";
    protected $primaryKey = "client_ledger_id ";
    protected $guarded = []; 
}
