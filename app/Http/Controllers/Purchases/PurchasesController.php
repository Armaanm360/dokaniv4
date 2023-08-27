<?php

namespace App\Http\Controllers\Purchases;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use App\Models\Attribute\AttributeValue;
use App\Models\Product\Purchase;
use App\Models\Product\PurchaseItems;
use App\Models\Product\PurchaseReturnItems;
use App\Models\Transfer\WarehouseToBranchItems;
use App\Models\SupplierTransaction\SupplierTransaction;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Purchases;

class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['purchaseList'] = CommonResource::collection(Purchase::where('purchases.purchase_status', 1)
            ->join('suppliers', 'purchases.purchase_supplier_id', 'suppliers.supplier_id')
            ->join('warehouses', 'purchases.purchase_warehouse_id', 'warehouses.warehouse_id')
            ->select('purchases.*', 'suppliers.supplier_name', 'warehouses.warehouse_name')
            ->where('purchases.purchase_status', 1)
            ->orderBy('purchases.purchase_id', 'desc')
            ->get());

        if (isAPIRequest()) {

            return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $data['purchaseList']], 200);
        } else {

            return view('pages.purchases.list_purchases', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = date('Y/m/d');
        $row_count = Purchase::where('purchase_created_at', $date)->count();
        $color = AttributeValue::where('attributes_id', 1)->get();
        $size = AttributeValue::where('attributes_id', 2)->get();
        return view('pages.purchases.create_purchases', compact('row_count', 'color', 'size'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'purchase_name' => 'required',
        //     'purchase_code' => 'required|unique:purchases,purchase_code'
        // ]);

        // $data = $request->total_rows;
        // echo $data;
        // die();




        //latest//

        $purchase = new Purchase();
        $purchase->purchase_warehouse_id = $request->purchase_warehouse_id;
        $purchase->purchase_supplier_id = $request->purchase_supplier_id;
        $purchase->purchase_number = $request->purchase_number;
        $purchase->purchase_po_reference = $request->purchase_po_reference;
        $purchase->purchase_payment_terms = $request->purchase_payment_terms;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->due_date = $request->due_date;
        $purchase->purchase_note = $request->purchase_note;
        $purchase->purchase_quantity = $request->purchase_quantity;
        $purchase->purchase_discount = $request->purchase_discount;
        $purchase->purchase_subtotal = $request->purchase_subtotal;
        $purchase->purchase_net_total = $request->purchase_net_total;
        $purchase->purchase_created_by =  4;
        // $purchase->purchase_created_at = date('Y-m-d');
        $purchase->purchase_created_at = date('Y-m-d');
        $purchase->created_at = date("Y-m-d");
        $purchase->save();
        $purchase_id = $purchase->purchase_id;


        for ($i = 1; $i <= $request->total_rows; $i++) {
            // print_r($request->total_rows);die;
            $product_id = 'product_id_' . $i;
            $color = 'color_' . $i;
            $size = 'size_' . $i;
            $quantity = 'qty_' . $i;
            $unit_price = 'unit_price_' . $i;
            $total_price = "total_price_" . $i;
            $purchased_item = new PurchaseItems();
            $purchased_item['purchase_id'] = $purchase_id;
            $purchased_item['purchase_product_id'] = $request->$product_id;
            $purchased_item['purchase_product_color'] = $request->$color;
            $purchased_item['purchase_product_size'] = $request->$size;
            $purchased_item['purchase_product_quantity'] = $request->$quantity;
            $purchased_item['purchase_product_price'] = $request->$unit_price;
            $purchased_item['warehouse_id'] = $request->purchase_warehouse_id;
            $purchased_item['purchase_product_total_price'] = $request->$total_price;
            $purchased_item['created_at'] = date('Y-m-d');
            $purchased_item->save();
        }


        $supplier_transaction = new SupplierTransaction();
        $supplier_transaction->supplier_transaction_type = "CREDIT";
        $supplier_transaction->supplier_transaction_supplier_id = $request->purchase_supplier_id;
        $supplier_transaction->supplier_transaction_amount = $request->purchase_net_total;
        $supplier_transaction->supplier_transaction_last_balance = get_client_current_balance_by_client_id($request->purchase_supplier_id);
        $supplier_transaction->supplier_transaction_date = date("Y-m-d");
        $supplier_transaction->save();


        $supplier_transaction = $supplier_transaction->supplier_transaction_id;
        $update_client_transection = SupplierTransaction::find($supplier_transaction)->update([
            'supplier_transaction_last_balance' => get_supplier_current_balance_by_supplier_id($request->purchase_supplier_id)
        ]);


        $data = new CommonResource($purchase);
        return response()->json(['success' => true, 'message' => 'Successfully Deleted', 'data' => $data], 200);


        // $purchased_item = new PosSaleProduct();
        // $purchased_item['purchase_id'] = 2;
        // $purchased_item['purchase_product_id'] = $request->$product_id;
        // $purchased_item['purchase_product_color'] = $request->$color;
        // $purchased_item['purchase_product_size'] = $request->$size;
        // $purchased_item['purchase_product_quantity'] = $request->$quantity;
        // $purchased_item['purchase_product_price'] = $request->$unit_price;
        // $purchased_item['purchase_product_total_price'] = $request->$total_price;
        // $purchased_item['created_at'] = date('Y-m-d');
        // $purchased_item->save();

        // return redirect('purchases');

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
        $data['data'] = Purchase::where('purchase_id', $id)->first();
        $data['purchase_items_rows'] = PurchaseItems::where('purchase_id', $id)->count();
        $purchase_items = PurchaseItems::where('purchase_id', $id)->get();
        // $productCategory = ProductCategory::where('product_category_status',1)->get();
        return view('pages.purchases.edit_purchases', $data, compact('purchase_items'));
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

        Purchase::where('purchase_id', $request->purchase_id)->update([
            'purchase_warehouse_id' => $request->purchase_warehouse_id,
            'purchase_supplier_id' => $request->purchase_supplier_id,
            'purchase_number' => $request->purchase_number,
            'purchase_po_reference' => $request->purchase_po_reference,
            'purchase_payment_terms' => $request->purchase_payment_terms,
            'purchase_date' => $request->purchase_date,
            'due_date' => $request->due_date,
            'purchase_note' => $request->purchase_note,
            'purchase_quantity' => $request->purchase_quantity,
            'purchase_discount' => $request->purchase_discount,
            'purchase_subtotal' => $request->purchase_subtotal,
            'purchase_net_total' => $request->purchase_net_total,
            'purchase_updated_by' => Auth::user()->id,
            'updated_at' => date("Y/m/d"),
        ]);

        PurchaseItems::where('purchase_id', $request->purchase_id)->delete();
        for ($i = 1; $i <= $request->billing_rows; $i++) {
            $product_id = 'product_id_' . $i;
            $color = 'color_' . $i;
            $size = 'size_' . $i;
            $quantity = 'qty_' . $i;
            $unit_price = 'unit_price_' . $i;
            $total_price = "total_price_" . $i;

            PurchaseItems::insert([
                'purchase_id' => $request->purchase_id,
                'purchase_product_id' => $request->$product_id,
                'purchase_product_color' => $request->$color,
                'purchase_product_size' => $request->$size,
                'purchase_product_quantity' => $request->$quantity,
                'warehouse_id' => $request->purchase_warehouse_id,
                'purchase_product_price' => $request->$unit_price,
                'purchase_product_total_price' => $request->$total_price,
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
        Purchase::where('purchase_id', $id)->update([
            'purchase_deleted_by' => Auth::user()->id,
            'purchase_status' => 0,
            'purchase_is_deleted' => "YES",
        ]);
        PurchaseItems::where('purchase_id', $id)->delete();
    }

    // public function purchaseId($id)
    // {
    //     $fromPurchase = Purchase::join('purchase_items','purchases.purchase_id','purchase_items.purchase_id')
    //     ->where('purchases.purchase_status',1)
    //     ->where('purchases.purchase_warehouse_id',$id)
    //     ->join('products','purchase_items.purchase_product_id','products.product_id')
    //     ->select('products.product_id','products.product_name','products.product_entry_id')
    //     ->groupBy('products.product_id')
    //     ->get();


    //     $output = '<option> Select One </option>';
    //     foreach($fromPurchase as $row)
    //     {
    //         $productId = $row->product_id;
    //         $productpurchaseQuantity = PurchaseItems::where('purchase_product_id',$productId)->sum('purchase_product_quantity');
    //         $productreturnQuantity = PurchaseReturnItems::where('purchase_product_id',$productId)->sum('purchase_product_return_quantity');
    //         $productQuantity = $productpurchaseQuantity - $productreturnQuantity;
    //         $output .= '<option value = '.$productQuantity.'>'.$row->product_name.'</option>';
    //     }
    //     return response()->json($output);
    // }

    public function purchasedProducts(Request $request)
    {
        $clients = Purchase::where('purchases.purchase_status', 1)
            ->where('purchase_warehouse_id', $request->q)
            ->join('purchase_items', 'purchase_items.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'products.product_id', '=', 'purchase_items.purchase_product_id')
            //     ->join('pos_transfers', 'pos_transfers.toWarehouseID','=', 'purchases.purchase_warehouse_id')
            //     ->join('pos_transfer_products', 'pos_transfer_products.transferNo','=', 'pos_transfers.transferNo')
            //    ->where('pos_transfer_products.to_warehouse','=',$request->q)
            ->select('products.product_id', 'products.product_name', 'products.product_entry_id')
            ->groupBy('products.product_id')
            ->get();

        // echo '<pre>';
        // print_r($clients);die;

        $client_array = array();
        foreach ($clients as $client) {
            $productId = $client->product_id;
            $productpurchaseQuantity = PurchaseItems::where('purchase_product_id', $productId)->where('warehouse_id', $request->q)->sum('purchase_product_quantity');
            $productreturnQuantity = PurchaseReturnItems::where('purchase_product_id', $productId)->where('warehouse_id', $request->q)->sum('purchase_product_return_quantity');
            $producttransferQuantity = WarehouseToBranchItems::where('warehouse_id', $request->q)->where('transfer_product_id', $productId)->sum('transfer_product_amount');
            $productQuantity = $productpurchaseQuantity - $productreturnQuantity - $producttransferQuantity;

            $label = $client['product_name'] . '(' . $productQuantity . ')';
            $value = intval($client['purchase_items_id']);
            $item_id = $client['product_id'];
            $items_detail = $client['product_name'];
            $items_quantity = $productQuantity;
            $items_price = $client['purchase_product_price'];
            $client_array[] = array(
                "label" => $label, "value" => $value,
                'items_detail' => $items_detail,
                'items_quantity' => $items_quantity,
                'items_price' => $items_price,
                'items_id' => $item_id,
            );
        }

        $result = array('status' => 'ok', 'content' => $client_array);
        echo json_encode($result);
        exit;
    }
    public function purchasedProductsApi($warehouse_id)
    {
        $clients = Purchase::where('purchases.purchase_status', 1)
            ->where('purchase_warehouse_id', $warehouse_id)
            ->join('purchase_items', 'purchase_items.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'products.product_id', '=', 'purchase_items.purchase_product_id')
            //     ->join('pos_transfers', 'pos_transfers.toWarehouseID','=', 'purchases.purchase_warehouse_id')
            //     ->join('pos_transfer_products', 'pos_transfer_products.transferNo','=', 'pos_transfers.transferNo')
            //    ->where('pos_transfer_products.to_warehouse','=',$request->q)
            ->select('products.product_id', 'products.product_name', 'products.product_entry_id')
            ->groupBy('products.product_id')
            ->get();

        // echo '<pre>';
        // print_r($clients);die;

        $client_array = array();
        foreach ($clients as $client) {
            $productId = $client->product_id;
            $productpurchaseQuantity = PurchaseItems::where('purchase_product_id', $productId)->where('warehouse_id', $warehouse_id)->sum('purchase_product_quantity');
            $productreturnQuantity = PurchaseReturnItems::where('purchase_product_id', $productId)->where('warehouse_id', $warehouse_id)->sum('purchase_product_return_quantity');
            $producttransferQuantity = WarehouseToBranchItems::where('warehouse_id', $warehouse_id)->where('transfer_product_id', $productId)->sum('transfer_product_amount');
            $productQuantity = $productpurchaseQuantity - $productreturnQuantity - $producttransferQuantity;

            $label = $client['product_name'] . '(' . $productQuantity . ')';
            $value = intval($client['purchase_items_id']);
            $item_id = $client['product_id'];
            $items_detail = $client['product_name'];
            $items_quantity = $productQuantity;
            $items_price = $client['purchase_product_price'];
            $client_array[] = array(
                "label" => $label, "value" => $value,
                'items_detail' => $items_detail,
                'items_quantity' => $items_quantity,
                'items_price' => $items_price,
                'items_id' => $item_id,
            );
        }

        return response()->json(['success' => 'true', 'message' => 'Successfully Done', 'data' => $client_array], 200);
    }
}
