@extends('home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Today Pos Sales</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Invoice No</th>
                                    <th>Staff</th>
                                    <th>Client Phone</th>
                                    <th>By Sale</th>
                                    <th>Sales Date</th>
                                    <th>Net Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice as $invoice)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $invoice->invoice_no }}</td>
                                        <td>{{ $invoice->staff_name }}</td>
                                        <td>{{ $invoice->client_phone_number }}</td>
                                        <td>Bank</td>
                                        <td>{{ $invoice->sales_date }}</td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>
                                            <a href="{{ 'invoice/' . $invoice->sale_id . '/' . 'edit' }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            {{-- <button class="btn btn-sm btn-warning"
                                                onclick="deleteNow({{ $invoice->sale_id }})">Delete</button> --}}
                                            <a href="{{ 'invoice/' . $invoice->sale_id }}"
                                                class="btn btn-sm btn-info">View</a>

                                            <a href="{{ 'invoice-return-sale/' . $invoice->sale_id }}"
                                                class="btn btn-sm btn-danger">Return</a>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
