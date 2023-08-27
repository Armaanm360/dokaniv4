<?php

namespace App\Http\Controllers\InvoiceReturn;

use App\Http\Controllers\Controller;
use App\Models\Accounts\Accounts;
use App\Models\AccountTransaction\AccountTransaction;
use App\Models\ClientLedger\ClientLedger;
use App\Models\ClientTransaction\ClientTransaction;
use App\Models\DeliveryMan\DeliveryMan;
use App\Models\Invoice\InvoicePosSale;
use App\Models\InvoiceReturn\InvoiceReturn;
use App\Models\InvoiceReturnProduct\InvoiceReturnProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class invoiceReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data['invoice'] = InvoiceReturn::where('return_sale_is_delete','NO')
            ->join('invoice_return_products', 'invoice_return_products.return_sale_id', '=', 'invoice_returns.sale_return_id')
            ->join('invoice_pos_sales', 'invoice_pos_sales.sale_id', '=', 'invoice_returns.sale_id')
            ->join('pos_sale_products', 'pos_sale_products.pos_sale_id', '=', 'invoice_pos_sales.sale_id')
            ->join('products', 'products.product_id', '=', 'invoice_return_products.return_product_id')
            ->join('clients', 'clients.client_id', '=', 'invoice_pos_sales.client_id')
            ->join('staff', 'staff.staff_id', '=', 'invoice_pos_sales.staff_id')
            ->get();

            // echo '<pre>';
            // print_r($data['invoice']);die;
        return view('pages.invoice_return.list_invoice', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sale_return = new InvoiceReturn();
        $sale_return->sale_id = $request->sale_id;
        $sale_return->branch_id = $request->hidden_brnach_id;
        $sale_return->return_amount = $request->return_total;
        $sale_return->return_charge = $request->return_charge;
        //$sale_return->return_account = $request->account;
        $sale_return->return_quantity = $request->total_qty;
        $sale_return->return_sale_date = date('d-m-y');
        $sale_return->return_sale_created_by = Auth::user()->id;
        $sale_return->save();


        $return_id = $sale_return->sale_return_id;



        $invoice_sale = InvoicePosSale::where('sale_id',$request->sale_id)->update([
            'invoice_return' => 'YES'
        ]);

        foreach ($request->billing_rows as $rowBilling) {

            $productID = 'product_id_' . $rowBilling;
            $quantity  = 'return_quan_' . $rowBilling;


            $saleProduct = new InvoiceReturnProduct();
            $saleProduct['return_sale_id'] = $return_id;
            $saleProduct['return_product_id'] = $request->$productID;
            $saleProduct['return_product_quantity'] = $request->$quantity;
            $saleProduct->save();
        }


        $client_transaction = new ClientTransaction();
        $client_transaction->client_transaction_type = "CREDIT";
        $client_transaction->client_transaction_client_id = $request->hidden_client_id;
        $client_transaction->client_transaction_invoice_id = $request->sale_id;
        $client_transaction->client_transaction_amount = $request->return_total;
        $client_transaction->client_transaction_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
        $client_transaction->client_transaction_date = date("Y-m-d");
        $client_transaction->save();
        $client_tansaction_id = $client_transaction->client_transaction_id;
        $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
            'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->hidden_client_id)
        ]);

        $client_transaction = $client_transaction->client_transaction_id;

        $transaction['transaction_type'] = 'CREDIT';
        $transaction['transaction_account_id'] = $request->account;
        $transaction['transaction_amount'] = $request->return_charge;
        $transaction['transaction_client_id'] = $request->hidden_client_id;
        $transaction['client_transaction_id'] = $client_transaction;
        $transaction['sale_id'] = $request->sale_id;
        $transaction['transaction_note'] = 'INVOICE_SELL_RETURN';
        $transaction['transaction_date'] = date('Y-m-d');
        $transaction['transaction_method'] = getPaymentType($request->account); ;
        $transaction['transaction_for'] = 'INVOICE_SELL_RETURN';
        $transactionStatement = AccountTransaction::create($transaction);
        $account_current_balance = get_acoount_current_balance_by_account_id($request->account);
        $update_client_transection = AccountTransaction::find($transactionStatement->transaction_id)->update([
            'transaction_last_balance' => $account_current_balance
        ]);



        $client_ledger = new ClientLedger();
        $client_ledger->client_id = $request->hidden_client_id;
        $client_ledger->client_transaction_id = $client_transaction;
        $client_ledger->client_ledger_invoice_id = $request->sale_id;
        $client_ledger->client_ledger_type = 'INVOICE_SALE_RETURN';
        $client_ledger->client_ledger_status = true;
        $client_ledger->client_ledger_last_balance = get_client_current_balance_by_client_id($request->hidden_client_id);
        $client_ledger->client_ledger_date = date("Y-m-d");
        $client_ledger->client_ledger_create_date = date("Y-m-d");
        $client_ledger->client_ledger_dr = $request->return_total;
        $client_ledger->client_ledger_prepared_by = Auth::user()->id;

        $client_ledger->save();


        return response()->json([
            'sale_return' => $return_id
        ]);








        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pos'] = InvoiceReturn::where('sale_return_id', $id)->where('return_sale_is_delete', 'NO')
        ->join('invoice_return_products', 'invoice_return_products.return_sale_id', '=', 'invoice_returns.sale_return_id')
        ->join('invoice_pos_sales', 'invoice_pos_sales.sale_id','=', 'invoice_returns.sale_id')
        ->join('pos_sale_products', 'pos_sale_products.pos_sale_id','=', 'invoice_pos_sales.sale_id')
        ->join('products', 'products.product_id', '=', 'invoice_return_products.return_product_id')
        ->get();


        //$data['pos_sale_return'] = InvoicePosSale::where('sale_id', $id)->first();


      //  $data['return_client'] = InvoicePosSale::where('sale_id',$id)->join('clients','clients.client_id','=', 'invoice_pos_sales.client_id')->first();

        // echo '<pre>';
        // print_r($data['pos']);
        // die;
        return view('pages.invoice_return.show_invoice',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = InvoiceReturn::find($id);
        $invoice->return_sale_is_delete = "YES";
        $invoice->save();


        $client = ClientTransaction::where('client_transaction_invoice_id', $id)->update([
            'client_transaction_has_deleted' => "YES"
        ]);

        $account = AccountTransaction::where('sale_id', $id)->update([
            'transaction_has_deleted' => "YES"
        ]);
    }

    public function invoiceReturnSale($sale_id)
    {
        $data['accounts'] = Accounts::whereAccountHasDeleted('NO')->get();
        $data['delivery'] = DeliveryMan::all();
        $data['return'] = InvoicePosSale::where('sale_id',$sale_id)->get();


        $data['invoice'] = InvoicePosSale::where('sale_id',$sale_id)->join('pos_sale_products', 'pos_sale_products.pos_sale_id','=', 'invoice_pos_sales.sale_id')->get();

        // echo '<pre>';
        // print_r($data['invoice']);
        // die;
        return view('pages.invoice_return.create_return', $data);
    }

   public function getAccountInfo($account_id)
    {


        $account_type = Accounts::whereAccountHasDeleted('NO')->where('account_id', '=', $account_id)->first();
        $get_type = $account_type->account_type;

        $final = Accounts::where('account_type', $get_type)->get();

        $output = '';
        $output .= '';
        foreach ($final as $row) {
            $output .= '<option value="' . $row->account_id  . '" selected>' . $row->account_name . '</option>';
        }
        return $output;
    }
}
