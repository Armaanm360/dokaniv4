<!DOCTYPE html>
<html lang="en">

@include('layouts.admin.headerlink')

@yield('content')

<?php
$company = \Illuminate\Support\Facades\DB::table('company_infos')->first();
$staff = \Illuminate\Support\Facades\DB::table('staff')
    ->where('staff_id', Auth::user()->id)
    ->first();

//print_r($pos_sale);

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <div id="printableArea">
                <div class="logo text-center">
                    <br>
                    <img src="{{ asset('public/assets/logo.png') }}" alt="Your Company Logo">
                    <p>{{ $company->company_address }}</p>
                </div>
                <br>
                <h2 class="text-center text-danger">Supllier Payment</h2>
                <div class="info text-center">
                    <h4>{{ $company->company_name }}</h4>
                    <b>Cell: {{ $company->company_phone }}</b>
                    <p><b>BIN: 002256834-0201 Mushak-2.3</b></p>
                    {{-- <pre>Invoice: {{ $pos_sale->invoice_no }}</pre> --}}
                </div>
                <div class="row">
                    <div class="col-6">
                        <ul style="list-style:none">
                            <li>Payment Date: {{ $supply[0]->supplier_transaction_date }}</li>
                            <li>Payment To: {{ $supply[0]->supplier_name }}</li>
                            <li>Phone Number: {{ $supply[0]->supplier_phone_number }}</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul style="list-style:none">
                            <li>Staff Id: {{ Auth::user()->name }}</li>
                            <li>Payment Method: {{ $supply[0]->supplier_transaction_date }}</li>
                        </ul>

                    </div>
                </div>
                <br>
                <div class="row">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td colspan="6" style="font-weight:bold;font-size: 18px;">
                                    Supplier Payment History
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="width:5%;">SL.</th>
                                <th style="width:20%">Date</th>
                                <th style="width:20%">Supplier</th>
                                <th style="width:20%">Account</th>
                                <th>Payment</th>
                                <th>Note</th>
                            </tr>


                            <tr>
                                <td>1</td>
                                <td>{{ $supply[0]->supplier_transaction_date }}</td>
                                <td>{{ $supply[0]->supplier_name }}</td>
                                <td></td>
                                <td>{{ $supply[0]->supplier_transaction_amount }}</td>
                                <td>{{ $supply[0]->supplier_transaction_note }}</td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right;color:green;font-weight: bold;" colspan="4"> Total
                                    Payment : </td>
                                <td style="color:green;font-weight: bold;">
                                    {{ $supply[0]->supplier_transaction_amount }}/=</td>

                            </tr>
                        </tfoot>


                        <tfoot>
                        </tfoot>
                    </table>
                    <table class="table table-striped">

                    </table>
                </div>

            </div>
            <div class="row">
                <button class="btn btn-larage btn-info mb-2" onclick="printDiv('printableArea')">Print</button>

                <a class="btn btn-larage btn-primary mb-2" href="{{ url('supplier-payment') }}">Back to Pos</a>
            </div>



        </div>
        <div class="col-4"></div>
    </div>
</div>

<script>
    function printDiv(elementId) {
        var divContents = document.getElementById(elementId).innerHTML;
        var a = window.open('', '', 'height=1200, width=1200');
        a.document.write('<html>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();
    }
</script>
<!-- Jquery Page Js -->
@include('layouts.admin.footerlink')
