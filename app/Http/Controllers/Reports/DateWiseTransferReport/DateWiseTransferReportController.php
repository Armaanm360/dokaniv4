<?php

namespace App\Http\Controllers\Reports\DateWiseTransferReport;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DateWiseTransferReportController extends Controller
{
    public function index()
    {
        return view('pages.report.datewisetransfer.index');
    }
    public function transferReport(Request $request)
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
		$start1 = date('d-m-Y', strtotime( str_replace('/', '-', $from)));
		$end1 = date('d-m-Y', strtotime( str_replace('/', '-', $to)));

        $warehouse_to_warehouse_out = DB::table('pos_transfers')->where('has_deleted','NO')->where('fromWarehouseID',$warehouse)->whereBetween('transferDate',[$start1,$end1])->get();
        $warehouse_to_warehouse_in = DB::table('pos_transfers')->where('has_deleted','NO')->where('toWarehouseID',$warehouse)->whereBetween('transferDate',[$start1,$end1])->get();
        $warehouse_to_branch = DB::table('warehouse_to_branches')->where('warehouse_to_branch_transfer_is_deleted','NO')->where('warehouse_id',$warehouse)->whereBetween('transfer_date',[$start1,$end1])->get();

        return view('pages.report.datewisetransfer.get_transfer_report',compact('warehouse_to_warehouse_out','warehouse_to_warehouse_in','warehouse_to_branch'));
    }
}
