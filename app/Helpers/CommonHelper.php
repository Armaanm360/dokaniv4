<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Agents\Agent;
use App\Models\Configuration\HeadModel;
use App\Models\Configuration\Subhead;
use App\Models\Deligates\Deligate;
use App\Models\Sponsors\Sponsors;
use App\Models\Invoice\Invoice;
use App\Models\AccountTransaction\AccountTransaction;
use App\Models\AgentTransection\AgentTransection;
use App\Models\DeligateTransaction\DeligateTransaction;
use App\Models\MoneyReciept\MoneyReciept;
use App\Models\SponsorTransaction\SponsorTransaction;
use Illuminate\Support\Carbon;
use App\Models\Expense\Expense;
use App\Models\Accounts\Accounts;
use App\Models\Attribute\Attribute;
use App\Models\Branch\Branch;
use App\Models\Client\Client as ClientClient;
use App\Models\ClientTransaction\ClientTransaction;
use App\Models\DeliveryMan\DeliveryMan;
use App\Models\ExpenseHead\ExpenseHead;
use App\Models\ExpenseSubhead\ExpenseSubHead;
use App\Models\Invoice\InvoicePosSale;
use App\Models\InvoiceReturnProduct\InvoiceReturnProduct;
use App\Models\PosSaleProducts\PosSaleProduct;
use App\Models\PosTransferProduct\PosTransferProduct;
use App\Models\Product\Purchase;
use App\Models\Product\PurchaseItems;
use App\Models\Product\PurchaseReturnItems;
use App\Models\Staff\Staff;
use App\Models\Supplier\Supplier;
use App\Models\SupplierTransaction\SupplierTransaction;
use App\Models\Transfer\WarehouseToBranch;
use App\Models\Transfer\WarehouseToBranchItems;
use App\Models\Warehouse\Warehouse;


