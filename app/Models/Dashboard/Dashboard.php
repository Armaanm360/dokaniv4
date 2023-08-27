<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\Expense\Expense;
use App\Models\MoneyReceipt\MoneyReceipt;
use Illuminate\Support\Facades\DB;
use App\Models\Accounts\Accounts;
use App\Models\AccountTrasection\AccountTrasection;
use App\Models\Clients\Client;
use App\Models\ClientTransaction;
use App\Models\InvoicePosSale\InvoicePosSaleBilling;
use App\Models\Invoice\InvoicePosSale;
use App\Models\Sponsors\Sponsors;
use App\Models\SponsorTransaction\SponsorTransaction;
use App\Models\InvoicePosSale\InvoicePosSalePosSale;

class Dashboard extends Model
{
    public static function get_today_sales()
    {
        $invoiceTotalSales = InvoicePosSale::where('sales_date', Carbon::today()->toDateString())->sum('grand_total');
        $invoiceTotalSalesAmount = 0;
        if ($invoiceTotalSales != "") {
            $invoiceTotalSalesAmount = $invoiceTotalSales;
        }
        return $invoiceTotalSalesAmount;
    }

    public static function get_this_month_sales()
    {
        $invoiceTotalSales = InvoicePosSale::where('sales_date', '>=', Carbon::today()->toDateString())
            ->where('sales_date', '<=', Carbon::now()->endOfMonth()->toDateString())
            ->sum('grand_total');
        $invoiceTotalSalesAmount = 0;
        if ($invoiceTotalSales != "") {
            $invoiceTotalSalesAmount = $invoiceTotalSales;
        }
        return $invoiceTotalSalesAmount;
    }

    public static function get_today_expense()
    {
        $expense = Expense::where('created_at', Carbon::today()->toDateString())->sum('expense_amount');
        if ($expense != "") {
            return $expense;
        } else {
            return 0;
        }
    }

    public static function get_this_month_expense()
    {
        $expense = Expense::where('created_at', '>=', Carbon::today()->toDateString())
            ->where('created_at', '<=', Carbon::now()->endOfMonth()->toDateString())
            ->sum('expense_amount');
        if ($expense != "") {
            return $expense;
        } else {
            return 0;
        }
    }

    public static function get_today_collection()
    {
        $moneyReceipt = MoneyReceipt::where('money_reciept_payment_date', Carbon::today()->toDateString())->sum('money_reciept_total_amount');
        if ($moneyReceipt != "") {
            return $moneyReceipt;
        } else {
            return 0;
        }
    }

    public static function get_today_profit()
    {
        $invoiceSales = DB::table('pos_sale_products')->where('create_date', '>=', Carbon::today()->toDateString())
            ->where('create_date', '<=', Carbon::now()->endOfMonth()->toDateString())
            //            ->where('pos_sale_id','=',$row->sale_id)   
            ->get();


        // echo '<pre>';
        // print_r($invoiceSales);
        // die;
        $invoiceTotalSalesProfitAmount = 0;
        foreach ($invoiceSales as $row) {
            $purchase = DB::table('purchase_items')
                ->where('purchase_product_id', '=', $row->product_id)
                ->get();

            $profit = $row->price - $purchase[0]->purchase_product_price;

            $invoiceTotalSalesProfitAmount += $profit;
        }


        $expense = Expense::where('created_at', Carbon::today()->toDateString())->sum('expense_amount');
        $expenseAmount = 0;
        if ($expense != "") {
            $expenseAmount = $expense;
        }

        $knitProfit = $invoiceTotalSalesProfitAmount - $expenseAmount;
        return $knitProfit;
    }

    public static function get_this_month_sales_profit()
    {
        $invoiceSales = DB::table('pos_sale_products')->where('create_date', '>=', Carbon::today()->toDateString())
            ->where('create_date', '<=', Carbon::now()->endOfMonth()->toDateString())
            //            ->where('pos_sale_id','=',$row->sale_id)   
            ->get();


        // return $invoiceSales;
        $invoiceTotalSalesProfitAmount = 0;
        foreach ($invoiceSales as $row) {
            $purchase = DB::table('purchase_items')
                ->where('purchase_product_id', '=', $row->product_id)
                ->get();

            $profit = $row->price - $purchase[0]->purchase_product_price;

            $invoiceTotalSalesProfitAmount += $profit;
        }



        return $invoiceTotalSalesProfitAmount;
    }


    public static function get_this_month_net_profit()
    {
        $invoiceSales = DB::table('pos_sale_products')->where('create_date', '>=', Carbon::today()->toDateString())
            ->where('create_date', '<=', Carbon::now()->endOfMonth()->toDateString())
            //            ->where('pos_sale_id','=',$row->sale_id)   
            ->get();


        // return $invoiceSales;
        $invoiceTotalSalesProfitAmount = 0;
        foreach ($invoiceSales as $row) {
            $purchase = DB::table('purchase_items')
                ->where('purchase_product_id', '=', $row->product_id)
                ->get();

            $profit = $row->price - $purchase[0]->purchase_product_price;

            $invoiceTotalSalesProfitAmount += $profit;
        }

        $expense = Expense::where('created_at', Carbon::today()->toDateString())->sum('expense_amount');
        $expenseAmount = 0;
        if ($expense != "") {
            $expenseAmount = $expense;
        }

        $knitProfit = $invoiceTotalSalesProfitAmount - $expenseAmount;
        return $knitProfit;
    }

