<?php

namespace App\Http\Controllers\DeliveryVehicle;

use App\Http\Controllers\Controller;
use App\Models\DeliveryVehicle\DeliveryVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DeliveryVehicleResource;
use Illuminate\Support\Facades\Validator;

class DeliveryVehicleController extends Controller
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
            $delivery_vehicles_list = DeliveryVehicle::where("delivery_vehicles_status",1)->get();
            return DeliveryVehicleResource::collection($delivery_vehicles_list);
        }else {
            $data['delivery_vehicles_list'] = DeliveryVehicle::where("delivery_vehicles_status",1)->get();
            return view('pages.delivery_vehicles.list_delivery_vehicles', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.delivery_vehicles.create_delivery_vehicles');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_api_request = $request->route()->getPrefix() === 'api';
        if ($is_api_request) {

            $data = [
                'delivery_vehicles_name' => 'required|string|max:255',
                'delivery_vehicles_entry_id' => 'required|string',
                'delivery_vehicles_number' => 'required|string',
                'delivery_vehicles_reg_no' => 'required|string|max:255',
                'delivery_vehicles_created_by' => 'required|integer',
                
            ];

            $validator = Validator::make($request->all(), $data);
            if($validator->fails()){
                return['errors' => $validator->errors()->first()];
            }else {
                $validated = $validator->validated();
                $statement = DeliveryVehicle::create($validated);
                return new DeliveryVehicleResource($statement); 
            }
        }else {
            $data = [
                'delivery_vehicles_name' => 'required|string|max:255',
                'delivery_vehicles_entry_id' => 'required|string|max:255',
                'delivery_vehicles_number' => 'required|string|max:255',
                'delivery_vehicles_reg_no' => 'required|string|max:255',
                
            ];

            $validator = Validator::make($request->all(),$data);
            if($validator->fails()){
                return['errors' => $validator->errors()->first()];
            }else {
                $validated = $validator->validated();

                $validated['delivery_vehicles_created_by'] = Auth::user()->id;
            
                $statement = DeliveryVehicle::create($validated);
              
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
        $data['data'] = DeliveryVehicle::where('delivery_vehicles_id',$id)->first();
        return view('pages.delivery_vehicles.edit_delivery_vehicles',$data);
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
        DeliveryVehicle::where('delivery_vehicles_id',$request->delivery_vehicles_id)->update([
            'delivery_vehicles_name' => $request->delivery_vehicles_name,
            'delivery_vehicles_entry_id' => $request->delivery_vehicles_entry_id,
            'delivery_vehicles_number' => $request->delivery_vehicles_number,
            'delivery_vehicles_reg_no' => $request->delivery_vehicles_reg_no,
            'delivery_vehicles_updated_by' => Auth::user()->id,
            'updated_at' => date("Y/m/d"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeliveryVehicle::where('delivery_vehicles_id',$id)->update([
            'delivery_vehicles_deleted_by' => Auth::user()->id,
            'delivery_vehicles_status' => 0,
            'delivery_vehicles_is_deleted' => "YES",
        ]);
    }
}