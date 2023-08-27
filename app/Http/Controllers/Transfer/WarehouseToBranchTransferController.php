<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Branch\Branch;
use App\Models\Transfer\WarehouseToBranch;
use App\Models\Transfer\WarehouseToBranchItems;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseToBranchTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['warehouseTobranch'] = WarehouseToBranch::where('warehouse_to_branch_transfer_status', 1)
            ->join('warehouses', 'warehouses.warehouse_id', 'warehouse_to_branches.warehouse_id')
            ->join('branches', 'branches.branch_id', 'warehouse_to_branches.branch_id')
            ->select('warehouse_to_branches.*', 'branches.branch_name', 'warehouses.warehouse_name')
            ->get();

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['warehouseTobranch']], 200);
        } else {

            return view('pages.transfer.warehouse_to_branch.list_warehouse_branch_transfer', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouseList = Warehouse::where('warehouse_status', 1)->get();
        $branchList = Branch::where('branch_status', 1)->get();
        return view('pages.transfer.warehouse_to_branch.create_warehouse_branch_transfer', compact('warehouseList', 'branchList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // print_r($request->billing_rows);die;
        $warehouseToBranch = new WarehouseToBranch();
        $warehouseToBranch->warehouse_to_branch_transfer_number =
            $request->warehouse_to_branch_transfer_number;
        $warehouseToBranch->transfer_date = $request->transfer_date;
        $warehouseToBranch->warehouse_id = $request->warehouse_id;
        $warehouseToBranch->branch_id = $request->branch_id;
        $warehouseToBranch->transfer_note = $request->transfer_note;
        $warehouseToBranch->warehouse_to_branch_transfer_created_by =  1;
        // $purchase->purchase_created_at = date('Y-m-d');
        $warehouseToBranch->warehouse_to_branch_transfer_created_at = date('Y-m-d');
        $warehouseToBranch->created_at = date("Y-m-d");
        $warehouseToBranch->save();
        $transfer_id = $warehouseToBranch->id;

        // foreach ($request->billing_rows as $rowBilling) {

        //     $product_id = 'product_' . $rowBilling;
        //     $available = 'available_qty_' . $rowBilling;
        //     $transfered = 'qty_' . $rowBilling;
        //     $purchased_item = new WarehouseToBranchItems();
        //     $purchased_item['warehouse_to_branch_transfer_id'] = $transfer_id;
        //     $purchased_item['warehouse_to_branch_transfer_number'] = $request->warehouse_to_branch_transfer_number;
        //     $purchased_item['transfer_product_id'] = $request->$product_id;
        //     $purchased_item['transfer_product_available_balance'] = $request->$available;
        //     $purchased_item['transfer_product_amount'] = $request->$transfered;
        //     $purchased_item['created_at'] = date('Y-m-d');
        //     $purchased_item['warehouse_id'] = $request->warehouse_id;
        //     $purchased_item->save();
        // }

        $rowBilling = $request->billing_rows;
        for ($i = 1; $i <= $rowBilling; $i++) {
            $product_id = 'product_' . $rowBilling;
            $available = 'available_qty_' . $rowBilling;
            $transfered = 'qty_' . $rowBilling;
            $purchased_item = new WarehouseToBranchItems();
            $purchased_item['warehouse_to_branch_transfer_id'] = $transfer_id;
            $purchased_item['warehouse_to_branch_transfer_number'] = $request->warehouse_to_branch_transfer_number;
            $purchased_item['transfer_product_id'] = $request->$product_id;
            $purchased_item['transfer_product_available_balance'] = $request->$available;
            $purchased_item['transfer_product_amount'] = $request->$transfered;
            $purchased_item['created_at'] = date('Y-m-d');
            $purchased_item['warehouse_id'] = $request->warehouse_id;
            $purchased_item->save();
        }


        // DB::table('warehouse_to_branches')->where('warehouse_to_branch_transfer_number', $purchased_item->warehouse_to_branch_transfer_number)->get();



        $data = new CommonResource($warehouseToBranch);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);
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
        $data['data'] = WarehouseToBranch::where('warehouse_to_branch_transfer_id', $id)->first();
        $data['transfer_items_rows'] = WarehouseToBranchItems::where('warehouse_to_branch_transfer_id', $id)->count();
        $transfer_items = WarehouseToBranchItems::where('warehouse_to_branch_transfer_id', $id)->get();
        $warehouseList = Warehouse::where('warehouse_status', 1)->get();
        $branchList = Branch::where('branch_status', 1)->get();
        // $productCategory = ProductCategory::where('product_category_status',1)->get();
        return view('pages.transfer.warehouse_to_branch.edit_warehouse_branch_transfer', $data, compact('transfer_items', 'warehouseList', 'branchList'));
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
        WarehouseToBranch::where('warehouse_to_branch_transfer_id', $request->transfer_id)->update([
            'warehouse_to_branch_transfer_number' => $request->warehouse_to_branch_transfer_number,
            'transfer_date' => $request->transfer_date,
            'warehouse_id' => $request->warehouse_id,
            'branch_id' => $request->branch_id,
            'transfer_note' => $request->transfer_note,
            'warehouse_to_branch_transfer_updated_by' => Auth::user()->id,
            'updated_at' => date("Y/m/d"),
        ]);

        WarehouseToBranchItems::where('warehouse_to_branch_transfer_id', $request->transfer_id)->delete();
        for ($i = 1; $i <= $request->billing_rows; $i++) {
            $product_id = 'product_id_' . $i;
            $available = 'available_qty_' . $i;
            $transfered = 'qty_' . $i;

            WarehouseToBranchItems::insert([
                'warehouse_to_branch_transfer_id' => $request->transfer_id,
                'warehouse_to_branch_transfer_number' => $request->warehouse_to_branch_transfer_number,
                'transfer_product_id' => $request->$product_id,
                'transfer_product_available_balance' => $request->$available,
                'transfer_product_amount' => $request->$transfered,
                'warehouse_id' => $request->warehouse_id,
                'created_at' => date("Y/m/d"),
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
        //
    }
}
