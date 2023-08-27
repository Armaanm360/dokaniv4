<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = "accounts";
    protected $primaryKey = 'account_id';
    protected $guarded = []; 

    public static function account($id)
    {
       $data = Accounts::where('account_id',$id)->select('account_name')->first();
       return $data;
    }
}
