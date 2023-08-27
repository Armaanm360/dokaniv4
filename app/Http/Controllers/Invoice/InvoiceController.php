<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Accounts\Accounts;
use App\Models\AccountTransaction\AccountTransaction;
use App\Models\ClientLedger\ClientLedger;
use App\Models\ClientTransaction\ClientTransaction;
use App\Models\DeliveryMan\DeliveryMan;
use App\Models\DeliveryVehicle\DeliveryVehicle;
use App\Models\Invoice\InvoicePosSale;
use App\Models\PosSaleProducts\PosSaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        $data = InvoicePosSale::where('invoice_has_deleted', 'NO')->join('staff', 'staff.staff_id', '=', 'invoice_pos_sales.staff_id')->join('clients', 'clients.client_id', '=', 'invoice_pos_sales.client_id')->latest('invoice_pos_sales.sale_id')->get();


        if (isAPIRequest()) {
            return response()->json(['success' => true, 'message' => 'Successfull', 'data' => $data], 200);
        }




        return view('pages.invoice.list_invoice', $data);
    }

    public function today_invoices()
    {
        $today = date("Y-m-d");
        $data['invoice'] = InvoicePosSale::join('staff', 'staff.staff_id', '=', 'invoice_pos_sales.staff_id')->join('clients', 'clients.client_id', '=', 'invoice_pos_sales.client_id')->where('invoice_pos_sales.sales_date', $today)->latest('invoice_pos_sales.sale_id')->get();

        return view('pages.invoice.today_list_invoice', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['accounts'] = Accounts::whereAccountHasDeleted('NO')->get();
        $data['delivery'] = DeliveryMan::all();
        return view('pages.invoice.create_invoice', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // $data = [
        //     'expense_head_id' => 'required|integer',
        //     'expense_sub_head_id' => 'required|integer',
        //     'expense_account' => 'required|integer',
        //     'expense_amount'  => 'required|integer'
        // ];

        // $validator = Validator::make($request->all(),$data);



        $invoice_sale = new InvoicePosSale();
        $invoice_sale->client_id = $request->hidden_client_id;
        $invoice_sale->customer_type = $request->customer_type;
        $invoice_sale->invoice_no = $request->invoice_no;
        $invoice_sale->branch_id = $request->hidden_branch_id;
        $invoice_sale->sales_form = $request->hidden_staff_id;
        $invoice_sale->staff_id = $request->hidden_staff_id;
        $invoice_sale->invoice_date = date('Y-m-d');
        $invoice_sale->sales_date = date('Y-m-d');
        $invoice_sale->subTotal = $request->invoice_subtotal;
        $invoice_sale->product_discount = $request->product_discount;
        $invoice_sale->vat_rate = 7.50;
        $invoice_sale->vat_amount = $request->vat_amount;
        $invoice_sale->overall_discount = $request->overall_discount;
        $invoice_sale->grand_total = $request->grand_total;
        $invoice_sale->payment_type = $request->payment_type;
        $invoice_sale->account = $request->account;
        $invoice_sale->total_paying = $request->paid_amount;
        $invoice_sale->change = $request->changed_amount;
        $invoice_sale->invoice_create_date = date('Y-m-d');
        if (isAPIRequest()) {
            $invoice_sale->invoice_created_by =  $request->created_by;
        } else {
            $invoice_sale->invoice_created_by =  Auth::user()->id;
        }
        $invoice_sale->save();

        //InvoicePosSale::where('sale_id',$invoice_sale->sale_id)->update(['invoice_no', $invoice_sale->sale_id]);

        $sale_id = $invoice_sale->sale_id;

        $billing_rows = [1];
        foreach ($request->billing_rows as $rowBilling) {

            $productID = 'product_' . $rowBilling;
            $quantity  = 'item_qty_' . $rowBilling;
            $price  = 'item_unit_price_' . $rowBilling;
            $with_discount  = 'with_discount_' . $rowBilling;
            $discount  = 'item_discount_' . $rowBilling;


            $saleProduct = new PosSaleProduct();
            $saleProduct['pos_sale_id'] = $sale_id;
            $saleProduct['product_id'] = $request->$productID;
            $saleProduct['quantity'] = $request->$quantity;
            $saleProduct['price'] = $request->$price;
            $saleProduct['subTotal'] = $request->$with_discount;
            $saleProduct['discount_amount'] = $request->$discount;
            $saleProduct['sales_date'] = date('Y-m-d');
            $saleProduct['create_date'] = date('Y-m-d');
            if (isAPIRequest()) {
                $saleProduct['created_by'] =  $request->created_by;
            } else {
                $saleProduct['created_by'] =  Auth::user()->id;
            }
            $saleProduct->save();
        }








        $paid_amount = $request->paid_amount;
        $changed_amount = $request->changed_amount;

        if ($paid_amount > 0) {
            $client_transaction = new ClientTransaction();
            $client_transaction->client_transaction_type = "CREDIT";
            $client_transaction->client_transaction_client_id = $request->hidden_client_id;
            $client_transaction->client_transaction_invoice_id = $sale_id;
            $client_transaction->client_transaction_amount = $request->paid_amount;
            $client_transaction->client_transaction_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
            $client_transaction->client_transaction_date = date("Y-m-d");
            $client_transaction->save();
            $client_tansaction_id = $client_transaction->client_transaction_id;
            $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
                'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->hidden_client_id)
            ]);
        }

        if ($changed_amount <  1) {
            $client_transaction = new ClientTransaction();
            $client_transaction->client_transaction_type = "DEBIT";
            $client_transaction->client_transaction_client_id = $request->hidden_client_id;
            $client_transaction->client_transaction_invoice_id = $sale_id;
            $client_transaction->client_transaction_amount = $request->grand_total;
            $client_transaction->client_transaction_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
            $client_transaction->client_transaction_date = date("Y-m-d");
            $client_transaction->save();
            $client_tansaction_id = $client_transaction->client_transaction_id;



            $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
                'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->hidden_client_id)
            ]);
        }
        $client_transaction = $client_transaction->client_transaction_id;

        $transaction['transaction_type'] = 'CREDIT';
        $transaction['transaction_account_id'] = $request->account;
        $transaction['transaction_amount'] = $request->grand_total;
        $transaction['transaction_client_id'] = $request->hidden_client_id;
        $transaction['client_transaction_id'] = $client_transaction;
        $transaction['sale_id'] = $sale_id;
        $transaction['transaction_note'] = 'INVOICE_SELL';
        $transaction['transaction_date'] = date('Y-m-d');
        $transaction['transaction_method'] = $request->payment_type;
        $transaction['transaction_for'] = 'INVOICE_SELL';
        $transactionStatement = AccountTransaction::create($transaction);
        $account_current_balance = get_acoount_current_balance_by_account_id($request->account);



        $update_client_transection = AccountTransaction::find($transactionStatement->transaction_id)->update([
            'transaction_last_balance' => $account_current_balance
        ]);

        $client_ledger = new ClientLedger();
        $client_ledger->client_id = $request->hidden_client_id;
        $client_ledger->client_transaction_id = $client_transaction;
        $client_ledger->client_ledger_invoice_id = $request->sale_id;
        $client_ledger->client_ledger_type = 'SALE';
        $client_ledger->client_ledger_status = true;
        $client_ledger->client_ledger_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
        $client_ledger->client_ledger_date = date("Y-m-d");
        $client_ledger->client_ledger_create_date = date("Y-m-d");
        $client_ledger->client_ledger_dr = $request->invoice_net_total;
        if (isAPIRequest()) {
            $client_ledger->client_ledger_prepared_by = $request->created_by;
        } else {
            $client_ledger->client_ledger_prepared_by = Auth::user()->id;
        }

        $client_ledger->save();



        $data = new CommonResource($invoice_sale);

        return response()->json(['success' => true, 'message' => 'Successfully Done', 'data' => $data, 'sale_id' => $data->sale_id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pos'] = InvoicePosSale::where('sale_id', $id)->join('pos_sale_products', 'pos_sale_products.pos_sale_id', '=', 'invoice_pos_sales.sale_id')->join('products', 'products.product_id', '=', 'pos_sale_products.product_id')->get();


        $data['pos_sale'] = InvoicePosSale::where('sale_id', $id)->first();


        $data['client'] = InvoicePosSale::where('sale_id', $id)->join('clients', 'clients.client_id', '=', 'invoice_pos_sales.client_id')->first();

        // echo '<pre>';
        // print_r($data['pos']);
        // die;

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['pos']], 200);
        } else {

            return view('pages.invoice.show_invoice', $data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['accounts'] = Accounts::whereAccountHasDeleted('NO')->get();
        $data['delivery'] = DeliveryMan::all();

        $data['invoice_edit'] = InvoicePosSale::join('pos_sale_products', 'pos_sale_products.pos_sale_id', '=', 'invoice_pos_sales.sale_id')->where('sale_id', $id)->get();

        // echo '<pre>';
        // print_r($data['invoice_edit']);
        // die;

        return view('pages.invoice.edit_invoice', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        PosSaleProduct::where('pos_sale_id', $request->sale_id)->delete();



        $invoice_sale = InvoicePosSale::where('sale_id', $request->sale_id)->update([
            'client_id' => $request->hidden_client_id,
            'customer_type' => $request->customer_type,
            'branch_id' => $request->hidden_branch_id,
            'sales_form' => $request->hidden_staff_id,
            'staff_id' => $request->hidden_staff_id,
            'invoice_date' =>  date('Y-m-d'),
            'sales_date' =>  date('Y-m-d'),
            'subTotal' =>  $request->invoice_subtotal,
            'vat_rate' =>  7.50,
            'vat_amount' => $request->vat_amount,
            'overall_discount' => $request->overall_discount,
            'grand_total' => $request->grand_total,
            'account' => $request->account_id,
            'total_paying' => $request->paid_amount,
            'change' => $request->changed_amount,
            'invoice_create_date' => date('Y-m-d'),

        ]);








        // $sale_id = $invoice_sale->sale_id;

        foreach ($request->billing_rows as $rowBilling) {

            $productID = 'product_id_' . $rowBilling;
            $quantity  = 'qty_get_' . $rowBilling;
            $price  = 'item_price_' . $rowBilling;
            $discount  = 'item_discount_' . $rowBilling;
            $sub_total  = 'qty_' . $rowBilling;

            $saleProduct = new PosSaleProduct();
            $saleProduct['pos_sale_id'] = $request->sale_id;
            $saleProduct['product_id'] = $request->$productID;
            $saleProduct['quantity'] = $request->$quantity;
            $saleProduct['price'] = $request->$price;
            $saleProduct['subTotal'] = $request->$sub_total;
            $saleProduct['discount_amount'] = $request->$discount;
            $saleProduct['sales_date'] = date('Y-m-d');
            $saleProduct['create_date'] = date('Y-m-d');
            $saleProduct['created_by'] = Auth::user()->id;
            $saleProduct->save();
        }






        $paid_amount = $request->paid_amount;
        $changed_amount = $request->changed_amount;

        if ($paid_amount > 0) {
            $client_transaction = new ClientTransaction();
            $client_transaction->client_transaction_type = "CREDIT";
            $client_transaction->client_transaction_client_id = $request->hidden_client_id;
            $client_transaction->client_transaction_invoice_id = $request->sale_id;
            $client_transaction->client_transaction_amount = $request->paid_amount;
            $client_transaction->client_transaction_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
            $client_transaction->client_transaction_date = date("Y-m-d");
            $client_transaction->save();
            $client_tansaction_id = $client_transaction->client_transaction_id;
            $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
                'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->hidden_client_id)
            ]);
        }

        if ($changed_amount <  1) {
            $client_transaction = new ClientTransaction();
            $client_transaction->client_transaction_type = "DEBIT";
            $client_transaction->client_transaction_client_id = $request->hidden_client_id;
            $client_transaction->client_transaction_invoice_id = $request->sale_id;
            $client_transaction->client_transaction_amount = $request->grand_total;
            $client_transaction->client_transaction_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
            $client_transaction->client_transaction_date = date("Y-m-d");
            $client_transaction->save();
            $client_tansaction_id = $client_transaction->client_transaction_id;



            $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
                'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->hidden_client_id)
            ]);
        }
        $client_transaction = $client_transaction->client_transaction_id;

        $transaction['transaction_type'] = 'CREDIT';
        $transaction['transaction_account_id'] = $request->account;
        $transaction['transaction_amount'] = $request->grand_total;
        $transaction['transaction_client_id'] = $request->hidden_client_id;
        $transaction['client_transaction_id'] = $client_transaction;
        $transaction['sale_id'] = $request->sale_id;
        $transaction['transaction_note'] = 'INVOICE_UPDATE';
        $transaction['transaction_date'] = date('Y-m-d');
        $transaction['transaction_method'] = $request->payment_type;
        $transaction['transaction_for'] = 'INVOICE_UPDATE';
        $transactionStatement = AccountTransaction::create($transaction);
        $account_current_balance = get_acoount_current_balance_by_account_id($request->account);



        $update_client_transection = AccountTransaction::find($transactionStatement->transaction_id)->update([
            'transaction_last_balance' => $account_current_balance
        ]);

        $client_ledger = new ClientLedger();
        $client_ledger->client_id = $request->hidden_client_id;
        $client_ledger->client_transaction_id = $client_transaction;
        $client_ledger->client_ledger_invoice_id = $request->sale_id;
        $client_ledger->client_ledger_type = 'SALE';
        $client_ledger->client_ledger_status = true;
        $client_ledger->client_ledger_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
        $client_ledger->client_ledger_date = date("Y-m-d");
        $client_ledger->client_ledger_create_date = date("Y-m-d");
        $client_ledger->client_ledger_dr = $request->invoice_net_total;
        $client_ledger->client_ledger_prepared_by = Auth::user()->id;

        $client_ledger->save();



        return response()->json([
            'sale_id' => $invoice_sale->sale_id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = InvoicePosSale::find($id);
        $invoice->invoice_has_deleted = "YES";
        $invoice->save();


        $client = ClientTransaction::where('client_transaction_invoice_id', $id)->update([
            'client_transaction_has_deleted' => "YES"
        ]);

        $account = AccountTransaction::where('sale_id', $id)->update([
            'transaction_has_deleted' => "YES"
        ]);
    }


    public function getDeliveryVehicle($id)
    {
        $man = DeliveryMan::where('delivery_men_id', $id)->get();
        $vehicle = DeliveryVehicle::where('delivery_vehicles_id', $man[0]->delivery_men_vehicle)->get();
        return $vehicle[0]->delivery_vehicles_name;
    }

    public function paymentType($account_type)
    {

        $fromuser = Accounts::whereAccountHasDeleted('NO')->where('account_type', '=', $account_type)->get();

        $output = '';
        $output .= '';
        foreach ($fromuser as $row) {
            $output .= '<option value="' . $row->account_id  . '" selected>' . $row->account_name . '</option>';
        }
        return $output;
    }




    // public function invoiceReturn($sale_id)
    // {

    // }
}