if (!function_exists('isAPIRequest')) {

    function isAPIRequest()
    {
        $is_api_request = request()->route()->getPrefix() === 'api';
        if ($is_api_request) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('search_agent')) {

    function search_agent($q)
    {
        $agents = ExpenseHead::where('title', 'like', "%{$q}%")->get();

        $agent_array = array();
        foreach ($agents as $agent) {
            $label = $agent['title'] . '(' . $agent['expensehead_id'] . ')';
            $value = intval($agent['expensehead_id']);
            $agent_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $agent_array);
        echo json_encode($result);
        exit;
    }
}

if (!function_exists('search_supplier')) {

    function search_supplier($q)
    {
        $supplier = Supplier::where('supplier_name', 'like', "%{$q}%")->get();

        $supplier_array = array();
        foreach ($supplier as $supplier) {
            $label = $supplier['supplier_name'] . '(' . $supplier['supplier_id'] . ')';
            $value = intval($supplier['supplier_id']);
            $supplier_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $supplier_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('search_supplier_info')) {

    function search_supplier_info($q)
    {


        $supplier = Supplier::where('supplier_name', 'like', "%{$q}%")->get();

        // echo '<pre>';
        // print_r($clients);die;

        // join('purchase_items','purchase_items.purchase_id','=','purchases
        // .purchase_id' )->join('products', 'products.product_id','!=', 'purchase_items.purchase_product_id')->


        $supplier_array = array();
        foreach ($supplier as $supplier) {
            $label = $supplier['supplier_name'] . '(' . $supplier['supplier_id'] . ')';
            $value = intval($supplier['supplier_id']);
            $supplier_id = $supplier['supplier_id'];
            $supplier_detail = $supplier['supplier_name'];
            $supplier_array[] = array(
                "label" => $label, "value" => $value,
                'supplier_current_bal' => get_supplier_current_balance_by_supplier_id($supplier_id),
                'supplier_name' => $supplier_detail,

            );
        }
        $result = array('status' => 'ok', 'content' => $supplier_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('search_account_trans')) {

    function search_account_trans($q)
    {
        //  $clients = Accounts::where('accounts.account_name','like',"%{$q}%")->join('account_transactions', 'account_transactions.transaction_account_id','=', 'accounts.account_id')->get();
        $clients = Accounts::where('accounts.account_name', 'like', "%{$q}%")->get();

        $client_array = array();
        foreach ($clients as $client) {
            $label = $client['account_name'] . '(' . $client['account_id'] . ')';
            $value = intval($client['account_id']);
            $remain = intval(get_acoount_current_balance_only_by_account_id($client['account_id']));
            $client_array[] = array("label" => $label, "value" => $value, "remain" => $remain);
        }

        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('searchDeliveryMan')) {

    function searchDeliveryMan($q)
    {
        //  $clients = Accounts::where('accounts.account_name','like',"%{$q}%")->join('account_transactions', 'account_transactions.transaction_account_id','=', 'accounts.account_id')->get();
        $clients = DeliveryMan::where('accounts.account_name', 'like', "%{$q}%")->get();

        $client_array = array();
        foreach ($clients as $client) {
            $label = $client['account_name'] . '(' . $client['account_id'] . ')';
            $value = intval($client['account_id']);
            $remain = intval(get_acoount_current_balance_by_account_id($client['account_id']));
            $client_array[] = array("label" => $label, "value" => $value, "remain" => $remain);
        }

        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('searchProduct')) {

    function searchProduct($q)
    {


        $clients = Purchase::where('purchase_warehouse_id', $q)
            ->join('purchase_items', 'purchase_items.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'products.product_id', '=', 'purchase_items.purchase_product_id')

            ->get();

        // echo '<pre>';
        // print_r($clients);die;

        // join('purchase_items','purchase_items.purchase_id','=','purchases
        // .purchase_id' )->join('products', 'products.product_id','!=', 'purchase_items.purchase_product_id')->


        $client_array = array();
        foreach ($clients as $client) {
            $label = $client['product_name'] . '(' . $client['product_id'] . ')';
            $value = intval($client['purchase_items_id']);
            $item_id = $client['product_id'];
            $items_detail = $client['product_name'];
            $items_quantity = $client['purchase_product_quantity'];
            $items_price = $client['product_retail_price'];
            $client_array[] = array(
                "label" => $label, "value" => $value,
                'items_detail' => $items_detail,
                'items_quantity' => getWarehouseCurrentStocks($item_id),
                'items_price' => $items_price,
                'items_id' => $item_id,
            );
        }
        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}



/* Purchase Sell */

if (!function_exists('search_purchased_product')) {

    function search_purchased_product($q)
    {
        //  $clients = Accounts::where('accounts.account_name','like',"%{$q}%")->join('account_transactions', 'account_transactions.transaction_account_id','=', 'accounts.account_id')->get();
        // $clients = Purchase::where('purchase_warehouse_id', $q)->join('purchase_items', 'purchase_items.purchase_id','=', 'purchases.purchase_id')->join('products', 'products.product_id','=', 'purchase_items.purchase_product_id')->get();


        $transferd = WarehouseToBranch::where('branch_id', $q)->join('warehouse_to_branch_items', 'warehouse_to_branch_items.warehouse_to_branch_transfer_number', '=', 'warehouse_to_branches.warehouse_to_branch_transfer_number')->join('products', 'products.product_id', '=', 'warehouse_to_branch_items.transfer_product_id')->get();

        // echo '<pre>';
        // print_r($transferd);die;

        $transferd_array = array();
        foreach ($transferd as $transferd) {
            $label = $transferd['product_name'] . '(' . $transferd['transfer_product_id'] . ')';
            $value = intval($transferd['transfer_product_id']);
            $item_id = $transferd['product_id'];
            $items_detail = $transferd['product_name'];
            $items_quantity = getBrnachCurrentStocks(
                $transferd['warehouse_to_branch_transfer_number'],
                $transferd['product_id'],
                $q
            );
            $items_price = $transferd['product_retail_price'];
            $transferd_array[] = array(
                "label" => $label, "value" => $value,

                'items_detail' => $items_detail,
                'items_quantity' => $items_quantity,
                'items_price' => $items_price,
                'items_id' => $item_id,
            );
        }

        $result = array('status' => 'ok', 'content' => $transferd_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('search_product')) {

    function search_product($q)
    {
        //  $clients = Accounts::where('accounts.account_name','like',"%{$q}%")->join('account_transactions', 'account_transactions.transaction_account_id','=', 'accounts.account_id')->get();
        $products = App\Models\Product\Product::all();


        $product_array = array();
        foreach ($products as $row) {
            $label = $row['product_name'] . ' [' . $row['product_entry_id'] . ']';
            $value = intval($row['product_id']);
            $product_array[] = array("label" => $label, "value" => $value);
        }

        $result = array('status' => 'ok', 'content' => $product_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('search_client_wise_invoice')) {

    function search_client_wise_invoice($q)
    {

        $sales  = \App\Models\Invoice\InvoicePosSale::where('client_id', $q)->get();
        //         echo '<pre>';
        //         print_r($q);die;

        $result_array = array();
        foreach ($sales as $row) {
            $label = $row['invoice_no'];
            $value = intval($row['sale_id']);
            $result_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $result_array);
        echo json_encode($result);
        exit;
    }
}



if (!function_exists('search_deligate')) {

    function search_deligate($q)
    {
        $deligates = Deligate::where('deligate_name', 'like', "%{$q}%")->orWhere('deligate_entry_id', 'like', "%{$q}%")->orWhere('deligate_phone', 'like', "%{$q}%")->get();

        $deligate_array = array();
        foreach ($deligates as $deligate) {
            $label = $deligate['deligate_name'] . '(' . $deligate['deligate_id'] . ')';
            $value = intval($deligate['deligate_id']);
            $deligate_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $deligate_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('searchWarehouse')) {

    function searchWarehouse($q)
    {
        $warehouse = Warehouse::where('warehouse_name', 'like', "%{$q}%")->get();

        $warehouse_array = array();
        foreach ($warehouse as $warehouse) {
            $label = $warehouse['warehouse_name'] . '(' . $warehouse['warehouse_id'] . ')';
            $value = intval($warehouse['warehouse_id']);
            $warehouse_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $warehouse_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('BranchNameSearch')) {

    function BranchNameSearch($q)
    {
        $branch = Branch::where('branch_name', 'like', "%{$q}%")->get();

        $branch_array = array();
        foreach ($branch as $branch) {
            $label = $branch['branch_name'] . '(' . $branch['branch_id'] . ')';
            $value = intval($branch['branch_id']);
            $branch_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $branch_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('searchStaff')) {

    function searchStaff($q)
    {
        $staff = Staff::where('staff_name', 'like', "%{$q}%")->get();

        $staff_array = array();
        foreach ($staff as $staff) {
            $label = $staff['staff_name'] . '(' . $staff['staff_id'] . ')';
            $value = intval($staff['staff_id']);
            $staff_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $staff_array);
        echo json_encode($result);
        exit;
    }
}
if (!function_exists('searchClient')) {

    function searchClient($q)
    {
        $client = ClientClient::where('client_name', 'like', "%{$q}%")->get();

        $client_array = array();
        foreach ($client as $client) {
            $label = $client['client_name'];
            $value = intval($client['client_id']);

            $client_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('searchMoneyReceiptClient')) {

    function searchMoneyReceiptClient($q)
    {
        $client = ClientClient::where('client_name', 'like', "%{$q}%")->get();

        $client_array = array();
        foreach ($client as $client) {
            $clientBalance = get_client_current_balance_by_client_id($client['client_id']);
            $label = $client['client_name'] . '(' . $client['client_id'] . ')' . ' Due :' . $clientBalance;
            $value = intval($client['client_id']);
            $client_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('getClientName')) {

    function getClientName($client_id)
    {
        $client = ClientClient::where('client_id', $client_id)->get();
        return $client[0]->client_name;
    }
}


if (!function_exists('getBranchName')) {

    function getBranchName($branch_id)
    {
        $branch = Branch::where('branch_id', $branch_id)->get();
        return $branch[0]->branch_name;
    }
}


if (!function_exists('getStaffName')) {

    function getStaffName($staff_id)
    {
        $staff = Staff::where('staff_id', $staff_id)->get();
        return $staff[0]->staff_name;
    }
}



if (!function_exists('searchClient')) {

    function searchClient($q)
    {
        $client = ClientClient::where('client_name', 'like', "%{$q}%")->get();

        $client_array = array();
        foreach ($client as $client) {
            $label = $client['client_name'] . '(' . $client['client_id'] . ')';
            $value = intval($client['client_id']);
            $client_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('search_sponser')) {

    function search_sponser($q)
    {
        $sponsers = Sponsors::where('sponsor_name', 'like', "%{$q}%")->orWhere('sponsor_entry_id', 'like', "%{$q}%")->orWhere('sponsor_phone', 'like', "%{$q}%")->get();

        $sponser_array = array();
        foreach ($sponsers as $sponser) {
            $label = $sponser['sponsor_name'] . '(' . $sponser['sponsor_id'] . ')';
            $value = intval($sponser['sponsor_id']);
            $sponser_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $sponser_array);
        echo json_encode($result);
        exit;
    }
}



if (!function_exists('search_account')) {

    function search_account($q)
    {
        $account = Accounts::where('account_name', 'like', "%{$q}%")->orWhere('account_number', 'like', "%{$q}%")->orWhere('account_bank_name', 'like', "%{$q}%")->get();

        $sponser_array = array();
        foreach ($account as $acc) {
            // print_r($acc);
            $label = $acc['account_name'] . ' [' . $acc['account_number'] . ']';
            $value = intval($acc['account_id']);
            $acc_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $acc_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('search_client_full_information')) {

    function search_client_full_information($q)
    {
        $clients = Client::where('client_name', 'like', "%{$q}%")->orWhere('client_entry_id', 'like', "%{$q}%")->orWhere('client_phone', 'like', "%{$q}%")->get();

        $client_array = array();

        foreach ($clients as $client) {
            $label = $client['client_name'] . '(' . $client['client_entry_id'] . ')';
            $value = intval($client['client_id']);
            $client_array[] = array("label" => $label, "value" => $value, "client_name" => $client['client_name'], "client_phone" => $client['client_phone'], "client_address" => $client['client_address']);
        }
        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
}



if (!function_exists('search_account_full_data')) {

    function search_account_full_data($q)
    {
        $accounts = Accounts::where('account_name', 'like', "%{$q}%")->orWhere('account_number', 'like', "%{$q}%")->orWhere('account_bank_name', 'like', "%{$q}%")->get();

        $account_array = array();

        foreach ($accounts as $acc) {
            $label = $acc['account_name'] . '(' . $acc['account_number'] . ')';
            $value = intval($acc['account_id']);
            $account_array[] = array(
                "label" => $label,
                "value" => $value,
                "account_name" => $acc['account_name'],
                "account_bank_name" => $acc['account_bank_name'],
                "account_balance" => get_acoount_current_balance_by_account_id($acc['account_id'])
            );
        }
        $result = array('status' => 'ok', 'content' => $account_array);
        echo json_encode($result);
        exit;
    }
}


if (!function_exists('get_account_information_by_id')) {

    function get_account_information_by_id($id)
    {
        $account = Accounts::where('account_id', $id)->get();
        return $account;
    }
}


if (!function_exists('get_invoice_full_information')) {

    function get_invoice_full_information($q)
    {
        $invoice = \App\Models\Invoice\InvoicePosSale::where('sale_id', $q)->get();
        //        print_r($invoice);die;
        $result = array('status' => 'ok', 'content' => $invoice);
        echo json_encode($result);
        exit;
    }
}

if (!function_exists('get_client_current_balance_by_client_id')) {

    function get_client_current_balance_by_client_id($clientID)
    {
        $credit = ClientTransaction::whereClientTransactionClientId($clientID)->whereClientTransactionType('CREDIT')->sum('client_transaction_amount');
        $debit = ClientTransaction::whereClientTransactionClientId($clientID)->whereClientTransactionType('DEBIT')->sum('client_transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }
}





if (!function_exists('get_supplier_current_balance_by_supplier_id')) {

    function get_supplier_current_balance_by_supplier_id($supplierID)
    {
        $credit = SupplierTransaction::whereSupplierTransactionSupplierId($supplierID)->whereSupplierTransactionType('CREDIT')->sum('supplier_transaction_amount');
        $debit = SupplierTransaction::whereSupplierTransactionSupplierId($supplierID)->whereSupplierTransactionType('DEBIT')->sum('supplier_transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }
}


if (!function_exists('get_agent_current_balance_by_client_id')) {

    function get_agent_current_balance_by_agent_id($agentID)
    {
        $credit = AgentTransection::whereAgentTransactionClientId($agentID)->whereAgentTransactionType('CREDIT')->sum('agent_transaction_amount');
        $debit = AgentTransection::whereAgentTransactionClientId($agentID)->whereAgentTransactionType('DEBIT')->sum('agent_transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }
}


if (!function_exists('get_deligate_current_balance_by_deligate_id')) {

    function get_deligate_current_balance_by_deligate_id($deligateID)
    {
        $credit = DeligateTransaction::whereDeligateTransactionId($deligateID)->whereDeligateTransactionType('CREDIT')->sum('deligate_transaction_amount');
        $debit = DeligateTransaction::whereDeligateTransactionId($deligateID)->whereDeligateTransactionType('DEBIT')->sum('deligate_transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }
}

if (!function_exists('get_sponsor_current_balance_by_sponsor_id')) {

    function get_sponsor_current_balance_by_sponsor_id($sponsorID)
    {
        $credit = SponsorTransaction::whereSponsorTransactionId($sponsorID)->whereSponsorTransactionType('CREDIT')->sum('sponsor_transaction_amount');
        $debit = SponsorTransaction::whereSponsorTransactionId($sponsorID)->whereSponsorTransactionType('DEBIT')->sum('sponsor_transaction_amount');

        $currentBalance = intval($credit) - intval($debit);

        return $currentBalance;
    }
}

if (!function_exists('get_acoount_current_balance_by_account_id')) {

    function get_acoount_current_balance_by_account_id($accountID)
    {
        $credit = AccountTransaction::whereTransactionAccountId($accountID)->whereTransactionType('CREDIT')->sum('transaction_amount');
        $debit = AccountTransaction::whereTransactionAccountId($accountID)->whereTransactionType('DEBIT')->sum('transaction_amount');

        $currentBalance = intval($credit) - intval($debit);
        //if ($currentBalance < 0)
        //{
        //   $status = "Due";
        //}else if($currentBalance > 0){
        // $status = "Advance";   
        //}else if($currentBalance == 0){
        //   $status = "Balance";    
        //}


        //return $currentBalance;
        //];
        return $currentBalance;
        ////    return 1;
        //
    }
}


if (!function_exists('get_acoount_current_balance_only_by_account_id')) {

    function get_acoount_current_balance_only_by_account_id($accountID)
    {
        $credit = AccountTransaction::whereTransactionAccountId($accountID)->whereTransactionType('CREDIT')->sum('transaction_amount');
        $debit = AccountTransaction::whereTransactionAccountId($accountID)->whereTransactionType('DEBIT')->sum('transaction_amount');

        $currentBalance = intval($credit) - intval($debit);
        return $currentBalance;
    }
}

if (!function_exists('get_moeny_recipt_existance')) {

    function get_moeny_recipt_existance($invoice_no)
    {

        return   $result = MoneyReciept::whereMoneyRecieptHasDeleted('NO')->where('money_reciept_invoice_no', $invoice_no)->count();
    }
}

if (!function_exists('get_today_total_sale')) {

    function get_today_total_sale()
    {
        $today = date('Y-m-d');
        $today_sale = Invoice::whereInvoiceHasDeleted('NO')->whereInvoiceDate($today)->sum('invoice_net_total');

        $previous_day = date('Y-m-d', strtotime("-1 days"));
        $previous_day_sale = Invoice::whereInvoiceHasDeleted('NO')->whereInvoiceDate($previous_day)->sum('invoice_net_total');


        $amount_difference = intval($today_sale) - intval($previous_day_sale);

        if (intval($previous_day_sale) == 0) {
            $previous_day_sale = 1;
        }

        $statistics = ($amount_difference / $previous_day_sale) * 100;

        return array('today_sale' => $today_sale, 'previous_day_sale' => $previous_day_sale, 'statistics' => number_format($statistics, 2));
    }
}


/* find head subhead */
// if (!function_exists('get_sub_head')) {

//     function get_sub_head($subhead)
//     {
//         $subhead = Subhead::where('subhead_id', $subhead)->get();

//        return $subhead[0]->sub_head_name;

//     }
// }


if (!function_exists('get_head_id')) {

    function get_head_id($subhead_id)
    {
        $head = Subhead::where('subhead_id', $subhead_id)->get();

        return $head[0]->head_id;
    }
}


if (!function_exists('get_head_name')) {



    function get_head_name($subhead_id)
    {
        $head_id = Subhead::where('subhead_id', $subhead_id)->get();
        $head = HeadModel::where('head_id', $head_id)->get();
        return $head[0]->head_name;
    }
}

if (!function_exists('get_sub_head_name')) {

    function get_sub_head_name($subhead_id)
    {

        $head = Subhead::where('subhead_id', $subhead_id)->get();
        return $head[0]->sub_head_name;
    }
}



if (!function_exists('corresponding_account_ID')) {

    function corresponding_account_ID($invoice, $client)
    {
        $invoice =  Invoice::where('invoice_id', $invoice)->where('invoice_client_id', $client)->get();
        $client_id_get = $invoice[0]->invoice_client_id;


        $trans =  AccountTrasection::where('transaction_client_id', $client_id_get)->get();

        return $trans[0]->transaction_account_id;
    }
}

if (!function_exists('get_today_sales')) {

    function get_today_sales()
    {
        $invoiceTotalSales = Invoice::where('invoice_sales_date', Carbon::today()->toDateString())->sum('invoice_net_total');
        $invoiceTotalSalesAmount = 0;
        if ($invoiceTotalSales != "") {
            $invoiceTotalSalesAmount = $invoiceTotalSales;
        }
        return $invoiceTotalSalesAmount;
    }
}

if (!function_exists('get_today_expense')) {

    function get_today_expense()
    {
        $expense = Expense::where('expense_date', Carbon::today()->toDateString())->sum('expense_amount');
        if ($expense != "") {
            return $expense;
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_today_collection')) {

    function get_today_collection()
    {
        $moneyReceipt = MoneyReciept::where('money_reciept_payment_date', Carbon::today()->toDateString())->sum('money_reciept_total_amount');
        if ($moneyReceipt != "") {
            return $moneyReceipt;
        } else {
            return 0;
        }
    }
}

if (!function_exists('get_today_profit')) {

    function get_today_profit()
    {
        $invoiceTotalSalesProfit = Invoice::where('invoice_sales_date', Carbon::today()->toDateString())->sum('invoice_total_profit');
        $invoiceTotalSalesProfitAmount = 0;
        if ($invoiceTotalSalesProfit != "") {
            $invoiceTotalSalesProfitAmount = $invoiceTotalSalesProfit;
        }


        $expense = Expense::where('expense_date', Carbon::today()->toDateString())->sum('expense_amount');
        $expenseAmount = 0;
        if ($expense != "") {
            $expenseAmount = $expense;
        }

        $knitProfit = $invoiceTotalSalesProfitAmount - $expenseAmount;
        return $knitProfit;
    }
}

if (!function_exists('get_today_sales_profit')) {

    function get_today_sales_profit()
    {
        $invoiceTotalSalesProfit = Invoice::where('invoice_sales_date', Carbon::today()->toDateString())->sum('invoice_total_profit');
        $invoiceTotalSalesProfitAmount = 0;
        if ($invoiceTotalSalesProfit != "") {
            $invoiceTotalSalesProfitAmount = $invoiceTotalSalesProfit;
        }

        return $invoiceTotalSalesProfitAmount;
    }
}

if (!function_exists('get_invoice_payment')) {

    function get_invoice_payment($invoiceNo)
    {
        $moneyReceipt = MoneyReciept::whereMoneyRecieptInvoiceNo($invoiceNo)->sum('money_reciept_total_amount');
        if ($moneyReceipt != "") {
            return $moneyReceipt;
        } else {
            return 0;
        }
    }
}


if (!function_exists('getPaymentType')) {

    function getPaymentType($account)
    {
        $moneyReceipt = Accounts::where('account_id', $account)->get();
        if (isset($moneyReceipt[0])) {
            return $moneyReceipt[0]->account_type;
        } else {
            return 'DUE';
        }
    }
}

/* get expense head*/
if (!function_exists('getExpenseHead')) {

    function getExpenseHead($expense_head_id)
    {
        $expesne = ExpenseHead::where('expensehead_id', $expense_head_id)->get();
        if (isset($expesne[0])) {
            return $expesne[0]->title;
        }
    }
}
/* get expense subhead*/
if (!function_exists('getExpenseSubHead')) {

    function getExpenseSubHead($expense_sub_head_id)
    {
        $expesne = ExpenseSubHead::where('expense_sub_head_id', $expense_sub_head_id)->get();
        if (isset($expesne[0])) {
            return $expesne[0]->title;
        }
    }
}




if (!function_exists('getWareHouseNameHelp')) {

    function getWareHouseNameHelp($warehouse_id)
    {
        $warehouse = Warehouse::where('warehouse_id', $warehouse_id)->get();

        if (isset($warehouse[0])) {
            return $warehouse[0]->warehouse_name;
        }
    }
}



if (!function_exists('getCurrentStocks')) {

    function getCurrentStocks($product_id)
    {
        $sold_product = PosSaleProduct::where('product_id', $product_id)->sum('quantity');
        $purchased_product = PurchaseItems::where('purchase_product_id', $product_id)->sum('purchase_product_quantity');
        $transferd_product = PosTransferProduct::where('product_id', $product_id)->sum('quantity');
        $purchase_return = PurchaseReturnItems::where('purchase_product_id', $product_id)->sum('purchase_product_return_quantity');
        //$available_quantity = ($purchased_product - $sold_product)-$transferd_product;
        $available_quantity = (($purchased_product - $purchase_return) - $sold_product) - $transferd_product;
        return $available_quantity;
    }
}



if (!function_exists('getWarehouseCurrentStocks')) {

    function getWarehouseCurrentStocks($product_id)
    {
        $purchased_product = PurchaseItems::where('purchase_product_id', $product_id)->sum('purchase_product_quantity');
        $warehouse_to_branch = WarehouseToBranchItems::where('transfer_product_id', $product_id)->sum('transfer_product_amount');


        // $recieve_product = PosTransferProduct::where('product_id',$product_id)->where('to_warehouse',$warehouse_id)->sum('quantity');
        // $transfer_product = PosTransferProduct::where('product_id',$product_id)->where('from_warehouse', $warehouse_id)->sum('quantity');

        $transfer_product = PosTransferProduct::where('product_id', $product_id)->sum('quantity');



        $purchase_return = PurchaseReturnItems::where('purchase_product_id', $product_id)->sum('purchase_product_return_quantity');

        $total_transfer_and_return =  ($warehouse_to_branch + $transfer_product + $purchase_return);
        $final_stock = ($purchased_product + $transfer_product) - $total_transfer_and_return;
        return $final_stock;
    }
}


if (!function_exists('getBrnachCurrentStocks')) {

    function getBrnachCurrentStocks($transferid, $product_id, $branch_id)
    {



        $sold_product = PosSaleProduct::where('product_id', $product_id)->where('has_deleted', 'NO')->sum('quantity');
        $purchased_product = WarehouseToBranchItems::where('transfer_product_id', $product_id)->sum('transfer_product_amount');
        $sale_return = InvoiceReturnProduct::where('return_product_id', $product_id)->sum('return_product_quantity');

        return ($purchased_product - $sold_product) + $sale_return;
    }
}



if (!function_exists('getInvoiceCurrentStock')) {

    function getInvoiceCurrentStock($product_id, $sale_id)
    {



        $sold_product = PosSaleProduct::where('product_id', $product_id)->where('has_deleted', 'NO')->sum('quantity');
        $sale_return = InvoiceReturnProduct::where('return_product_id', $product_id)->sum('return_product_quantity');

        return ($sold_product - $sale_return);
    }
}

/* return account */


if (!function_exists('updateAccountTransactionLastBalance')) {

    function updateAccountTransactionLastBalance($transactionID, $accID)
    {
        $update_client_transection = AccountTransaction::where('transaction_id', $transactionID)->update([
            'transaction_last_balance' => get_acoount_current_balance_only_by_account_id($accID)
        ]);
        return $update_client_transection;
    }
}



if (!function_exists('getAttributesId')) {

    function getAttributesId($attribute_id)
    {
        $attrbute = Attribute::where('attributes_id', $attribute_id)->get();
        if (isset($attrbute[0])) {
            return $attrbute[0]->attributes_name;
        }
    }
}
