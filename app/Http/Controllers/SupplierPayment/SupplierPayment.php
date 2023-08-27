<?php

namespace App\Http\Controllers\SupplierPayment;

use App\Http\Controllers\Controller;
use App\Models\AccountTransaction\AccountTransaction;
use App\Models\Supplier\Supplier;
use App\Models\SupplierTransaction\SupplierTransaction;
use Illuminate\Http\Request;

class SupplierPayment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['supplier'] = SupplierTransaction::join('suppliers', 'suppliers.supplier_id', '=', 'supplier_transactions.supplier_transaction_supplier_id')->latest('supplier_transactions.supplier_transaction_id')->get();
        return view('pages.supplier-payment.list_suppliers_payment',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.supplier-payment.create_supplier_payment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier_transaction = new SupplierTransaction();
        $supplier_transaction->supplier_transaction_type = "DEBIT";
        $supplier_transaction->supplier_transaction_supplier_id = $request->hiddenSupplierId;
        $supplier_transaction->supplier_transaction_amount = $request->amount;
        $supplier_transaction->supplier_transaction_last_balance = get_client_current_balance_by_client_id($request->hiddenSupplierId);
        $supplier_transaction->supplier_transaction_date = date("Y-m-d");
        $supplier_transaction->save();


        $supplier_transaction_id = $supplier_transaction->supplier_transaction_id;
        $update_client_transection = SupplierTransaction::find($supplier_transaction_id)->update([
            'supplier_transaction_last_balance' => get_supplier_current_balance_by_supplier_id($request->hiddenSupplierId)
        ]);



        $transaction['transaction_type'] = 'DEBIT';
        $transaction['transaction_account_id'] = $request->hiddenAccId;
        $transaction['transaction_amount'] = $request->amount;
        $transaction['transaction_client_id'] = $request->hiddenSupplierId;
        $transaction['client_transaction_id'] = $supplier_transaction_id;
        $transaction['transaction_note'] = $request->note;
        $transaction['transaction_date'] = date('Y-m-d');
        $transaction['transaction_for'] = 'SUPPLIER_PAYMENT';
        $transactionStatement = AccountTransaction::create($transaction);
        $account_current_balance = get_acoount_current_balance_only_by_account_id($request->account);


        $update_client_transection = AccountTransaction::find($transactionStatement->transaction_id)->update([
            'transaction_last_balance' => $account_current_balance
        ]);

        return response()->json([
            'supplier_transaction' => $supplier_transaction_id
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
        //$supp = Supplier::join('supplier_transactions', 'supplier_transactions.supplier_transaction_supplier_id','=', 'suppliers.supplier_id')->get();
        $data['supply'] = SupplierTransaction::where('supplier_transaction_id', $id)
        ->join('suppliers', 'suppliers.supplier_id','=','supplier_transactions.supplier_transaction_supplier_id')
        ->get();


        // echo '<pre>';
        // print_r($data['supply']);
        // die;


        return view('pages.supplier-payment.show_payment',$data);
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
        //
    }
}
