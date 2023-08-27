<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountTransactionsResource;
use App\Http\Resources\CommonResource;
use App\Http\Resources\ExpenseResource;
use App\Models\Accounts\Accounts;
use App\Models\AccountTransaction\AccountTransaction;
use App\Models\Expense\Expense;
use App\Models\ExpenseHead\ExpenseHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $is_api_request = Request()->route()->getPrefix() === 'api';
        if ($is_api_request) {
            $books = Expense::join('expense_heads', 'expense_heads.expensehead_id', '=', 'expenses.expense_head_id')
                ->join('expense_sub_heads', 'expense_sub_heads.expense_sub_head_id', '=', 'expenses.expense_sub_head_id')
                ->join('accounts', 'accounts.account_id', '=', 'expenses.expense_account')
                ->where('expenses.is_deleted', 'NO')->get();
            return response()->json(['success' => true, 'message' => 'Successfull', 'data' => $books], 200);
        } else {
            $data['expense'] = Expense::latest()->get();
            return view('pages.expenses.list_expenses', $data);
        }
        return view('pages.expenses.list_expenses');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['head'] = Expense::where('status', 1)->get();
        return view('pages.expenses.create_expenses', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'expense_head_id' => 'required|integer',
            'expense_sub_head_id' => 'required|integer',
            'expense_account' => 'required|integer',
            'created_by' => 'required|integer',
        ]);



        $expense = new Expense();
        $expense->expense_head_id = $request->expense_head_id;
        $expense->expense_sub_head_id = $request->expense_sub_head_id;
        $expense->expense_account = $request->expense_account;
        $expense->expense_amount = $request->expense_amount;
        $expense->expense_date = date('Y-m-d');
        if (isAPIRequest()) {
            $expense->created_by =  $request->created_by;
        } else {
            $expense->created_by =  Auth::user()->id;
        }

        $expense->save();


        $accounts = new Accounts();
        $accounts->transaction_type = 'CREDIT';
        $accounts->transaction_account_id = $request->expense_account;
        $accounts->transaction_amount = $request->expense_amount;
        $accounts->transaction_note = $request->note;
        $accounts->transaction_date = date('Y-m-d');
        $accounts->transaction_method = 'BANK';
        $accounts->transaction_for = 'EXPENSE';

        $data = new CommonResource($expense);


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
