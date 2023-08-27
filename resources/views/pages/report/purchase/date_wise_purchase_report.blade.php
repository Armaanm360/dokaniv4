<!-- Form section -->
<!-- start: page toolbar -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Datewise Purchase Report</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Purchase Date</th>
                                    <th>Purchase Number</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                            </thead>
                            <tbody>
                                @foreach ($datewise_purchase as $purchase)
                                @php
                                    $supplier = "";
                                    $supplierdata = App\Models\Supplier\Supplier::supplier($purchase->purchase_supplier_id);
                                    if($supplierdata)
                                    {
                                        $supplier = $supplierdata->supplier_name;
                                    }
                                @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $purchase->purchase_date }}</td>
                                        <td>{{ $purchase->purchase_number }}</td>
                                        <td>{{ $supplier }}</td>
                                        <td>{{ $purchase->purchase_quantity }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>&nbsp</td>
                                    <td>Total:</td>
                                    <td>{{$totalpurchases}}</td>
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



