<!-- Form section -->
<!-- start: page toolbar -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Datewise Sales Report</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Sales Type</th>
                                    <th>Invoice</th>
                                    <th>Date</th>
                                    <th>Sale Amount</th>
                                    <th>Service Charge</th>
                                    <th>Discount</th>
                            </thead>
                            <tbody>
                                @foreach ($datewise_sales as $sales)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $sales->customer_type }}</td>
                                        <td>{{ $sales->invoice_no }}</td>
                                        <td>{{ $sales->sales_date }}</td>
                                        <td>{{ $sales->subTotal }}</td>
                                        <td>{{ $sales->vat_rate }}</td>
                                        <td>{{ $sales->product_discount }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>Total:</td>
                                    <td>{{$totalSub}}</td>
                                    <td>Service Charge: {{$totaldiscount}}</td>
                                    <td>&nbsp</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- start: page body -->

<!-- end form section -->



