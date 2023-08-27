<?php

namespace App\Http\Controllers\CompanyInfo;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use Illuminate\Http\Request;
use App\Models\CompanyInfo\CompanyInfo;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CompanyInfoResource;
use Illuminate\Support\Facades\Validator;

class CompanyInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['company_info_list'] = CommonResource::collection(CompanyInfo::where('company_status', 1)->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['company_info_list']], 200);
        } else {

            return view('pages.settings.company_info.list_company_info', $data);
        }







    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.settings.company_info.create_company_info');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_api_request = $request->route()->getPrefix()=== 'api';
        if ($is_api_request) {
            $data = [
                'company_name' => 'required|string|max:255',
                // 'company_id' => 'required|string',
                'company_phone' => 'required|string',
                'company_address' => 'required|string|max:255',
                'created_by' => 'required|integer',
                
            ];

            $validator = Validator::make($request->all(), $data);
      
           if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();
                // $validated['status'] = '1';
                $statement = CompanyInfo::create($validated);
                return new CompanyInfoResource($statement);
            }
        }else {
            $data = [
                'company_name' => 'required|string|max:255',
                // 'company_id' => 'required|string',
                'company_phone' => 'required|string',
                'company_address' => 'required|string|max:255',
                
            ];

             $validator = Validator::make($request->all(), $data);
            
            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {
                $validated = $validator->validated();
                $validated['created_by'] = Auth::user()->id;
                $validated['company_status'] = 1;
                $statement = CompanyInfo::create($validated);
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
        $data['data'] = CompanyInfo::where('company_id',$id)->first();
        return view('pages.settings.company_info.edit_company_info',$data);
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
        $is_api_request = $request->route()->getPrefix() === 'api';
        if ($is_api_request) {
            //data get    
            $data = [
                'company_name' => 'required|string|max:255',
                // 'company_id' => 'required|string',
                'company_phone' => 'required|string',
                'company_address' => 'required|string|max:255',
                'created_by' => 'required|integer',
                
            ];

            $validator = Validator::make($request->all(), $data);

            if ($validator->fails()) {
                return ['errors' => $validator->errors()->first()];
            } else {

                $validated = $validator->validated();
                $validated['status'] = '1';
                $company_info->update($validated);



                //$statement = ExpenseHead::create($validated);
                return new CompanyInfoResource($company_info);
            }
        } else {
           

            CompanyInfo::where('company_id',$request->company_id)->update([
            'company_name' => $request->company_name,
            'company_phone' => $request->company_phone,
            'company_address' => $request->company_address,
            'updated_by' => Auth::user()->id,
            'updated_at' => date("Y/m/d"),
        ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CompanyInfo::where('company_id',$id)->update([
            'deleted_by' => Auth::user()->id,
            'company_status' => 0,
            'is_deleted' => "YES",
        ]);
    }
}