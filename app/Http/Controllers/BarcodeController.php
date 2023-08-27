<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barcode\Barcode;
use Illuminate\Http\Request;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Auth;

class BarcodeController extends Controller
{
    // public function index()
    // {
    //     return view('barcode');
    // }

    public function index(Request $request){
	$id = $request->get('id');
	$product = Product::find($id);
	return view('barcode', $product);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create_barcode');
    }
}