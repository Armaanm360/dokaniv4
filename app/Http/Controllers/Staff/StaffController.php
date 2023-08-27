<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Staff\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $staffList = Staff::where('staff_status',1)->get();
        // return view('pages.staff.list_staff',compact('staffList'));


        $data['staffList'] = Staff::where('staff_status', 1)->get();


        if (isAPIRequest()) {

            return response()->json(['success' => true, 'message' => 'Successfully Done', 'data' => $data['staffList']], 200);
        } else {

            return view('pages.staff.list_staff', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.staff.create_staff');
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
            'staff_name' => 'required',
        ]);



        $staff = new Staff();
        $staff->staff_name = $request->staff_name;
        $staff->staff_entry_id = $request->staff_entry_id;
        if (isAPIRequest()) {
            $staff->staff_created_by = $request->created_by;
        } else {
            $staff->staff_created_by =  Auth::user()->id;
        }

        $staff->save();

        $data = new CommonResource($staff);

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
        $data['data'] = Staff::where('staff_id',$id)->first();
        return view('pages.staff.edit_staff',$data);
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

        $item = Staff::findOrFail($id);

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

        $item = Staff::find($id);
        $item->staff_status = 0;
        $item->staff_is_deleted = "YES";
        $item->save();
        $data = new CommonResource($item);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
    }

    public function staffPdf($id)
    {
        

        $data['data'] = Staff::where('staff_id',$id)->first();
        $pdf = PDF::loadView('pages.staff.pdf', $data);
  
       // return view('pdf');
       return $pdf->download('dokani.pdf');
    }
}