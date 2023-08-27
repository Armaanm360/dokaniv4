<?php

namespace App\Http\Controllers\AccountTransactions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AccountTransaction\AccountTransaction;
use App\Http\Resources\AccountTransactionsResource;

class AccountTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    
    public function save_opening_balance(Request $request) {

        $data = [
            'transaction_account_id' => 'required',
            'transaction_amount' => 'required',
            'transaction_note' => 'required',
            'transaction_method' => 'required',
        ];
        $validator = Validator::make($request->all(), $data);

        $is_api_request = $request->route()->getPrefix() === 'api';
        if ($is_api_request) {
            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();

                $validated['transaction_for'] = "OPENING_BALANCE";
                $validated['transaction_type'] = "CREDIT";
                $validated['transaction_opening_balance'] = "YES";
                $validated['transaction_date'] = date("Y-m-d");
                $validated['transaction_create_date'] = date("Y-m-d");

                $statement = AccountTransaction::create($validated);
                
                updateAccountTransactionLastBalance($statement['transaction_id'],$request->transaction_account_id);
//                 print_r($statement);die;
                return new AccountTransactionsResource($statement);
            }
        } else {


            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();
                $validated['transaction_for'] = "OPENING_BALANCE";
                $validated['transaction_type'] = "CREDIT";
                $validated['transaction_opening_balance'] = "YES";
                $validated['transaction_date'] = date("Y-m-d");
                $validated['transaction_create_date'] = date("Y-m-d");
                $statement = AccountTransaction::create($validated);
                updateAccountTransactionLastBalance($statement['transaction_id'],$request->transaction_account_id);
                return ['status' => 'okay','data'=>$statement];
            }
        }
    }

}
