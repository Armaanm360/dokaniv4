<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\ExpenseHead\ExpenseHead;
use App\Models\ExpenseSubhead\ExpenseSubHead;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getSubHead($headid)
    {

        $subhead = ExpenseSubHead::where('expense_head_id', $headid)->get();

        $output = '';
        $output .= '';
        foreach ($subhead as $row) {
            $output .= '<option value="' . $row->expense_sub_head_id  . '">' . $row->title .'</option>';
        }
        return $output;
    }
}
