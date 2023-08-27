<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['warehouses'] = \App\Models\Warehouse\Warehouse::whereWarehouseStatus(1)->get();
        $data['product_categories'] = \App\Models\ProductCategory\ProductCategory::where('product_category_is_deleted','NO')->get();
        return view('pages.inventory.list_inventory',$data);
    }
    
    public function list(Request $request) {
//     print_r($request->all()); 
     
      $draw = intval($request->draw);
        $start = intval($request->start);
        $limit = intval($request->length);
        $sortBy = null;
        $sortDirection = '';
//        print_r($request->order);die;
        
        $wareHouseID = '';
        $categoryID = '';
        $productID = '';
        $dateRange = '';
        $dateSearch = null;
        $from = '';
        $to = '';
        
        $wherePurchaseDate = '';
        
            if ($request->columns[2]['search']) {
            $wareHouseID = $request->columns[2]['search']['value'];
        }
            if ($request->columns[5]['search']) {
            $dateRange = $request->columns[5]['search']['value'];
        }
            if ($request->columns[4]['search']) {
            $categoryID = $request->columns[4]['search']['value'];
        }
            if ($request->columns[3]['search']) {
            $productID = $request->columns[3]['search']['value'];
        }
        
        if($dateRange != ''){
            $date_range = $dateRange;
		$date_range = str_replace(' ', '', $date_range);
		$date_range = explode('-', $date_range);
                  $to = Carbon::parse($date_range[1])->format('Y-m-d');
                  $from = Carbon::parse($date_range[0])->format('Y-m-d');   
                 $dateSearch = 1;
    
        }
        
//        print_r($categoryID);die;
        
        if($wareHouseID == '' && $categoryID == '' && $dateRange == '' && $productID == ''){
            $status = 1;
        }else{
         $status = 0;   
        }
        
//        print_r($dateSearch);die;
//
//        $searchArr1 = $request->columns;
//        $except_first_array = array_slice($searchArr1, count($searchArr1)-(count($searchArr1)-1), count($searchArr1));
//        $searchArr = array_slice($searchArr1, count($searchArr1)-(count($searchArr1)-1), count($searchArr1));
//        
//        $searchArr = array_slice($except_first_array, '-' . count($except_first_array), 5);
//      
//         echo "<pre>";print_r($searchArr);die;
        if($status == 1){
        $total_data = DB::table('products')
//                 ->when($searchArr, function ($query) use($searchArr, $start, $limit) {
//                   foreach ($searchArr as $searchRow) {
//                        $searchRowdata = $searchRow['data'];
//                        $searchRowvalue = $searchRow['search']['value'];
//                        $query->orWhere($searchRowdata, "LIKE", "%".$searchRowvalue."%");
//                    }
//                })
                
                ->when($sortBy, function ($query, $sortBy) use($sortDirection) {
                    return $query->orderBy($sortBy, $sortDirection);
                }, function ($query) {
                    return $query->orderBy('product_id', 'desc');
                })   
                ->groupBy('products.product_id')
                ->get();

        $product_list = DB::table('products')               
                ->when($sortBy, function ($query, $sortBy) use($sortDirection) {
                    return $query->orderBy($sortBy, $sortDirection);
                }, function ($query) {
                    return $query->orderBy('product_id', 'desc');
                })
//                ->select("users.*", "roles.id AS role_id", "roles.name AS role_name","designations.name AS designation_name")
//                ->when($searchArr, function ($query) use($searchArr, $start, $limit) {
//                    foreach ($searchArr as $searchRow) {
//                        $searchRowdata = $searchRow['data'];
//                        $searchRowvalue = $searchRow['search']['value'];
//                        $query->orWhere("users.$searchRowdata", "LIKE", "%$searchRowvalue%");
//                    }
//                })
                ->offset($start)
                ->limit($limit)
                        ->groupBy('products.product_id')
                ->get();
        }else{
             
                $total_data = DB::table('products')
//                 ->when($searchArr, function ($query) use($searchArr, $start, $limit) {
//                   foreach ($searchArr as $searchRow) {
//                        $searchRowdata = $searchRow['data'];
//                        $searchRowvalue = $searchRow['search']['value'];
//                        $query->orWhere($searchRowdata, "LIKE", "%".$searchRowvalue."%");
//                    }
//                })
                ->join('purchase_items','products.product_id','=','purchase_items.purchase_product_id')
//                ->join('products','purchase_items.purchase_product_id','=','products.product_id')
//                ->join('purchases','purchase_items.purchase_id','=','purchases.purchase_id')
//                ->where('warehouse_id','=',$wareHouseID)
                        ->where('products.product_is_deleted','=','NO')
                        ->when($categoryID, function ($query) use($categoryID,$wareHouseID,$productID) {
               
                            if($categoryID != ''){
                      
                               $query->where('products.product_category','=', $categoryID);   
                             }
                   if($wareHouseID != ''){
                               $query->where('purchase_items.warehouse_id','=', $wareHouseID);   
                             }
                   if($productID != ''){
                               $query->where('products.product_id','=', $productID);   
                             }
                             return $query;
                }, function ($query) {
                    return $query->orderBy('products.product_id', 'desc');
                })   
                ->groupBy('products.product_id')
                ->get();
                
//                print_r($total_data);die;

        $product_list = DB::table('products') 
                ->join('purchase_items','products.product_id','=','purchase_items.purchase_product_id')
//                ->join('products','purchase_items.purchase_product_id','=','products.product_id')
//                ->join('purchases','purchase_items.purchase_id','=','purchases.purchase_id')
                ->where('products.product_is_deleted','=','NO')
                ->when($categoryID, function ($query) use($categoryID,$wareHouseID,$productID) {
                         if($categoryID != ''){
                      
                               $query->where('products.product_category','=', $categoryID);   
                             }
                   if($wareHouseID != ''){
                               $query->where('purchase_items.warehouse_id','=', $wareHouseID);   
                             }
                   if($productID != ''){
                               $query->where('products.product_id','=', $productID);   
                             }
                             return $query;
                }, function ($query) {
                    return $query->orderBy('product_id', 'desc');
                })
//                ->select("users.*", "roles.id AS role_id", "roles.name AS role_name","designations.name AS designation_name")
//                ->when($searchArr, function ($query) use($searchArr, $start, $limit) {
//                    foreach ($searchArr as $searchRow) {
//                        $searchRowdata = $searchRow['data'];
//                        $searchRowvalue = $searchRow['search']['value'];
//                        $query->orWhere("users.$searchRowdata", "LIKE", "%$searchRowvalue%");
//                    }
//                })
                ->offset($start)
                ->limit($limit)
                ->groupBy('products.product_id')
                ->get(); 
        }
//        echo '<pre>';print_r($total_data);die;
        $data = array();
        $i = 1;

        $user = Auth::user();
//        $user->can('add-vendor');

        foreach ($product_list as $row) {
            // if($wareHouseID == ''){
//             $total_purchase = DB::table("purchase_items")
//                     ->join('purchases','purchase_items.purchase_id','=','purchases.purchase_id')
// //                    ->join('products','purchase_items.purchase_product_id','=','products.product_id')                
//                     ->where('purchase_items.purchase_product_id','=',$row->product_id)
//                     ->when($dateSearch, function ($query, $dateRange) use($from,$to) {
//                         if($from != ''){
// //                            print_r($from);die;
//                              $query->where('purchases.purchase_date','>=', $from)->where('purchases.purchase_date','<=', $to);                              
//                              }
                             
//                              return $query;
                             
                    
//                 },function ($query) {
//                     return $query->where('purchases.purchase_is_deleted', 'NO');
//                 })
//                     ->sum("purchase_items.purchase_product_quantity");
//             $warehouse = DB::table("purchase_items")
// //                    ->select("warehouse_name,warehouse_id")
//                     ->where('purchase_product_id','=',$row->product_id)
//                     ->join('purchases','purchase_items.purchase_id','=','purchases.purchase_id')
//                     ->join('warehouses','purchases.purchase_warehouse_id','=','warehouses.warehouse_id')
                    
//                     ->get();
            
//             $total_purchase_return = DB::table("purchase_return_items")->where('purchase_product_id','=',$row->product_id)->sum("purchase_product_return_quantity");
//             }else{
             $total_purchase = DB::table("purchase_items")
                    //  ->join('purchases','purchase_items.purchase_id','=','purchases.purchase_id')
                     ->where('purchase_items.purchase_product_id','=',$row->product_id)
                    //  ->where('purchases.purchase_warehouse_id','=',$wareHouseID)                     
                     ->sum("purchase_product_quantity");

            $total_purchase_return = DB::table("purchase_return_items")
                    // ->join('purchases','purchase_return_items.purchase_number','=','purchases.purchase_number')
                    ->where('purchase_return_items.purchase_product_id','=',$row->product_id)   
                //    ->where('purchases.purchase_warehouse_id','=',$wareHouseID) 
                    ->sum("purchase_product_return_quantity");
            // }
            $total_sales = DB::table("pos_sale_products")->where('product_id','=',$row->product_id)->sum("quantity");
//            $purchase = DB::table("purchase_items")->select(DB::raw('round(AVG(purchase_product_price),0) as purchase_product_price'))->where('purchase_product_id','=',$row->product_id)->get();
//            $purchase = DB::table("purchase_items")->select(DB::raw('round(AVG(purchase_product_price),0) as purchase_product_price'),DB::raw('round(AVG(purchase_product_total_price),0) as purchase_product_total_price'))->where('purchase_product_id','=',$row->product_id)->get();
        
$total_transfer_to_branch = DB::table("warehouse_to_branch_items")->where('transfer_product_id','=',$row->product_id)->sum("transfer_product_amount");
$total_sales_return = DB::table("invoice_return_products")->where('return_product_id','=',$row->product_id)->sum("return_product_quantity");
            $purchase_unit_price = DB::table("purchase_items")->where('purchase_product_id','=',$row->product_id)->orderBy('purchase_items_id','desc')->limit(1)->get("purchase_product_price");
           if(count($purchase_unit_price) >0){
            $purchase_unit_price =  $purchase_unit_price[0]->purchase_product_price;
           }else{
             $purchase_unit_price = 0;  
           }
            $action = '';
//            print_r($purchase_unit_price);
            $message = 'Are You Sure want to delete';
//            if($user->can('view-user')){
              $action .= "<a class='btn btn-primary btn-sm mr-2' href='employees/" . $row->product_id . "'>View</a>";   
//            }
//           if($user->can('edit-user')){
              $action .= "<a class='btn btn-success btn-sm mr-2' href='employees/" . $row->product_id . "/edit'>Edit</a>";   
//           }
//          if($user->can('delete-user')){
//                    $action .= "<form action='" . route('employees.destroy', $row->id) . "' method='POST' style='display: inline-block;'>"
//                    . csrf_field() . ""
//                    . method_field('DELETE') . "
//                            <button class='btn btn-danger btn-sm' type='submit'>Delete</button>
//                        </form>";   
//          }
              
            
$purchaseAll = $total_purchase - $total_purchase_return;
// print_r($total_purchase);die;
            $stock = ($purchaseAll - $total_transfer_to_branch) - ($total_sales - $total_sales_return);

            $inventory['sl'] = $i;
            $inventory['product_name'] = $row->product_name;
            $inventory['product_code'] = $row->product_entry_id;
//            $inventory['product_attribute'] = "product_attribute";
//            $inventory['product_warehouse'] = "product_warehouse";
            $inventory['purchase_quantity'] = $total_purchase;
            $inventory['transfered_to_branch'] = $total_transfer_to_branch;
            $inventory['sale_quantity'] = $total_sales;
            $inventory['sale_return_quantity'] = $total_sales_return;
            $inventory['purchase_return_quantity'] = $total_purchase_return;
            $inventory['available_stock'] = $stock;
            $inventory['unit_price'] = $purchase_unit_price;
            $inventory['total_price'] = $purchase_unit_price * $stock;

            $data[] = $inventory;
            $i++;
        }
        
        $all_products = DB::table('products')->get();
        $product_list = '';
        foreach ($all_products as $row) {
            $label = $row->product_name . '[' . $row->product_entry_id . ']';
            $value = intval($row->product_id);
            $product_list .= '<option value="'.$value.'">'.$label.'</option>';
        }
        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($total_data),
            "recordsFiltered" => 1,
            "data" => $data,
            'product_list'=>$product_list
        );
        echo json_encode($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.inventory.create_inventory');
    }

    public function inventoryCheck(Request $request)
    {


        $wareHouseID = '';
        $categoryID = '';
        $productID = '';
        $dateRange = '';
        $dateSearch = null;
        $from = '';
        $to = '';

        $wherePurchaseDate = '';

        if ($wareHouseID == '' && $categoryID == '' && $dateRange == '' && $productID == '') {
            $status = 1;
        } else {
            $status = 0;
        }

        $damp = [
            'warehouse' => $request->warehouse,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'product_id' => $request->product_id,
        ];



        return response()->json(
            ['success' => true, 
             'message' => 'Successfully Added', 
             'data' => $damp ]
            
            , 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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