<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Controllers\Controller;
use App\Models\PosTransfer\PosTransfer;
use App\Models\PosTransferProduct\PosTransferProduct;
use App\Models\Warehouse\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data['proQuan'] = PosTransferProduct::selectRaw('sum(pos_transfer_products.quantity) AS proQuan')->join('pos_transfers', 'pos_transfers.transferNo','=','pos_transfer_products.transferNo')->get(); 
         $data['transfer'] = PosTransfer::all(); 

        // echo '<pre>';
        // print_r($data['transfer']);die;
        return view('pages.transfer.list_transfer',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['warehouse'] = Warehouse::whereWarehouseIsDeleted('NO')->get();
        return view('pages.transfer.create_transfer', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $posTransfer = new PosTransfer();
        $posTransfer->transferDate = date('d-m-Y');
        $posTransfer->transferNo = $request->transferNo;
        $posTransfer->fromWarehouseID = $request->fromWarehouseID;
        $posTransfer->toWarehouseID = $request->toWarehouseID;
        $posTransfer->note = $request->note;
        $posTransfer->create_date = date('d-m-Y');
        $posTransfer->created_by = Auth::user()->id;
        $posTransfer->save();





        $transferNo = $posTransfer->transferNo;

        foreach ($request->billing_rows as $rowBilling) {

            $productID = 'product_' . $rowBilling;
            $quantity  = 'qty_' . $rowBilling;



            $transferProduct = new PosTransferProduct();
            $transferProduct['transferNo'] = $transferNo;
            $transferProduct['product_id'] = $request->$productID;
            $transferProduct['quantity'] = $request->$quantity;
            $transferProduct['from_warehouse'] = $request->fromWarehouseID;
            $transferProduct['to_warehouse'] = $request->toWarehouseID;
            $transferProduct['create_date'] = date('d-m-Y');
            $transferProduct['created_by'] = Auth::user()->id;
            $transferProduct->save();
        }


      




       // return redirect('invoice/' . $invoice_sale->sale_id);
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
        $data['transfer'] = PosTransfer::where('transfer_id',$id)->get();
        $data['warehouse'] = Warehouse::whereWarehouseIsDeleted('NO')->get();
        $data['product']   = PosTransferProduct::where('transferNo', $data['transfer'][0]->transferNo)->get();
        return view('pages.transfer.edit_transfer',$data);
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


        $request->billing_rows;
    //    $id =  $request->transfer_id;
    //     $transferUpdate = PosTransfer::where('transfer_id',$id)->update([
    //         'fromWarehouseID' => $request->fromWarehouseID,
    //         'toWarehouseID' => $request->toWarehouseID,
    //         'note' => $request->note,

    //     ]);

    //     $transferNo = $request->transferNo;

    //     foreach ($request->billing_rows as $rowBilling) {

    //         $productID = 'product_' . $rowBilling;
    //         $quantity  = 'qty_' . $rowBilling;



    //         // $transferProduct = new PosTransferProduct();
    //         // $transferProduct['transferNo'] = $transferNo;
    //         // $transferProduct['product_id'] = $request->$productID;
    //         // $transferProduct['quantity'] = $request->$quantity;
    //         // $transferProduct['create_date'] = date('d-m-Y');
    //         // $transferProduct['created_by'] = Auth::user()->id;
    //         // $transferProduct->save();

    //         PosTransferProduct::where('transferNo', $transferNo)->update([
    //             'quantity'=> $request->$quantity
    //         ]);
    //     }



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

    public function fromWareHouse($fromWareHouse)
    {

        $fromuser = Warehouse::whereWarehouseIsDeleted('NO')->where('warehouse_id', '!=',$fromWareHouse)->get();

        $output = '';
        $output .= '';
        foreach ($fromuser as $row) {
            $output .= '<option value="' . $row->warehouse_id . '" selected>' . $row->warehouse_name . '</option>';
        }
        return $output;
    }

    public function justWareHouse($transfer_id)
    {

   $fromuser = PosTransfer::where('transfer_id', $transfer_id)->get();
    $toware = $fromuser[0]->toWarehouseID;
       return getWareHouseNameHelp($toware);
    }
}