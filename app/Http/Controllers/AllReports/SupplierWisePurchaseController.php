<?php

namespace App\Http\Controllers\AllReports;

use App\Http\Controllers\Controller;
use App\Models\Product\Purchase;
use Illuminate\Http\Request;

class SupplierWisePurchaseController extends Controller
{
    public function supplierWiseReport(Request $request)
    {


        // $data = Purchase::with('supplier')
        //     ->where('purchase_supplier_id', $request->supplier_id)
        //     ->get(['purchase_number', 'purchase_quantity', 'purchase_net_total', 'purchase_supplier_id']);


        $data = Purchase::where('purchase_supplier_id', $request->supplier_id)->join('suppliers', 'suppliers.supplier_id', '=', 'purchases.purchase_supplier_id')->get(['supplier_name', 'purchase_number', 'purchase_date', 'purchase_net_total', 'purchase_quantity']);


        $total =
            Purchase::where('purchase_supplier_id', $request->supplier_id)->join('suppliers', 'suppliers.supplier_id', '=', 'purchases.purchase_supplier_id')->sum('purchase_net_total');

        $result = [
            'purchaseData' => $data,
            'totalPurchase' => $total,
        ];


        // Encode the data as JSON
        //$jsonData = json_encode($result);

        // Return the JSON response
        return response()->json(['message' => 'Successfull', 'success' => true, 'purchaseData' => $data, 'totalPurchase' => $total], 201);
    }
}
