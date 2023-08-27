<?php

namespace App\Http\Controllers\Reports\PurchaseReport;

use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;
use App\Models\Warehouse\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateWisePurchaseController extends Controller
{
    public function index()
    {
        $warehouse = Warehouse::where('warehouse_status',1)->get();
        return view('pages.report.purchase.date_wise_purchase_index',compact('warehouse'));
    }

    public function purchaseReport(Request $request)
    {
        $warehouse = $request->warehouse_id;
        $date_range = $request->daterange;
		$date_range = str_replace(' ', '', $date_range);
		$date_range = explode('-', $date_range);
        $to = Carbon::parse($date_range[1])->format('Y/m/d');
        $from = Carbon::parse($date_range[0])->format('Y/m/d');
		$data['from'] = date('Y-m-d', strtotime( str_replace('/', '-', $from)));
		$data['to'] = date('Y-m-d', strtotime( str_replace('/', '-', $to)));
		// $start = date('Y-m-d', strtotime( str_replace('/', '-', $from)));
		// $end = date('Y-m-d', strtotime( str_replace('/', '-', $to)));
		$start1 = date('Y-m-d', strtotime( str_replace('/', '-', $from)));
		$end1 = date('Y-m-d', strtotime( str_replace('/', '-', $to)));


        $datewise_purchase = DB::table('purchases')->where('purchase_is_deleted','NO')->where('purchase_warehouse_id',$warehouse)->whereBetween('purchase_date',[$start1,$end1])->get();

        $totalpurchases = DB::table('purchases')->where('purchase_is_deleted','NO')->where('purchase_warehouse_id',$warehouse)->whereBetween('purchase_date',[$start1,$end1])->sum('purchase_quantity');

        return view('pages.report.purchase.date_wise_purchase_report',compact('datewise_purchase','totalpurchases'));

    }
}
