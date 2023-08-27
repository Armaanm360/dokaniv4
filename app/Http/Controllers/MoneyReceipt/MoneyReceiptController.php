<?php

namespace App\Http\Controllers\MoneyReceipt;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use Illuminate\Http\Request;
use App\Models\MoneyReceipt\MoneyReceipt;
use App\Models\ClientTransaction\ClientTransaction;
use App\Models\AccountTransaction\AccountTransaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice\InvoicePosSale;

class MoneyReceiptController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data['supplierList'] = CommonResource::collection(MoneyReceipt::whereMoneyReceiptHasDeleted('NO')
            ->join('clients', 'money_receipt.money_receipt_client_id', '=', 'clients.client_id')
            ->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['supplierList']], 200);
        } else {

            return view('pages.money_receipt.list_money_receipt', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['voucherNo'] = MoneyReceipt::generate_vouchar_no();
        //        print_r($data['voucherNo']);
        //        die;
        return view('pages.money_receipt.create_money_receipt', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [
            'money_receipt_invoice_no' => 'required',
            'money_receipt_account_id' => 'required',
            'money_receipt_amount' => 'required',
            'money_receipt_date' => 'required'
        ];

        $validator = Validator::make($request->all(), $data);


        if (!$validator->fails()) {

            $sale = \App\Models\Invoice\InvoicePosSale::where('invoice_no', '=', $request->money_receipt_invoice_no)->get();

            $total_paying = $sale[0]->total_paying + $request->money_receipt_amount;
            $update_pos_sale = \App\Models\Invoice\InvoicePosSale::where('invoice_no', '=', $request->money_receipt_invoice_no)->update([
                'total_paid' => $total_paying
            ]);

            $is_api_request = $request->route()->getPrefix() === 'api';
            if ($is_api_request) {
                $moneyReceiptAmount = intval($request->money_receipt_amount) - intval($request->money_receipt_discount);



                $clientTransaction = [
                    'client_transaction_type' => 'CREDIT',
                    'client_transaction_client_id' => $request->money_receipt_client_id,
                    'client_transaction_account_id' => $request->money_receipt_account_id,
                    'client_transaction_amount' => $request->money_receipt_amount,
                    'client_transaction_date' => date("Y-m-d"),
                    'client_transaction_create_date' => date("Y-m-d")
                ];

                $clientTransactionData = ClientTransaction::create($clientTransaction);

                $client_tansaction_id = $clientTransactionData->client_transaction_id;

                $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
                    'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id)
                ]);

                $accountTransaction = [
                    'transaction_type' => "CREDIT",
                    'transaction_account_id' => $request->money_receipt_account_id,
                    'transaction_client_id' => $request->money_receipt_client_id,
                    'transaction_amount' => $moneyReceiptAmount,
                    'transaction_date' => $request->money_receipt_date,
                    'transaction_create_date' => date("Y-m-d")
                ];

                $accountTransactionData = AccountTransaction::create($accountTransaction);

                $account_tansaction_id = $accountTransactionData->transaction_id;

                $update_account_transection = AccountTransaction::find($account_tansaction_id)->update([
                    'transaction_last_balance' => get_acoount_current_balance_by_account_id($request->money_receipt_account_id)
                ]);

                $moneyReciept = [
                    'money_receipt_voucher_no' => $request->money_receipt_voucher_no,
                    'money_receipt_invoice_no' => $request->money_receipt_invoice_no,
                    'money_receipt_client_id' => $request->money_receipt_client_id,
                    'money_receipt_payment_to' => "CLIENT",
                    'money_receipt_total_amount' => $moneyReceiptAmount,
                    'money_receipt_total_discount' => $request->money_receipt_discount,
                    'money_receipt_payment_type' => "CLIENT_PAYMENT",
                    'money_receipt_payment_date' => $request->money_receipt_date,
                    'money_receipt_note' => $request->money_receipt_note,
                    'money_receipt_payment_status' => 1,
                    'money_receipt_client_transaction_id' => $client_tansaction_id,
                    'money_receipt_account_transaction_id' => $account_tansaction_id,
                    'money_receipt_created_by' => 2
                ];

                $moneyRecieptData = MoneyReceipt::create($moneyReciept);

                $clientLedger = [
                    'client_id' => $request->money_receipt_client_id,
                    'client_transaction_id' => $client_tansaction_id,
                    'client_ledger_type' => 'CLIENT_PAYMENT',
                    'client_ledger_status' => true,
                    'client_ledger_money_receipt_id' => $moneyRecieptData->money_receipt_id,
                    'client_ledger_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id),
                    'client_ledger_date' => $request->money_receipt_date,
                    'client_ledger_create_date' => date("Y-m-d"),
                    'client_ledger_prepared_by' => 2,
                    'client_ledger_cr' => $request->money_receipt_amount
                ];

                $clientLedgerData = \App\Models\ClientLedger\ClientLedger::create($clientLedger);
                return new \App\Http\Resources\MoneyReceipt\MoneyReceiptResource($moneyRecieptData);
                //             $data = ['status' => 'okay', 'data' => $moneyRecieptData->money_receipt_id];
                //            return $data;

            } else {

                $moneyReceiptAmount = intval($request->money_receipt_amount) - intval($request->money_receipt_discount);
                //echo $moneyReceiptAmount;
                $clientTransaction = [
                    'client_transaction_type' => 'CREDIT',
                    'client_transaction_client_id' => $request->money_receipt_client_id,
                    'client_transaction_account_id' => $request->money_receipt_account_id,
                    'client_transaction_amount' => $request->money_receipt_amount,
                    'client_transaction_date' => $request->money_receipt_date,
                    'client_transaction_create_date' => date("Y-m-d")
                ];

                $clientTransactionData = ClientTransaction::create($clientTransaction);

                $client_tansaction_id = $clientTransactionData->client_transaction_id;

                $update_client_transection = ClientTransaction::find($client_tansaction_id)->update([
                    'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id)
                ]);

                $accountTransaction = [
                    'transaction_type' => "CREDIT",
                    'transaction_account_id' => $request->money_receipt_account_id,
                    'transaction_client_id' => $request->money_receipt_client_id,
                    'transaction_amount' => $moneyReceiptAmount,
                    'transaction_date' => $request->money_receipt_date,
                    'transaction_create_date' => date("Y-m-d")
                ];

                $accountTransactionData = AccountTransaction::create($accountTransaction);

                $account_tansaction_id = $accountTransactionData->transaction_id;

                // print_r($account_tansaction_id);

                $update_account_transection = AccountTransaction::find($account_tansaction_id)->update([
                    'transaction_last_balance' => get_acoount_current_balance_by_account_id($request->money_receipt_account_id)
                ]);

                $moneyReciept = [
                    'money_receipt_voucher_no' => $request->money_receipt_voucher_no,
                    'money_receipt_invoice_no' => $request->money_receipt_invoice_no,
                    'money_receipt_client_id' => $request->money_receipt_client_id,
                    'money_receipt_payment_to' => "CLIENT",
                    'money_receipt_total_amount' => $moneyReceiptAmount,
                    'money_receipt_total_discount' => $request->money_receipt_discount,
                    'money_receipt_payment_type' => "CLIENT_PAYMENT",
                    'money_receipt_payment_date' => $request->money_receipt_date,
                    'money_receipt_note' => $request->money_receipt_note,
                    'money_receipt_payment_status' => 1,
                    'money_receipt_client_transaction_id' => $client_tansaction_id,
                    'money_receipt_account_transaction_id' => $account_tansaction_id,
                    'money_receipt_created_by' => \Illuminate\Support\Facades\Auth::user()->id
                ];

                $moneyRecieptData = MoneyReceipt::create($moneyReciept);

                $clientLedger = [
                    'client_id' => $request->money_receipt_client_id,
                    'client_transaction_id' => $client_tansaction_id,
                    'client_ledger_type' => 'CLIENT_PAYMENT',
                    'client_ledger_status' => true,
                    'client_ledger_money_receipt_id' => $moneyRecieptData->money_receipt_id,
                    'client_ledger_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id),
                    'client_ledger_date' => $request->money_receipt_date,
                    'client_ledger_create_date' => date("Y-m-d"),
                    'client_ledger_prepared_by' => Auth::user()->id,
                    'client_ledger_cr' => $request->money_receipt_amount
                ];

                $clientLedgerData = \App\Models\ClientLedger\ClientLedger::create($clientLedger);

                $data = ['status' => 'okay', 'moneyReceiptId' => $moneyRecieptData->money_receipt_id];
                return $data;
            }
        } else {
            return ['errors' => $validator->errors()->first()];
        }

        //        if ($is_api_request) {
        //            if ($validator->fails()) {
        //                return ['errors' => $validator->errors()->first()];
        //            } else {
        //                $moneyRecieptData = MoneyReceipt::create($moneyReciept);
        //                return new \App\Http\Resources\MoneyReceipt\MoneyReceiptResource($moneyRecieptData);
        //            }
        //        } else {
        //            $data = ['status' => 'okay', 'moneyReceiptId' => $moneyRecieptData->id];
        //            return $data;
        //        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $invoiceData['MoneyReceiptData'] = MoneyReceipt::whereMoneyReceiptId($id)->get()[0];
        $invoiceData['invoiceData'] = InvoicePosSale::whereInvoiceNo($invoiceData['MoneyReceiptData']->money_receipt_invoice_no)->get()[0];

        //      echo "<pre>";  print_r($invoiceData); die;


        // $data['MoneyReceiptData'] = CommonResource::collection(MoneyReceipt::whereMoneyReceiptId($id)->get()[0]);
        // $invoiceData['invoiceData'] = InvoicePosSale::whereInvoiceNo($invoiceData['MoneyReceiptData']->money_receipt_invoice_no)->get()[0];

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $invoiceData], 200);
        } else {

            return view('pages.money_receipt.view_money_receipt', $invoiceData);
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
        $invoiceData['invoiceData'] = InvoicePosSale::whereInvoiceNo($id)
            ->join('clients', 'invoice_pos_sales.client_id', '=', 'clients.client_id')
            ->get()[0];

        $invoiceData['moneyReceiptData'] = MoneyReceipt::whereMoneyReceiptInvoiceNo($id)->get()[0];

        //        print_r($invoiceData['moneyReceiptData']); 

        return view('pages.money_receipt.edit_money_receipt', $invoiceData);
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


        $data = [
            'money_receipt_invoice_no' => 'required',
            'money_receipt_account_id' => 'required',
            'money_receipt_amount' => 'required',
            'money_receipt_date' => 'required'
        ];

        $validator = Validator::make($request->all(), $data);


        if (!$validator->fails()) {

            $moneyReceipt = MoneyReceipt::where("money_receipt_id", $request->money_receipt_id)->get();

            $sale = \App\Models\Invoice\InvoicePosSale::where('invoice_no', '=', $moneyReceipt[0]->money_receipt_invoice_no)->get();
            if ($request->money_receipt_amount > $request->money_receipt_old_amount) {
                $difference = $request->money_receipt_amount - $request->money_receipt_old_amount;
                $total_paying = $sale[0]->total_paid - $difference;
            } else if ($request->money_receipt_old_amount < $request->money_receipt_amount) {
                $difference = $request->money_receipt_amount - $request->money_receipt_old_amount;
                $total_paying = $sale[0]->total_paid + $difference;
            }

            //                           print_r($total_paying);die;
            $update_pos_sale = \App\Models\Invoice\InvoicePosSale::where('invoice_no', '=', $moneyReceipt[0]->money_receipt_invoice_no)->update([
                'total_paid' => $total_paying
            ]);

            $is_api_request = $request->route()->getPrefix() === 'api';
            if ($is_api_request) {
                $moneyReceiptAmount = intval($request->money_receipt_amount) - intval($request->money_receipt_discount);



                $clientTransaction = [
                    'client_transaction_type' => 'CREDIT',
                    'client_transaction_client_id' => $request->money_receipt_client_id,
                    'client_transaction_account_id' => $request->money_receipt_account_id,
                    'client_transaction_amount' => $request->money_receipt_amount,
                    'client_transaction_date' => $request->money_receipt_date,
                    'client_transaction_create_date' => date("Y-m-d")
                ];

                $clientTransactionData = ClientTransaction::where('client_transaction_id', $request->money_receipt_client_transaction_id)->update($clientTransaction);

                //                        $client_tansaction_id = $clientTransactionData->client_transaction_id;

                $update_client_transection = ClientTransaction::find($request->money_receipt_client_transaction_id)->update([
                    'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id)
                ]);

                $accountTransaction = [
                    'transaction_type' => "CREDIT",
                    'transaction_account_id' => $request->money_receipt_account_id,
                    'transaction_client_id' => $request->money_receipt_client_id,
                    'transaction_amount' => $moneyReceiptAmount,
                    'transaction_date' => $request->money_receipt_date,
                    'transaction_create_date' => date("Y-m-d")
                ];

                $accountTransactionData = AccountTransaction::where('transaction_id', $request->money_receipt_account_transaction_id)->update($accountTransaction);

                //            $account_tansaction_id = $accountTransactionData->transaction_id;

                $update_account_transection = AccountTransaction::find($request->money_receipt_account_transaction_id)->update([
                    'transaction_last_balance' => get_acoount_current_balance_by_account_id($request->money_receipt_account_id)
                ]);

                $moneyReciept = [
                    'money_receipt_voucher_no' => $request->money_receipt_voucher_no,
                    'money_receipt_invoice_no' => $request->money_receipt_invoice_no,
                    'money_receipt_client_id' => $request->money_receipt_client_id,
                    'money_receipt_payment_to' => "CLIENT",
                    'money_receipt_total_amount' => $moneyReceiptAmount,
                    'money_receipt_total_discount' => $request->money_receipt_discount,
                    'money_receipt_payment_type' => "CLIENT_PAYMENT",
                    'money_receipt_payment_date' => $request->money_receipt_date,
                    'money_receipt_note' => $request->money_receipt_note,
                    'money_receipt_payment_status' => 1,
                    'money_receipt_client_transaction_id' => $request->money_receipt_client_transaction_id,
                    'money_receipt_account_transaction_id' => $request->money_receipt_account_transaction_id,
                    'money_receipt_created_by' => \Illuminate\Support\Facades\Auth::user()->id
                ];

                $moneyRecieptData = MoneyReceipt::where('money_receipt_id', $request->money_receipt_id)->update($moneyReciept);

                $clientLedger = [
                    'client_id' => $request->money_receipt_client_id,
                    'client_transaction_id' => $request->money_receipt_client_transaction_id,
                    'client_ledger_type' => 'CLIENT_PAYMENT_UPDATE',
                    'client_ledger_status' => true,
                    'client_ledger_money_receipt_id' => $request->money_receipt_id,
                    'client_ledger_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id),
                    'client_ledger_date' => $request->money_receipt_date,
                    'client_ledger_create_date' => date("Y-m-d"),
                    'client_ledger_prepared_by' => Auth::user()->id,
                    'client_ledger_cr' => $request->money_receipt_amount
                ];

                $clientLedgerData = \App\Models\ClientLedger\ClientLedger::create($clientLedger);

                return new \App\Http\Resources\MoneyReceipt\MoneyReceiptResource($moneyRecieptData);
                //             $data = ['status' => 'okay', 'data' => $moneyRecieptData->money_receipt_id];
                //            return $data;

            } else {

                $moneyReceiptAmount = intval($request->money_receipt_amount) - intval($request->money_receipt_discount);
                //echo $moneyReceiptAmount;
                $clientTransaction = [
                    'client_transaction_type' => 'CREDIT',
                    'client_transaction_client_id' => $request->money_receipt_client_id,
                    'client_transaction_account_id' => $request->money_receipt_account_id,
                    'client_transaction_amount' => $request->money_receipt_amount,
                    'client_transaction_date' => $request->money_receipt_date,
                    'client_transaction_create_date' => date("Y-m-d")
                ];

                $clientTransactionData = ClientTransaction::where('client_transaction_id', $request->money_receipt_client_transaction_id)->update($clientTransaction);

                //            $client_tansaction_id = $clientTransactionData->client_transaction_id;

                $update_client_transection = ClientTransaction::find($request->money_receipt_client_transaction_id)->update([
                    'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id)
                ]);

                $accountTransaction = [
                    'transaction_type' => "CREDIT",
                    'transaction_account_id' => $request->money_receipt_account_id,
                    'transaction_client_id' => $request->money_receipt_client_id,
                    'transaction_amount' => $moneyReceiptAmount,
                    'transaction_date' => $request->money_receipt_date,
                    'transaction_create_date' => date("Y-m-d")
                ];

                $accountTransactionData = AccountTransaction::where('transaction_id', $request->money_receipt_account_transaction_id)->update($accountTransaction);

                //            $account_tansaction_id = $accountTransactionData->transaction_id;

                $update_account_transection = AccountTransaction::find($request->money_receipt_account_transaction_id)->update([
                    'transaction_last_balance' => get_acoount_current_balance_by_account_id($request->money_receipt_account_id)
                ]);

                $moneyReciept = [
                    'money_receipt_voucher_no' => $request->money_receipt_voucher_no,
                    'money_receipt_invoice_no' => $request->money_receipt_invoice_no,
                    'money_receipt_client_id' => $request->money_receipt_client_id,
                    'money_receipt_payment_to' => "CLIENT",
                    'money_receipt_total_amount' => $moneyReceiptAmount,
                    'money_receipt_total_discount' => $request->money_receipt_discount,
                    'money_receipt_payment_type' => "CLIENT_PAYMENT",
                    'money_receipt_payment_date' => $request->money_receipt_date,
                    'money_receipt_note' => $request->money_receipt_note,
                    'money_receipt_payment_status' => 1,
                    'money_receipt_client_transaction_id' => $request->money_receipt_client_transaction_id,
                    'money_receipt_account_transaction_id' => $request->money_receipt_account_transaction_id,
                    'money_receipt_created_by' => \Illuminate\Support\Facades\Auth::user()->id
                ];

                $moneyRecieptData = MoneyReceipt::where('money_receipt_id', $request->money_receipt_id)->update($moneyReciept);

                $clientLedger = [
                    'client_id' => $request->money_receipt_client_id,
                    'client_transaction_id' => $request->money_receipt_client_transaction_id,
                    'client_ledger_type' => 'CLIENT_PAYMENT_UPDATE',
                    'client_ledger_status' => true,
                    'client_ledger_money_receipt_id' => $request->money_receipt_id,
                    'client_ledger_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id),
                    'client_ledger_date' => $request->money_receipt_date,
                    'client_ledger_create_date' => date("Y-m-d"),
                    'client_ledger_prepared_by' => Auth::user()->id,
                    'client_ledger_cr' => $request->money_receipt_amount
                ];

                $clientLedgerData = \App\Models\ClientLedger\ClientLedger::create($clientLedger);

                $data = ['status' => 'okay', 'moneyReceiptId' => $request->money_receipt_id];
                return $data;
            }
        } else {
            return ['errors' => $validator->errors()->first()];
        }

        //            $request->validate([
        //            'money_receipt_invoice_no' => 'required',
        //            'money_receipt_account_id' => 'required',
        //            'money_receipt_amount' => 'required',
        //            'money_receipt_date' => 'required',
        //        ]);
        //
        //        $moneyReceiptAmount = intval($request->money_receipt_amount) - intval($request->money_receipt_discount);
        //            
        //            $moneyReciept = MoneyReciept::find($id);




        //            $moneyReciept->money_receipt_voucher_no = $request->money_receipt_voucher_no;
        //            $moneyReciept->money_receipt_invoice_no = $request->money_receipt_invoice_no;
        //            $moneyReciept->money_receipt_client_id = $request->money_receipt_client_id;
        //            $moneyReciept->money_receipt_payment_to = "CLIENT";
        //            $moneyReciept->money_receipt_total_amount = $request->money_receipt_amount;
        //            $moneyReciept->money_receipt_total_discount = $request->money_receipt_discount;
        //            $moneyReciept->money_receipt_payment_type = "CLIENT_PAYMENT";
        //            $moneyReciept->money_receipt_payment_date = $request->money_receipt_date;
        //            $moneyReciept->money_receipt_note = $request->money_receipt_note;
        //            $moneyReciept->money_receipt_payment_status = 1;
        //            $moneyReciept->money_receipt_created_by = \Illuminate\Support\Facades\Auth::user()->id;

        //            ClientTransaction::whereClientTransactionId($request->money_receipt_client_transaction_id)->update([
        //            
        //            "client_transaction_type" =>"CREDIT",
        //            "client_transaction_client_id"=>$request->money_receipt_client_id,
        //            "client_transaction_amount"=>$request->money_receipt_amount,
        //            "client_transaction_date"=>$request->money_receipt_date,
        ////            "client_transaction_update_date"=>date("Y-m-d")
        //        ]);

        //             $client_transaction = ClientTransaction::find($request->money_receipt_client_transaction_id);
        //      
        //            $client_transaction->client_transaction_type = 'CREDIT';
        //      
        //        
        //        $client_transaction->client_transaction_client_id = $request->money_receipt_client_id;
        //        $client_transaction->client_transaction_amount = $request->money_receipt_amount;
        //        $client_transaction->client_transaction_date = $request->money_receipt_date;
        //        $client_transaction->client_transaction_create_date = date("Y-m-d");
        //        $client_transaction->save();



        //        $client_tansaction_id = $client_transaction->client_transaction_id ;



        //        $update_client_transection = ClientTransaction::find($request->money_receipt_client_transaction_id)->update([
        //            'client_transaction_last_balance' => get_client_current_balance_by_client_id($request->money_receipt_client_id)
        //        ]);
        //        
        //        AccountTrasection::find($request->money_receipt_account_transaction_id)->update([
        //            
        //            "transaction_type" =>"CREDIT",
        //            "transaction_account_id"=>$request->money_receipt_account_id,
        //            "transaction_client_id"=>$request->money_receipt_client_id,
        //            "client_transaction_amount"=>$moneyReceiptAmount,
        //            "client_transaction_date"=>$request->money_receipt_date,
        ////            "client_transaction_update_date"=>date("Y-m-d")
        //        ]);



        //        $accountTransaction = AccountTrasection::find($request->money_receipt_account_transaction_id);
        //        
        //        $accountTransaction->transaction_type = "CREDIT";
        //        $accountTransaction->transaction_account_id = $request->money_receipt_account_id;
        //        $accountTransaction->transaction_client_id = $request->money_receipt_client_id;
        //        $accountTransaction->transaction_amount = $request->money_receipt_amount;
        //        $accountTransaction->transaction_date = $request->money_receipt_date;
        //        $accountTransaction->transaction_create_date = date("Y-m-d");
        //        
        //        $accountTransaction->save();
        //        
        //        $account_tansaction_id = $accountTransaction->transaction_id  ;

        // print_r($account_tansaction_id);

        //         $update_account_transection = AccountTrasection::find($request->money_receipt_account_transaction_id)->update([
        //            'transaction_last_balance' => get_acoount_current_balance_by_account_id($request->money_receipt_account_id)
        //        ]);

        //          MoneyReciept::whereMoneyRecieptId($id)->update([
        //            'money_receipt_voucher_no' => $request->money_receipt_voucher_no,
        //            'money_receipt_invoice_no' => $request->money_receipt_invoice_no,
        //            'money_receipt_client_id' => $request->money_receipt_client_id,
        //            'money_receipt_payment_to' =>  "CLIENT",
        //            'money_receipt_total_amount' => $moneyReceiptAmount,
        //            'money_receipt_total_discount' => $request->money_receipt_discount,
        //            'money_receipt_payment_type' => "CLIENT_PAYMENT",
        //            'money_receipt_payment_date' => $request->money_receipt_date,
        //            'money_receipt_note' => $request->money_receipt_note,
        //            'money_receipt_updated_by' => \Illuminate\Support\Facades\Auth::user()->id,
        //            'money_receipt_client_transaction_id' => $request->money_receipt_client_transaction_id,
        //            'money_receipt_account_transaction_id' => $request->money_receipt_account_transaction_id,
        //            
        //        ]);

        //        $moneyReciept->money_receipt_client_transaction_id = $client_tansaction_id;
        //        $moneyReciept->money_receipt_account_transaction_id = $account_tansaction_id;
        //        $moneyReciept->save();

        //        $client_ledger = new ClientLedger();
        //        $client_ledger->client_id = $request->money_receipt_client_id;
        //        $client_ledger->client_transaction_id = $request->money_receipt_client_transaction_id;
        //        $client_ledger->client_ledger_type = 'CLIENT_PAYMENT_UPDATE';
        //        $client_ledger->client_ledger_status = true;
        //        $client_ledger->client_ledger_last_balance = get_client_current_balance_by_client_id($request->money_receipt_client_id);
        //        $client_ledger->client_ledger_date = $request->money_receipt_date;
        //        $client_ledger->client_ledger_create_date = date("Y-m-d");
        //        $client_ledger->client_ledger_prepared_by = Auth::user()->id;
        //          
        //        $client_ledger->client_ledger_cr = $request->money_receipt_amount;
        //        $client_ledger->save();


        //       $data = ['status'=>'okay','moneyReceiptId'=>$id];
        //       return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $moneyReceipt = MoneyReceipt::where("money_receipt_id", $id)->get();
        //      $data = $moneyReceipt;


        $sale = \App\Models\Invoice\InvoicePosSale::where('invoice_no', '=', $moneyReceipt[0]->money_receipt_invoice_no)->get();

        $total_paying = $sale[0]->total_paid - $moneyReceipt[0]->money_receipt_total_amount;
        //                           print_r($total_paying);die;
        $update_pos_sale = \App\Models\Invoice\InvoicePosSale::where('invoice_no', '=', $moneyReceipt[0]->money_receipt_invoice_no)->update([
            'total_paid' => $total_paying
        ]);


        ClientTransaction::where("client_transaction_id", $moneyReceipt[0]->money_receipt_client_transaction_id)->update([
            "client_transaction_has_deleted" => "YES"
        ]);

        AccountTransaction::where("transaction_id", $moneyReceipt[0]->money_receipt_account_transaction_id)->update([
            "transaction_has_deleted" => "YES"
        ]);


        MoneyReceipt::where("money_receipt_id", $id)->update([
            "money_receipt_has_deleted" => "YES"
        ]);

        $data = ['status' => 'okay'];
        return $data;
    }
}
