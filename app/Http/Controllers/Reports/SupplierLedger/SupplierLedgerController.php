<?php

namespace App\Http\Controllers\Reports\SupplierLedger;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierLedgerController extends Controller
{
    public function index()
    {
        $supplier = Supplier::where('supplier_is_deleted','NO')->get();
        return view('pages.report.supplier_ledger.index',compact('supplier'));
    }
    public function supplierLedgerReport(Request $request)
    {
        $supplier = $request->supplier_id;
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

        $supplier_purchase = DB::table('purchases')->where('purchase_supplier_id',$supplier)->whereBetween('purchase_date',[$start1,$end1])->get();
        $supplier_payment = DB::table('supplier_transactions')->where('supplier_transaction_supplier_id',$supplier)->whereBetween('supplier_transaction_date',[$start1,$end1])->get();
        $supplier_payment_total = DB::table('supplier_transactions')->where('supplier_transaction_supplier_id',$supplier)->whereBetween('supplier_transaction_date',[$start1,$end1])->sum('supplier_transaction_amount');
        $subtotal = DB::table('purchases')->where('purchase_supplier_id',$supplier)->whereBetween('purchase_date',[$start1,$end1])->sum('purchase_subtotal');
        $discount = DB::table('purchases')->where('purchase_supplier_id',$supplier)->whereBetween('purchase_date',[$start1,$end1])->sum('purchase_subtotal');
        $nettotal = DB::table('purchases')->where('purchase_supplier_id',$supplier)->whereBetween('purchase_date',[$start1,$end1])->sum('purchase_subtotal');

        return view('pages.report.supplier_ledger.get_supplier_ledger_report',compact('supplier_purchase','discount','nettotal','subtotal','supplier_payment','supplier_payment_total'));
    }
}
