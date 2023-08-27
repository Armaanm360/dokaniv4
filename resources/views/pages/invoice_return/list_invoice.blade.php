@extends('home')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> All Pos Sales</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Invoice No</th>
                                    <th>Staff</th>
                                    <th>Client Phone</th>
                                    <th>Client Type</th>
                                    <th>Payment</th>
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
                                        <td>{{ $invoice->client_type }}</td>
                                        <td>{{ getPaymentType($invoice->sale_id) }}</td>
                                        <td>{{ $invoice->sales_date }}</td>
                                        <td>{{ $invoice->grand_total }}</td>
                                        <td>

                                            @if ($invoice->invoice_return == 'NO')
                                                <a href="{{ 'invoice/' . $invoice->sale_id . '/' . 'edit' }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                            @endif

                                            {{-- <button class="btn btn-sm btn-warning"
                                                onclick="deleteNow({{ $invoice->sale_id }})">Delete</button> --}}
                                            <a href="{{ 'invoice-return/' . $invoice->sale_return_id }}"
                                                class="btn btn-sm btn-info">View</a>


                                            <button class="btn btn-sm btn-warning"
                                                onclick="deleteNow({{ $invoice->sale_return_id }})">Delete</button>
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

    <script>
        function deleteNow(params) {
            var isConfirm = confirm('Are You Sure!');
            if (isConfirm) {
                $('.loader').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'DELETE',
                    url: "invoice-return" + '/' + params,
                    success: function(data) {
                        location.reload();
                    }
                }).done(function() {
                    $("#success_msg").html("Data Save Successfully");
                }).fail(function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    var json_data = JSON.parse(data.responseText);
                    $.each(json_data.errors, function(key, value) {
                        $("#" + key).after(
                            "<span class='error_msg' style='color: red;font-weigh: 600'>" +
                            value +
                            "</span>");
                    });
                });
            } else {
                $('.loader').hide();
            }
        }
    </script>
@endsection
