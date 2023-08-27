<?php

namespace App\Http\Controllers\Reports\ClientLedger;

use App\Http\Controllers\Controller;
use App\Models\Client\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientLedgerController extends Controller
{
    public function index()
    {
        $client = Client::where('client_is_deleted','NO')->get();
        return view('pages.report.clientledger.index',compact('client'));
    }
    public function clientLedgerReport(Request $request)
    {
        $client = $request->client_id;
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

        $client_ledger = DB::table('client_ledgers')->where('client_id',$client)->whereBetween('client_ledger_date',[$start1,$end1])->get();

        return view('pages.report.clientledger.get_client_ledger_report',compact('client_ledger'));
    }
}
