<?php

namespace App\Http\Controllers\Pdf;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
     public function create()
    {
    	$data = ['title' => 'Dokani'];
        $pdf = PDF::loadView('pdf', $data);
  
       // return view('pdf');
       return $pdf->download('Dokani.pdf');
    }
}