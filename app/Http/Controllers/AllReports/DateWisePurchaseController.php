<?php

namespace App\Http\Controllers\AllReports;

use App\Http\Controllers\Controller;
use App\Models\Product\Purchase;
use Illuminate\Http\Request;

class DateWisePurchaseController extends Controller
{
    public function dateWiseReport(Request $request)
    {


        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = Purchase::join('warehouses', 'purchases.purchase_warehouse_id', '=', 'warehouses.warehouse_id')
            ->whereBetween('purchases.purchase_date', [$startDate, $endDate])
            ->where('purchases.purchase_warehouse_id', $request->warehouse_id)
            ->select('purchases.purchase_number', 'purchases.purchase_quantity', 'purchases.purchase_net_total', 'purchases.purchase_warehouse_id', 'warehouses.warehouse_name')
            ->get();



        $total = Purchase::join('warehouses', 'purchases.purchase_warehouse_id', '=', 'warehouses.warehouse_id')
            ->whereBetween('purchases.purchase_date', [$startDate, $endDate])
            ->where('purchases.purchase_warehouse_id', $request->warehouse_id)
            ->sum('purchase_net_total');




        $result = [
            'purchaseData' => $data,
            'totalPurchase' => $total,
        ];
        return response()->json(['message' => 'Successfull', 'success' => true, 'purchaseData' => $data, 'totalPurchase' => $total], 201);
    }
}
