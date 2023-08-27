<!-- Form section -->
<!-- start: page toolbar -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Purchase History</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Purchase Date</th>
                                    <th>Grandtotal</th>
                                    <th>Discount</th>
                                    <th>Nettotal</th>
                            </thead>
                            <tbody>
                                @foreach ($supplier_purchase as $purchase)
                                {{-- @php
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
                                @endphp --}}
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $purchase->purchase_date }}</td>
                                        <td>{{ $purchase->purchase_subtotal }}</td>
                                        <td>{{ $purchase->purchase_discount }}</td>
                                        <td>{{ $purchase->purchase_net_total }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ $subtotal }}</td>
                                    <td>{{ $discount }}</td>
                                    <td>{{ $nettotal }}</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Payment History</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    {{-- <th>Account</th> --}}
                                    <th>Payment</th>
                                    <th>Note</th>
                            </thead>
                            <tbody>
                                @foreach ($supplier_payment as $payment)
                                {{-- @php
                                    $account = "";
                                    $info = App\Models\Accounts\Accounts::account($payment->transactionAccountID);
                                    if($account_name)
                                    {
                                        $account = $info->account_name;
                                    }
                                @endphp --}}
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $payment->supplier_transaction_date }}</td>
                                        {{-- <td>{{ $account }}</td> --}}
                                        {{-- <td>{{ $payment->supplier_payment_type }}</td> --}}
                                        <td>{{ $payment->supplier_transaction_amount }}</td>
                                        <td>{{ $payment->supplier_transaction_note }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td>Total</td>
                                    <td>{{ $supplier_payment_total }}</td>
                                    <td></td>
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



