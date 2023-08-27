<!-- Form section -->
<!-- start: page toolbar -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Client Ledger Datewise Report</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Branch</th>
                                    <th>Date</th>
                                    <th>Debit</th>
                                    <th>Discount</th>
                                    <th>Return</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                            </thead>
                            <tbody>
                                @foreach ($client_ledger as $ledger)
                                @php
                                    $ledger_discount = "";
                                    $ledger_return = "";
                                    $branch_data = "";
                                    $discount = App\Models\Invoice\InvoicePosSale::discount($ledger->client_ledger_invoice_id);
                                    if($discount)
                                    {
                                        $ledger_discount = $discount;
                                    }
                                    $return = App\Models\Invoice\InvoicePosSale::return($ledger->client_ledger_invoice_id);
                                    if($return)
                                    {
                                        $ledger_return = $return;
                                    }

                                    $branch = App\Models\Invoice\InvoicePosSale::branch($ledger->client_ledger_invoice_id);
                                    if($branch)
                                    {
                                        $branch_data = $return->branch_name;
                                    }
                                @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{$branch_data}}</td>
                                        <td>{{ $ledger->client_ledger_date }}</td>
                                        <td>{{ $ledger->client_ledger_dr }}</td>
                                        <td>{{$discount}}</td>
                                        <td>{{$ledger_return}}</td>
                                        <td>{{ $ledger->client_ledger_cr }}</td>
                                        <td>{{ $ledger->client_ledger_last_balance }}</td>
                                    </tr>
                                @endforeach


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



