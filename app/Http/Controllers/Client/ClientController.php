<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Branch\Branch;
use App\Models\Client\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientList = Client::where('client_status', 1)->join('branches', 'branches.branch_id', 'clients.branch_id')->select('clients.*', 'branches.branch_name')->get();

        if (isAPIRequest()) {
            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $clientList], 200);
        }



        return view('pages.client.list_client', compact('clientList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branchlist = Branch::where('branch_status', 1)->get();
        return view('pages.client.create_client', compact('branchlist'));
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
            'client_name' => 'required',
            // 'deligate_phone' => 'required',
            // 'deligate_email' => 'required',
            // 'deligate_transaction_opening_balance' => 'required',
            // 'deligate_licence_file' => 'mimes:pdf,xlx,csv,jpg,png,jpeg|max:2048',
            // 'deligate_picture' => 'mimes:jpg,png,jpeg|max:2048',
        ]);

        $client_image = '';

        if ($request->hasFile('client_image')) {
            $client_image_file = time() . '.' . $request->client_image->extension();
            $request->client_image->move(public_path('uploads'), $client_image_file);
            $client_image = 'uploads/' . $client_image_file;
        }

        $client = new Client();
        $client->client_name = $request->client_name;
        $client->branch_id = $request->branch_id;
        $client->client_entry_id = $request->client_entry_id;
        $client->client_email = $request->client_email;
        $client->client_phone_number = $request->client_phone_number;
        $client->client_type = $request->client_type;
        $client->client_address = $request->client_address;
        if (isAPIRequest()) {
            $client->client_created_by =  $request->client_created_by;
        } else {
            $client->client_created_by =  Auth::user()->id;
        }


        $client->client_image = $client_image;
        $client->created_at = date("Y-m-d");
        $client->save();

        $data = new CommonResource($client);

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
        $data['data'] = client::where('client_id', $id)->first();
        return view('pages.client.edit_client', $data);
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
        if ($request->hasFile('client_image')) {
            $file_info = client::where('client_id', $request->client_id)->first();

            if ($file_info->client_image != null) {

                $path = public_path() . '/' . $file_info->client_image;
                unlink($path);
            }
            $fileName = time() . '.' . $request->client_image->extension();

            $request->client_image->move(public_path('uploads'), $fileName);


            client::where('client_id', $request->client_id)->update([
                'client_image' => '/uploads/' . $fileName,
            ]);
        }
        client::where('client_id', $request->client_id)->update([
            'client_name' => $request->client_name,
            'branch_id' => $request->branch_id,
            'client_entry_id' => $request->client_entry_id,
            'client_email' => $request->client_email,
            'client_phone_number' => $request->client_phone_number,
            'client_type' => $request->client_type,
            'client_address' => $request->client_address,
            'client_updated_by' => Auth::user()->id,
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
        Client::where('client_id', $id)->update([
            'client_deleted_by' => Auth::user()->id,
            'client_status' => 0,
            'client_is_deleted' => "YES",
        ]);
    }
    public function onlineClient()
    {
        $clientList = Client::where('client_status', 1)->where('client_type', 'ONLINE')->join('branches', 'branches.branch_id', 'clients.branch_id')->select('clients.*', 'branches.branch_name')->get();
        return view('pages.client.list_online_client', compact('clientList'));
    }
    public function wholesaleClient()
    {
        $clientList = Client::where('client_status', 1)->where('client_type', 'WHOLE_SALE')->join('branches', 'branches.branch_id', 'clients.branch_id')->select('clients.*', 'branches.branch_name')->get();
        return view('pages.client.list_wholesale_client', compact('clientList'));
    }
}
