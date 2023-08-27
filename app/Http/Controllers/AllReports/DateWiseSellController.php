<?php

namespace App\Http\Controllers\AllReports;

use App\Http\Controllers\Controller;
use App\Models\Invoice\InvoicePosSale;
use Illuminate\Http\Request;

class DateWiseSellController extends Controller
{
    public function dateWiseReport(Request $request)
    {


        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = InvoicePosSale::join('branches', 'invoice_pos_sales.branch_id', '=', 'branches.branch_id')

            ->where('invoice_pos_sales.branch_id', $request->branch_id)
            ->whereBetween('invoice_pos_sales.sales_date', [$startDate, $endDate])
            ->select('invoice_no', 'sales_date', 'grand_total', 'branch_name')
            ->get();




        $total =
            InvoicePosSale::join('branches', 'invoice_pos_sales.branch_id', '=', 'branches.branch_id')
            ->where('invoice_pos_sales.branch_id', $request->branch_id)
            ->whereBetween('invoice_pos_sales.sales_date', [$startDate, $endDate])
            ->sum('grand_total');

        $newtotal = intval($total);


        $result = [
            'salesData' => $data,
            'totalSalesAmount' => $total,
        ];


        // Encode the data as JSON
        $jsonData = json_encode($result);

        // Return the JSON response
        //return response($jsonData)->header('Content-Type', 'application/json');

        return response()->json(['message' => 'Successfull', 'success' => true, 'salesData' => $data, 'totalSalesAmount' => $newtotal], 201);
    }
}
