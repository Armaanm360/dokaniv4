<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['warehouseList'] = CommonResource::collection(Warehouse::where('warehouse_status',1)->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['warehouseList']], 200);
        } else {

            return view('pages.warehouse.list_warehouse', $data);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.warehouse.create_warehouse');
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
            'warehouse_name' => 'required',
        ]);


        $warehouse = new Warehouse();
        $warehouse->warehouse_name = $request->warehouse_name;
        $warehouse->warehouse_entry_id = $request->warehouse_entry_id;
        $warehouse->warehouse_phone_number = $request->warehouse_phone_number;
        $warehouse->warehouse_address = $request->warehouse_address;
        $warehouse->created_at = date("Y/m/d");
        if (isAPIRequest()) {
            $warehouse->warehouse_created_by =  $request->created_by;
        } else {
            $warehouse->warehouse_created_by =  Auth::user()->id;
        }

        $warehouse->save();

        $data = new CommonResource($warehouse);

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
        $data['data'] = Warehouse::where('warehouse_id',$id)->first();
        return view('pages.warehouse.edit_warehouse',$data);
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

        $item = Warehouse::findOrFail($id);

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


        $item = Warehouse::find($id);
        $item->warehouse_status = 0;
        $item->save();
        $data = new CommonResource($item);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
    }

    public function warehouseSearch(Request $request)
    {
        $warehouses = Warehouse::where('warehouse_name','like',"%{$request->q}%")->orWhere('warehouse_entry_id','like',"%{$request->q}%")->orWhere('warehouse_phone_number','like',"%{$request->q}%")->get();
        // print_r($clients);
        // die;
        $warehouse_array = array();
        foreach ($warehouses as $warehouse) {
            $label = $warehouse['warehouse_name'] . '(' . $warehouse['warehouse_entry_id'] . ')';
            $value = intval($warehouse['warehouse_id']);
            $warehouse_array[] = array("label" => $label, "value" => $value);
        }
        $result = array('status' => 'ok', 'content' => $warehouse_array);
        echo json_encode($result);
        exit;
    }
}
