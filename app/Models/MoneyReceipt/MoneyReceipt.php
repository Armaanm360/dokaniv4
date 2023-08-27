<?php

namespace App\Models\MoneyReceipt;
use App\Models\Accounts\Accounts;
use App\Models\AccountTransaction\AccountTransaction;

use Illuminate\Database\Eloquent\Model;

class MoneyReceipt extends Model
{
    protected $table = "money_receipt";
    protected $primaryKey = "money_receipt_id";
    protected $guarded = []; 

    public static function generate_vouchar_no()
	{
        $date = date("Y-m-d");
        $invoice_date = date("ymd");
        $lastMoneyReceipt = MoneyReceipt::where('money_receipt_payment_date', 'LIKE', "%{$date}%")->get();
        return $invoice_date . str_pad(($lastMoneyReceipt->count() + 1), 2, "0", STR_PAD_LEFT);
    }
    
    public static function list_of_account()
	{        
        return Accounts::where('account_has_deleted', "NO")->get();
    }
    public static function get_selected_account($tr_id)
	{  
        return AccountTransaction::whereTransactionId($tr_id)->get();
//        return AccountsTra::where('account_has_deleted', "NO")->get();
    }

    public static function get_account_info($tr_id)
	{  
        return AccountTransaction::whereTransactionId($tr_id)
        ->join('accounts','account_transactions.transaction_account_id','=','accounts.account_id')
        ->get();
//        return AccountsTra::where('account_has_deleted', "NO")->get();
    }

}
