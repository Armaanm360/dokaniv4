<?php

namespace App\Http\Controllers\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan\DeliveryMan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DeliveryManResource;
use App\Models\DeliveryVehicle\DeliveryVehicle;
use Illuminate\Support\Facades\Validator;

class DeliveryManController extends Controller
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

            $delivery_men_List = DeliveryMan::where('delivery_men_status',1)->get();
            return DeliveryManResource::collection($delivery_men_List);

            //            $books = ExpenseSubHead::paginate();
            // return ExpenseSubHeadResource::collection($books);
        }else{
            $delivery_men_List = DeliveryMan::where('delivery_men_status',1)->get();
            return view('pages.delivery_men.list_delivery_men',compact('delivery_men_List'));
        }

        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['delivery_men_Vehicle'] = DeliveryVehicle::all();
        return view('pages.delivery_men.create_delivery_men',$data);
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
                'delivery_men_name' => 'required|string|max:255',
                'delivery_men_entry_id' => 'required|string',
                'delivery_men_phone_number' => 'required|string',
                'delivery_men_address' => 'required|string|max:255',
                'delivery_men_created_by' => 'required|integer',
                
            ];
            
            $validator = Validator::make($request->all(), $data);
      
           if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();
                // $validated['status'] = '1';
                $statement = DeliveryMan::create($validated);
                return new DeliveryManResource($statement);
            }
       
           }else{

            
            $data = [
                'delivery_men_name' => 'required|string|max:255',
                'delivery_men_entry_id' => 'required|string',
                'delivery_men_phone_number' => 'required|string',
                'delivery_men_address' => 'required|string|max:255',
            ];

         

            $validator = Validator::make($request->all(), $data);
        
            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {
                $validated = $validator->validated();



                $validated['delivery_men_created_by'] = Auth::user()->id;
                $validated['delivery_men_vehicle'] = $request->delivery_men_vehicle;

                $statement = DeliveryMan::create($validated);
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
        $data['data'] = DeliveryMan::where('delivery_men_id',$id)->first();
        return view('pages.delivery_men.edit_delivery_men',$data);
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
        DeliveryMan::where('delivery_men_id',$request->delivery_men_id)->update([
            'delivery_men_name' => $request->delivery_men_name,
            'delivery_men_entry_id' => $request->delivery_men_entry_id,
            'delivery_men_phone_number' => $request->delivery_men_phone_number,
            'delivery_men_address' => $request->delivery_men_address,
            'delivery_men_updated_by' => Auth::user()->id,
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
        DeliveryMan::where('delivery_men_id',$id)->update([
            'delivery_men_deleted_by' => Auth::user()->id,
            'delivery_men_status' => 0,
            'delivery_men_is_deleted' => "YES",
        ]);
    }
}