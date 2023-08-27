<?php

namespace App\Http\Controllers\AttributeValues;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use Illuminate\Http\Request;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeValue;
use Illuminate\Support\Facades\Auth;

class AttributeValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['attributesList'] = CommonResource::collection(AttributeValue::where('attributes_value_is_deleted','NO')->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['attributesList']], 200);
        } else {

            return view('pages.attributes_value.list_attributes_values', $data);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $data['attributesList'] = Attribute::all();
        return view('pages.attributes_value.create_attributes_values',$data);
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
            'attributes_value' => 'required',
        ]);


        $attribute = new AttributeValue();
        $attribute->attributes_id = $request->attribute_id;
        $attribute->attributes_value = $request->attributes_value;
        $attribute->attributes_value_entry_id = $request->attributes_entry_id;
        if (isAPIRequest()) {
            $attribute->attributes_value_created_by =  $request->created_by;
        } else {
            $attribute->attributes_value_created_by =  Auth::user()->id;
        }

        $attribute->save();

        $data = new CommonResource($attribute);

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
        $data['attributevalue'] = AttributeValue::where('attributes_value_id',$id)->first();




        $data['attributes'] = Attribute::all();
        return view('pages.attributes_value.edit_attributes_values',$data);
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



        $item = AttributeValue::findOrFail($id);

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


        $item = AttributeValue::find($id);
        $item->attributes_value_is_deleted = "YES";
        $item->save();
        $data = new CommonResource($item);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
    }
}