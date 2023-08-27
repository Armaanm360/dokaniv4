<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use Illuminate\Http\Request;
use App\Models\Accounts\Accounts as Accounts;
use App\Models\AccountTransaction\AccountTransaction;
use Validator;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        echo 1;die;


        $data['list'] = CommonResource::collection(Accounts::whereAccountHasDeleted('NO')->get());



        // echo "<pre>";
        // print_r(gettype($data['list']));
        if (isAPIRequest()) {


            //   get_acoount_current_balance_by_account_id()
            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['list']], 200);
        } else {

            return view('pages.account.account_list', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.account.create_account');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // print_r($request->all());die;







        $request->validate([
            'account_name' => 'required',
            'account_number' => 'required|unique:accounts'
        ]);

        $account = new Accounts();
        $account->account_name = $request->account_name;
        $account->account_number = $request->account_number;
        $account->account_type = $request->account_type;
        $account->account_bank_name = $request->account_bank_name;
        $account->account_branch_name = $request->account_branch_name;
        $account->account_status = 1;
        $account->account_create_date = date('Y-m-d');

        $account->save();

        $data = new CommonResource($account);

        return response()->json(['success' => true, 'message' => 'Successfully Done', 'data' => $data], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['data'] = Accounts::find($id);
        return view('pages.account.view_account', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['data'] = Accounts::whereAccountId($id)->get();
        return view('pages.account.edit_account', $data);
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



        $item = Accounts::findOrFail($id);

        $item->update($request->all());

        $data = new CommonResource($item);

        return response()->json([
            'success' => true, 'message' => 'Successfully Done', 'data' => $data
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Accounts::find($id);
        $item->account_has_deleted = "YES";
        $item->save();
        $data = new CommonResource($item);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
    }





    public function getAccount($account_id)
    {
        // $account_last_bal = AccountTrasection::where('transaction_account_id',$account_id)->get();
        // return $account_last_bal[0]->transaction_last_balance;

        return get_acoount_current_balance_by_account_id($account_id);
    }

    public function create_opening_balance()
    {
        return view('pages.account.add_account_opening_balance');
    }

    public function non_invoice_income()
    {
        //    $data['companies'] = Compan    
        return view('pages.account.add_non_invoice_income');
    }

    public function account_statement(Request $request, $id)
    {
        //     $data['transactions'] = AccountTransaction::where('transaction_account_id',$id)->get();    
        // //    echo "<pre>"; print_r($data['transactions']);die;
        //     return view('pages.account.account_statement',$data);


        $data['transactions'] = CommonResource::collection(AccountTransaction::where('transaction_account_id', $id)->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['transactions']], 200);
        } else {

            return view('pages.account.account_statement', $data);
        }
    }

    public function balance_statement(Request $request)
    {

        $accounts = Accounts::whereAccountHasDeleted("NO")->paginate();
        $updatedItems = $accounts->items();
        foreach ($updatedItems as $row) {
            $row->account_balance = get_acoount_current_balance_by_account_id($row->account_id);
            //              $row->account_balance = $acc_balance['balance'];
        }

        $is_api_request = $request->route()->getPrefix() === 'api';
        if ($is_api_request) {
            //          print_r($updatedItems);die;
            //          $accounts->setCollection($updatedItems);
            return \App\Http\Resources\AccountsResource::collection($updatedItems);
        } else {
            $data['data'] = $updatedItems;
            return view('pages.account.balance_statement', $data);
        }
    }

    public function save_non_invoice_income(Request $request)
    {
        $data = [
            'non_invoice_account_id' => 'required',
            'non_invoice_amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $data);

        $accountTransaction = [
            'transaction_account_id' => $request->non_invoice_account_id,
            'transaction_type' => 'CREDIT',
            'transaction_amount' => $request->non_invoice_amount,
            'transaction_date' => $request->non_invoice_date,
            'transaction_create_date' => date('Y-m-d')
        ];
        $accountTransactionData = AccountTransaction::create($accountTransaction);
        updateAccountTransactionLastBalance($accountTransactionData['transaction_id'], $request->non_invoice_account_id);

        $clientTransaction = [
            'client_transaction_type' => "DEBIT",
            'client_transaction_client_id' => $request->non_invoice_client_id,
            'client_transaction_amount' => $request->non_invoice_amount,
            'client_transaction_date' => $request->non_invoice_date
        ];
        $clientTransactionData = \App\Models\ClientTransaction\ClientTransaction::create($clientTransaction);

        //        print_r($clientTransaction);


        $is_api_request = $request->route()->getPrefix() === 'api';
        if ($is_api_request) {

            if ($validator->fails()) {

                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();

                $validated['non_invoice_date'] = $request->non_invoice_date;
                $validated['non_invoice_account_transaction_id'] = $accountTransactionData['transaction_id'];
                $validated['non_invoice_client_transaction_id'] = $clientTransactionData['client_transaction_id'];
                $validated['non_invoice_note'] = $request->non_invoice_note;
                $validated['non_invoice_created_by'] = $request->created_by;

                $statement = \App\Models\NonInvoiceIncome\NonInvoiceIncome::create($validated);

                return new \App\Http\Resources\NonInvoiceIncome\NonInvoiceIncomeResource($statement);
            }
        } else {


            $validated = $validator->validated();
            unset($validated["client_name"]);
            $validated['non_invoice_date'] = $request->non_invoice_date;
            $validated['non_invoice_account_transaction_id'] = $accountTransactionData['transaction_id'];
            $validated['non_invoice_client_transaction_id'] = $clientTransactionData['client_transaction_id'];
            $validated['non_invoice_note'] = $accountTransactionData->non_invoice_note;
            $validated['non_invoice_created_by'] = \Illuminate\Support\Facades\Auth::user()->id;
            //print_r($clientTransactionData['client_transaction_id']);
            $statement = \App\Models\NonInvoiceIncome\NonInvoiceIncome::create($validated);
            return ['status' => 'okay'];
        }
    }
}