    public static function get_today_sales_profit()
    {
        $invoiceSales = DB::table('pos_sale_products')->where('create_date', '>=', Carbon::today()->toDateString())
            ->where('create_date', '<=', Carbon::now()->endOfMonth()->toDateString())
            //            ->where('pos_sale_id','=',$row->sale_id)   
            ->get();


        // return $invoiceSales;
        $invoiceTotalSalesProfitAmount = 0;
        foreach ($invoiceSales as $row) {
            $purchase = DB::table('purchase_items')
                ->where('purchase_product_id', '=', $row->product_id)
                ->get();

            $profit = $row->price - $purchase[0]->purchase_product_price;

            $invoiceTotalSalesProfitAmount += $profit;
        }


        return $invoiceTotalSalesProfitAmount;
    }




    public static function list_of_accounts()
    {
        return Accounts::where('account_has_deleted', '=', 'NO')
            ->get()->take(5);
    }

    public static function list_of_clients()
    {
        return Client::where('client_has_deleted', '=', 'NO')
            ->get()->take(4);
    }

    public static function last_seven_sponsors()
    {
        $sponsors = Sponsors::where('sponsor_has_deleted', '=', 'NO')
            ->limit(7)
            ->get();
        $data = array();
        $credit = array();
        $debit = array();
        foreach ($sponsors as $row) {
            array_push($data, '"' . $row->sponsor_name . '"');
            $credits = SponsorTransaction::whereSponsorTransactionId($row->sponsor_id)->whereSponsorTransactionType('CREDIT')->sum('sponsor_transaction_amount');
            if ($credits) {
                array_push($credit, $credits);
            } else {
                array_push($credit, 0);
            }
            $debits = SponsorTransaction::whereSponsorTransactionId($row->sponsor_id)->whereSponsorTransactionType('DEBIT')->sum('sponsor_transaction_amount');
            if ($debits) {
                array_push($debit, $debits);
            } else {
                array_push($debit, 0);
            }
        }

        $output = [
            'sponsor' => implode(",", $data),
            'credit' => implode(",", $credit),
            'debit' => implode(",", $debit)
        ];

        return $output;
    }


    public static function total_of_accounts()
    {
        $credit = AccountTrasection::whereTransactionHasDeleted("NO")->whereTransactionType('CREDIT')->sum('transaction_amount');
        $debit = AccountTrasection::whereTransactionHasDeleted("NO")->whereTransactionType('DEBIT')->sum('transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }

    public static function total_of_clients()
    {
        $credit = ClientTransaction::whereClientTransactionHasDeleted("NO")->whereClientTransactionType('CREDIT')->sum('client_transaction_amount');
        $debit = ClientTransaction::whereClientTransactionHasDeleted("NO")->whereClientTransactionType('DEBIT')->sum('client_transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }

    public static function this_year_sales()
    {
        // $sales = InvoicePosSale::where('sales_date', '>=', '2022-01-01')
        //         ->where('sales_date', '<=', '2022-12-13')
        //         ->select(DB::raw("sum(grand_total) as total_sales, DATE_FORMAT(sales_date, '%m') as month"))
        //         ->groupBy('month')
        //         ->orderBy('month','asc')
        //             ->get();
        // 

        $online = InvoicePosSale::where('sales_date', '>=', date('Y-m-d', strtotime('first day of january this year')))
            ->where('sales_date', '<=', date('Y-m-d', strtotime('last day of december this year')))
            ->where('customer_type', '=', 'online')
            ->select(DB::raw("sum(grand_total) as online_sales, DATE_FORMAT(sales_date, '%m') as month"))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $offline = InvoicePosSale::where('sales_date', '>=', date('Y-m-d', strtotime('first day of january this year')))
            ->where('sales_date', '<=', date('Y-m-d', strtotime('last day of december this year')))
            ->where('customer_type', '=', 'offline')
            ->select(DB::raw("sum(grand_total) as offline_sales, DATE_FORMAT(sales_date, '%m') as month"))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();


        $monthData = array();
        for ($i = 1; $i <= 12; $i++) {
            if ($i < 10) {
                $monthData['0' . $i] = 0;
            } else {
                $monthData[$i] = 0;
            }
        }
        foreach ($online as $row) {
            $monthData[$row->month] = $row->online_sales;
        }

        $onlineResult = implode(",", $monthData);

        foreach ($offline as $cost) {
            $monthData[$cost->month] = $cost->offline_sales;
        }

        $offlineResult = implode(",", $monthData);

        //      foreach ($revenue as $revenueRow){
        //         $monthData[$revenueRow->month] = $revenueRow->total_profits;
        //     }
        //     
        //      $revenueResult = implode(",",$monthData);

        $data = [
            "online" => $onlineResult,
            "offline" => $offlineResult
        ];

        return $data;
    }

    public static function last_five_invoice()
    {
        return InvoicePosSale::where('invoice_has_deleted', '=', 'NO')
            ->join("clients", "invoices.invoice_client_id", "=", "clients.client_id")
            ->get()->take(5);
    }
}




//Domain