<?php

namespace App\Http\Controllers\AllReports;

use App\Http\Controllers\Controller;
use App\Models\Transfer\WarehouseToBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DateWiseController extends Controller
{
    public function dateWiseReport(Request $request)
    {


        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $data = WarehouseToBranch::join('branches', 'warehouse_to_branches.branch_id', '=', 'branches.branch_id')
            ->join('warehouses', 'warehouse_to_branches.warehouse_id', '=', 'warehouses.warehouse_id')
            ->whereBetween('warehouse_to_branches.transfer_date', [$startDate, $endDate])
            ->select(
                'warehouse_to_branches.branch_id',
                'branches.branch_name',
                'warehouse_to_branches.warehouse_id',
                'warehouses.warehouse_name',
                'warehouse_to_branches.transfer_date',
                'warehouse_to_branches.warehouse_to_branch_transfer_number',
                // 'warehouse_to_branches.total_transfer_quantity'
            )
            ->get();

        return response()->json(['message' => 'Successfull', 'success' => true, 'transfers' => $data], 201);
    }

    public function getProfitLossDatewise(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $profits_losses = Invoice::selectRaw('date, SUM(amount) as invoice_amount')
            ->whereBetween('date', [$start_date, $end_date])
            ->groupBy('date')
            ->get();

        $expenses = Expense::selectRaw('date, SUM(amount) as expense_amount')
            ->whereBetween('date', [$start_date, $end_date])
            ->groupBy('date')
            ->get();

        $purchases = Purchase::selectRaw('date, SUM(amount) as purchase_amount')
            ->whereBetween('date', [$start_date, $end_date])
            ->groupBy('date')
            ->get();

        $results = [];

        foreach ($profits_losses as $pl) {
            $result = [
                'date' => $pl->date,
                'profit_loss' => $pl->invoice_amount - ($expenses->where('date', $pl->date)->sum('expense_amount') + $purchases->where('date', $pl->date)->sum('purchase_amount'))
            ];
            $results[] = $result;
        }

        return response()->json($results);
    }
}
