<?php

namespace App\Http\Controllers\Branch;


use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Branch\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['branchList'] = CommonResource::collection(Branch::where('branch_is_deleted', "NO")->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['branchList']], 200);
        } else {

            return view('pages.branch.list_branch', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.branch.create_branch');
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
            'branch_name' => 'required',
        ]);


        $branch = new Branch();
        $branch->branch_name = $request->branch_name;
        $branch->branch_entry_id = $request->branch_entry_id;
        $branch->branch_phone_number = $request->branch_phone_number;
        $branch->branch_address = $request->branch_address;
        if (isAPIRequest()) {
            $branch->branch_created_by =  $request->created_by;
        } else {
            $branch->branch_created_by =  Auth::user()->id;
        }

        $branch->save();

        $data = new CommonResource($branch);

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
        $data['data'] = Branch::where('branch_id',$id)->first();
        return view('pages.branch.edit_branch',$data);
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

        $item = Branch::findOrFail($id);

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


        $item = Branch::find($id);
        $item->branch_is_deleted = "YES";
        $item->save();
        $data = new CommonResource($item);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
    }

    public function branchSearch(Request $request)
    {
        $branch = Branch::where('branch_name','like',"%{$request->q}%")->orWhere('branch_entry_id','like',"%{$request->q}%")->orWhere('branch_phone_number','like',"%{$request->q}%")->get();
        // print_r($clients);
        // die;
        $branch_array = array();
        foreach ($branch as $branch) {
            $label = $branch['branch_name'] . '(' . $branch['branch_entry_id'] . ')';
            $value = intval($branch['branch_id']);
            $branch_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $branch_array);
        echo json_encode($result);
        exit;
    }
}
