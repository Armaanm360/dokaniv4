<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Account\AccountTransferResource;
use App\Http\Resources\CommonResource;
use App\Models\Accounts\AccountTransfer;
use App\Models\AccountTransaction\AccountTransaction;
use Illuminate\Support\Facades\Validator;

class AccountTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data'] = CommonResource::collection(AccountTransfer::whereHasDeleted('NO')->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['data']], 200);
        } else {

            return view('pages.account_transfer.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    return view('pages.account_transfer.create');
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
            'account_from' => 'required',
            'account_to' => 'required',
            'amount' => 'required'
        ];
        $validator = Validator::make($request->all(), $data);
        
        $accountTransactionFrom = [
            'transaction_account_id' => $request->account_from,
            'transaction_type' => 'DEBIT',
            'transaction_amount' => $request->amount,
            'transaction_date' => date('Y-m-d'),
            'transaction_create_date' => date('Y-m-d')
        ];
        
       $accFromTr = AccountTransaction::create($accountTransactionFrom);
        
        updateAccountTransactionLastBalance($accFromTr['transaction_id'],$request->account_from);
        
        $accountTransactionTo = [
            'transaction_account_id' => $request->account_to,
            'transaction_type' => 'CREDIT',
            'transaction_amount' => $request->amount,
            'transaction_date' => date('Y-m-d'),
            'transaction_create_date' => date('Y-m-d')
        ];
        
        $aacTr = AccountTransaction::create($accountTransactionTo);
        
        updateAccountTransactionLastBalance($aacTr['transaction_id'],$request->account_to);

        $is_api_request = $request->route()->getPrefix() === 'api';
        if ($is_api_request) {
            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();

                $validated['date'] = date('Y-m-d');
//                $validated['created_by'] = \Illuminate\Support\Facades\Auth::user()->id;
                $validated['status'] = 1;
                
                $statement = AccountTransfer::create($validated);
                return new AccountTransferResource($statement);
            }
        } else {
            
            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {
                $validated = $validator->validated();

                $validated['date'] = date('Y-m-d');
                $validated['created_by'] = \Illuminate\Support\Facades\Auth::user()->id;
                $validated['status'] = 1;
                
                $statement = AccountTransfer::create($validated);
                return ['status' => 'okay'];
            }
        }
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
}
