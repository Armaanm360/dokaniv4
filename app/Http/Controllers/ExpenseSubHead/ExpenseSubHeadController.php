<?php

namespace App\Http\Controllers\ExpenseSubHead;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Http\Resources\ExpenseSubHeadResource;
use App\Models\ExpenseSubhead\ExpenseSubHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseSubHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $data['head'] = CommonResource::collection(ExpenseSubHead::where('sub_status', 1)->join('expense_heads', 'expense_heads.expensehead_id', '=', 'expense_sub_heads.expense_head_id')->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['head']], 200);
        } else {

            return view('pages.expensesubhead.list_expense_sub_head', $data);
        }




        // $data['head'] = ExpenseHead::where('status',1)->get();
        // return view('pages.expensehead.list_expense_head',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.expensesubhead.create_expense_sub_head');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $color = new ExpenseSubHead();
        $color->subtitle = $request->subtitle;
        $color->expense_head_id = $request->expense_head_id;
        if (isAPIRequest()) {
            $color->created_by =  $request->created_by;
        } else {
            $color->created_by =  Auth::user()->id;
        }

        $color->save();

        $data = new CommonResource($color);

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
        $data['head'] = ExpenseSubHead::where('expense_sub_head_id', $id)->first();
        return view('pages.expensesubhead.edit_expense_sub_head', $data);
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

        $item = ExpenseSubHead::findOrFail($id);

        $item->update($request->all());

        $data = new CommonResource($item);

        return response()->json(['success' => true, 'message' => 'Successfully Done', 'data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $item = ExpenseSubHead::find($id);
        $item->sub_status = 0;
        $item->save();
        $data = new CommonResource($item);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
    }
}
