<?php

namespace App\Http\Controllers\AllReports;

use App\Http\Controllers\Controller;
use App\Models\Expense\Expense;
use App\Models\Invoice\InvoicePosSale;
use App\Models\Product\Purchase;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    public function getProfitLossDatewise(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $profits_losses = InvoicePosSale::selectRaw('invoice_date, SUM(grand_total) as invoice_amount')
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->groupBy('invoice_date')
            ->get();

        $expenses = Expense::selectRaw('expense_date, SUM(expense_amount) as expense_amount')
            ->whereBetween('expense_date', [$start_date, $end_date])
            ->groupBy('expense_date')
            ->get();

        $purchases = Purchase::selectRaw('purchase_created_at, SUM(purchase_net_total) as purchase_amount')
            ->whereBetween('purchase_created_at', [$start_date, $end_date])
            ->groupBy('purchase_created_at')
            ->get();

        $results = [];

        foreach ($profits_losses as $pl) {
            $result = [
                'date' => $pl->invoice_date,
                'profit_loss' => $pl->invoice_amount - ($expenses->where('date', $pl->date)->sum('expense_amount') + $purchases->where('date', $pl->date)->sum('purchase_amount'))
            ];
            $results[] = $result;
        }
        return response()->json(['message' => 'Successfull', 'success' => true, 'purchaseData' => $results], 201);
    }
}
