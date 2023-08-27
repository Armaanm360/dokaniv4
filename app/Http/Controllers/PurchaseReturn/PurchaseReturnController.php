<?php

namespace App\Http\Controllers\PurchaseReturn;

use App\Http\Controllers\Controller;
use App\Models\Product\Purchase;
use App\Models\Product\PurchaseItems;
use App\Models\Product\PurchaseReturn;
use App\Models\Product\PurchaseReturnItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseReturnList = PurchaseReturn::where('purchase_returns.purchase_return_status',1)
        ->join('suppliers','purchase_returns.purchase_return_supplier_id','suppliers.supplier_id')
        ->select('purchase_returns.*','suppliers.supplier_name')
        ->get();
        return view('pages.purchase_return.list_purchase_return',compact('purchaseReturnList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = date('Y/m/d');
        $row_count = PurchaseReturn::where('purchase_return_created_at',$date)->where('purchase_return_status',1)->count();
        return view('pages.purchase_return.create_purchase_return',compact('row_count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchase_return = new PurchaseReturn();
        $purchase_return->purchase_return_supplier_id = $request->purchase_supplier_id;
        $purchase_return->purchase_number = $request->purchase_number;
        $purchase_return->purchase_return_number = $request->purchase_return_number;
        $purchase_return->purchase_total_quantity = $request->purchase_total_quantity;
        $purchase_return->purchase_return_total_quantity = $request->purchase_return_total_quantity;
        $purchase_return->purchase_subtotal = $request->purchase_subtotal;
        $purchase_return->purchase_return_subtotal = $request->purchase_return_subtotal;
        $purchase_return->purchase_discount = $request->purchase_discount;
        $purchase_return->purchase_return_discount = $request->purchase_return_discount;
        $purchase_return->purchase_net_total = $request->purchase_net_total;
        $purchase_return->purchase_return_net_total = $request->purchase_return_net_total;
        $purchase_return->purchase_net_total = $request->purchase_net_total;
        $purchase_return->purchase_return_created_by =  Auth::user()->id;
        $purchase_return->purchase_return_created_at = date('Y/m/d');
        $purchase_return->created_at = date("Y/m/d");
        $purchase_return->save();

        $purchase_return_id = $purchase_return->id;
        for($i=1;$i<=$request->total_rows;$i++)
        {
            $product_id = 'purchase_product_id_'.$i;
            $color = 'purchase_product_color_'.$i;
            $size = 'purchase_product_size_'.$i;
            $purchase_quantity = 'purchase_product_quantity_'.$i;
            $purchase_return_quantity = 'purchase_product_return_quantity_'.$i;
            $purchase_product_price = 'purchase_product_price_'.$i;
            $purchase_product_total_price = 'purchase_product_total_price_'.$i;
            $purchase_product_return_price = 'purchase_return_product_total_price_'.$i;

        $purchase_return_item = new PurchaseReturnItems();
        $purchase_return_item['purchase_return_id'] = $purchase_return_id;
        $purchase_return_item['purchase_number'] = $request->purchase_number;
        $purchase_return_item['purchase_product_id'] = $request->$product_id;
        $purchase_return_item['purchase_product_size'] = $request->$color;
        $purchase_return_item['purchase_product_color'] = $request->$size;
        $purchase_return_item['purchase_product_quantity'] = $request->$purchase_quantity;
        $purchase_return_item['purchase_product_return_quantity'] = $request->$purchase_return_quantity;
        $purchase_return_item['purchase_product_price'] = $request->$purchase_product_price;
        $purchase_return_item['purchase_product_total_price'] = $request->$purchase_product_total_price;
        $purchase_return_item['purchase_return_product_total_price'] = $request->$purchase_product_return_price;
        $purchase_return_item['created_at'] = date('Y-m-d');
        $purchase_return_item->save();
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
        $data['data'] = PurchaseReturn::where('purchase_return_id',$id)->first();
        $data['purchase_items_rows'] = PurchaseReturnItems::where('purchase_return_id',$id)->count();
        $purchase_return_items = PurchaseReturnItems::where('purchase_return_id',$id)->get();
        // $productCategory = ProductCategory::where('product_category_status',1)->get();
        return view('pages.purchase_return.edit_purchase_return',$data,compact('purchase_return_items'));
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
        PurchaseReturn::where('purchase_return_id',$request->purchase_return_id)->update([
            'purchase_return_total_quantity' => $request->purchase_return_total_quantity,
            'purchase_return_subtotal' => $request->purchase_return_subtotal,
            'purchase_return_discount' => $request->purchase_return_discount,
            'purchase_return_net_total' => $request->purchase_return_net_total,
            'purchase_return_updated_by' => Auth::user()->id,
            'updated_at' => date("Y/m/d"),
        ]);

        PurchaseReturnItems::where('purchase_return_id',$request->purchase_return_id)->delete();
            for($i=1;$i<=$request->total_rows;$i++)
            {
                $product_id = 'purchase_product_id_'.$i;
                $color = 'purchase_product_color_'.$i;
                $size = 'purchase_product_size_'.$i;
                $purchase_quantity = 'purchase_product_quantity_'.$i;
                $purchase_return_quantity = 'purchase_product_return_quantity_'.$i;
                $purchase_product_price = 'purchase_product_price_'.$i;
                $purchase_product_total_price = 'purchase_product_total_price_'.$i;
                $purchase_product_return_price = 'purchase_return_product_total_price_'.$i;

                $purchase_return_item = new PurchaseReturnItems();
                $purchase_return_item['purchase_return_id'] = $request->purchase_return_id;
                $purchase_return_item['purchase_number'] = $request->purchase_number;
                $purchase_return_item['purchase_product_id'] = $request->$product_id;
                $purchase_return_item['purchase_product_size'] = $request->$color;
                $purchase_return_item['purchase_product_color'] = $request->$size;
                $purchase_return_item['purchase_product_quantity'] = $request->$purchase_quantity;
                $purchase_return_item['purchase_product_return_quantity'] = $request->$purchase_return_quantity;
                $purchase_return_item['purchase_product_price'] = $request->$purchase_product_price;
                $purchase_return_item['purchase_product_total_price'] = $request->$purchase_product_total_price;
                $purchase_return_item['purchase_return_product_total_price'] = $request->$purchase_product_return_price;
                $purchase_return_item['created_at'] = date('Y-m-d');
                $purchase_return_item->save();
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
        PurchaseReturn::where('purchase_return_id',$id)->update([
            'purchase_return_deleted_by' => Auth::user()->id,
            'purchase_return_status' => 0,
            'purchase_return_is_deleted' => "YES",
        ]);
        PurchaseReturnItems::where('purchase_return_id',$id)->delete();
    }
    public function getPurchaseNumber($id)
    {
        $purchasenumber =  Purchase::where('purchase_supplier_id',$id)
        ->select('purchases.purchase_number')
        ->get();
        $output = '<option> Select One </option>';
        foreach($purchasenumber as $row)
        {
            $output .= '<option value = '.$row->purchase_number.'>'.$row->purchase_number.'</option>';
        }
        return response()->json($output);
    }
    public function getPurchaseData(Request $request)
    {
        $data = $request->purchase_number;
        $data3 = $request->purchase_number;
        $data1 = $request->supplier_id;
        $data2 = $request->purchase_return_number;

        // echo $data;
        // echo $data1;
        // echo $data2;
        // die();
        $retrieve['purchase_data'] = Purchase::where('purchase_number',$data)->first();
        $retrieve['purchase_items_rows'] = DB::table('purchase_items')->join('purchases','purchase_items.purchase_id','purchases.purchase_id')->where('purchases.purchase_number',$data)->count();
        $purchase_items = DB::table('purchase_items')->join('purchases','purchase_items.purchase_id','purchases.purchase_id')->where('purchases.purchase_number',$data)->get();
        // $productCategory = ProductCategory::where('product_category_status',1)->get();
        return view('pages.purchase_return.purchase_return_form',$retrieve,compact('purchase_items','data','data1','data2','data3'));
    }
}
