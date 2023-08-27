<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DateWiseTransferReportController extends Controller
{
    public function indexPage()
    {
        return view('pages.products.create_products');
    }
}