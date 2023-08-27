<?php

namespace App\Models\Reports\ProfitLoss;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice\InvoicePosSale;
use App\Models\Refund\Refund;
use App\Models\Expense\Expense;
use App\Models\MoneyReceipt\MoneyReceipt;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitLoss extends Model
{
    public static function get_sales($from,$to) {               
           $invoiceTotalSales = InvoicePosSale::where('sales_date',Carbon::today()->toDateString())->sum('grand_total');
$invoiceTotalSalesAmount = 0;
 if($invoiceTotalSales != ""){
     $invoiceTotalSalesAmount = $invoiceTotalSales;
 }
 return $invoiceTotalSalesAmount;
    }
    
    public static function get_costs($from,$to) {               
              $invoiceSales = DB::table('pos_sale_products')->where('create_date', '>=', Carbon::today()->toDateString())
         ->where('create_date', '<=', Carbon::now()->endOfMonth()->toDateString())
//            ->where('pos_sale_id','=',$row->sale_id)   
    ->get(); 
 
 
// return $invoiceSales;
$costs = 0;
 foreach($invoiceSales as $row){
   $purchase = DB::table('purchase_items')
            ->where('purchase_product_id','=',$row->product_id)
    ->get(); 
   
   $costs += $purchase[0]->purchase_product_price;
    }
    return $costs;
    }
    
    
    public static function get_general_expense($from,$to) {               
                return Expense::where("is_deleted","=","NO")->whereDate('expense_date','>=', $from)
            ->whereDate('expense_date','<=', $to)->sum("expense_amount"); 
    }
    public static function get_total_invoice_discount($from,$to) {               
                 return InvoicePosSale::whereInvoiceHasDeleted("NO")->whereDate('sales_date','>=', $from)
            ->whereDate('sales_date','<=', $to)->sum("overall_discount");  
    }
    public static function get_total_money_receipt_discount($from,$to) {               
                 return MoneyReceipt::whereMoneyReceiptHasDeleted("NO")->whereDate('money_receipt_payment_date','>=', $from)
            ->whereDate('money_receipt_payment_date','<=', $to)->sum("money_receipt_total_discount");  
    }
}
