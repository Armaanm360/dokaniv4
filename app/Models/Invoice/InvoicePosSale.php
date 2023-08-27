<?php

namespace App\Models\Invoice;

use App\Models\Branch\Branch;
use Illuminate\Database\Eloquent\Model;

class InvoicePosSale extends Model
{
    protected $table = "invoice_pos_sales";
    protected $primaryKey = "sale_id";
    protected $guarded = [];

    public static function discount($id)
    {
        $data = InvoicePosSale::where('invoice_no', $id)->sum('overall_discount');
        return $data;
    }
    public static function return($id)
    {
        $data = InvoicePosSale::where('invoice_pos_sales.invoice_no', $id)->join('invoice_returns', 'invoice_returns.sale_id', 'invoice_pos_sales.sale_id')->sum('return_amount');
        return $data;
    }
    public static function branch($id)
    {
        $data = InvoicePosSale::where('invoice_pos_sales.invoice_no', $id)->join('branches', 'branches.branch_id', 'invoice_pos_sales.branch_id')->select('branches.branch_name')->get();
        return $data;
    }


    public function branchNew()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
