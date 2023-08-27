<?php

namespace App\Http\Controllers\Reports\SalesReport;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateWiseSalesController extends Controller
{
    public function index()
    {
        $branch = Branch::where('branch_status',1)->get();
        return view('pages.report.sales.index',compact('branch'));
    }

    public function datewiseReport(Request $request)
    {
        $branch = $request->branch_id;
        $customerType = $request->customer_type;
        $date_range = $request->daterange;
		$date_range = str_replace(' ', '', $date_range);
		$date_range = explode('-', $date_range);
        $to = Carbon::parse($date_range[1])->format('Y/m/d');
        $from = Carbon::parse($date_range[0])->format('Y/m/d');
		$data['from'] = date('Y-m-d', strtotime( str_replace('/', '-', $from)));
		$data['to'] = date('Y-m-d', strtotime( str_replace('/', '-', $to)));
		// $start = date('Y-m-d', strtotime( str_replace('/', '-', $from)));
		// $end = date('Y-m-d', strtotime( str_replace('/', '-', $to)));
		$start1 = date('d-m-y', strtotime( str_replace('/', '-', $from)));
		$end1 = date('d-m-y', strtotime( str_replace('/', '-', $to)));


        $datewise_sales = DB::table('invoice_pos_sales')->where('invoice_has_deleted','NO')->where('branch_id',$branch)->where('customer_type',$customerType)->whereBetween('sales_date',[$start1,$end1])->get();
        $totalSub = DB::table('invoice_pos_sales')->where('invoice_has_deleted','NO')->where('branch_id',$branch)->where('customer_type',$customerType)->whereBetween('sales_date',[$start1,$end1])->sum('subTotal');
        $totaldiscount = DB::table('invoice_pos_sales')->where('invoice_has_deleted','NO')->where('branch_id',$branch)->where('customer_type',$customerType)->whereBetween('sales_date',[$start1,$end1])->sum('product_discount');
        return view('pages.report.sales.get_sales_report',compact('datewise_sales','totalSub','totaldiscount'));

    }
}
