<?php

namespace App\Http\Controllers\Reports\SalesReport;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use Illuminate\Http\Request;

class DateWiseTotalSalesController extends Controller
{
    public function index()
    {
        $branch = Branch::where('branch_status',1)->get();
        return view('pages.report.sales.index',compact('branch'));
    }

    public function datewiseReport(Request $request)
    {
        $branch = $request->branch_id;
        $salestype = $request->customer_type;
        $start_date = date('d/m/Y', strtotime($request->start_date));
        $end_date = date('d/m/Y', strtotime($request->end_date));
 die;

    }
}
