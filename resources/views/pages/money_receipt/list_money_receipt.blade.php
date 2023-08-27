@extends('home')
@section('content')
    <!-- Form section -->
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('invoice') }}">Money Receipt</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List of Money Receipt</li>
                    </ol>
                </div>


              

               
            </div>
        </div>
    </div>

    <!-- start: page body -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3>List of Money Receipt</h3>

                        <div class="col text-md-end">
                            <a class="btn btn-primary" href="{{ url('money-receipt/create') }}"><i class="fa fa-list me-2"></i>Create
                                Money Receipt</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Voucher No.</th>
                                    <th>Client</th>
                                    <th>Amount</th>
                                    <th>Discount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{$row->money_receipt_voucher_no}}</td>
                                        <td>{{ $row->client_name }}</td>
                                        <td>{{ $row->money_receipt_total_amount }}</td>
                                        <td>{{ $row->money_receipt_total_discount }}</td>
                                        <td><a href="{{ 'money-receipt/' . $row->money_receipt_invoice_no . '/' . 'edit' }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteMoneyReciept({{ $row->money_receipt_id  }})">Delete</button>
                                            <a href="{{ 'money-receipt/' . $row->money_receipt_id  }}"
                                                class="btn btn-sm btn-info">View</a>
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
    <!-- end form section -->


    <script type="text/javascript">
        
                function deleteMoneyReciept(params) {
            var isConfirm = confirm('Are You Sure!');
    if (isConfirm) {          
                    $('.loader').show();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        url: "money-receipt" + '/' + params,
                        success: function(data) {
                            location.reload();
                        }
                    }).done(function() {
                        $("#success_msg").html("Data Deleted Successfully");
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
        
//        function deleteMoneyReciept(params) {
//            Swal.fire({
//                title: 'Do You Want To Delete The Money Receipt?',
//                showCancelButton: true,
//                confirmButtonText: 'Delete',
//            }).then((result) => {
//                /* Read more about isConfirmed, isDenied below */
//                if (result.isConfirmed) {
//                    let getuser_id = $("[name=id]").val();
//                    $('#loader').show();
//                    $.ajax({
//                        headers: {
//                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                        },
//                        type: 'DELETE',
//                        url: "money-receipt" + '/' + params,
//                        success: function(data) {
//                            window.location.href = "{{ url('money-receipt') }}/";
//
//                        }
//                    }).done(function() {
//                        $("#success_msg").html("Data Save Successfully");
//                        Swal.fire('Money Receipt Has Been Deleted', '', 'success')
//                    }).fail(function(data, textStatus, jqXHR) {
//                        $('#loader').hide();
//                        var json_data = JSON.parse(data.responseText);
//                        $.each(json_data.errors, function(key, value) {
//                            $("#" + key).after(
//                                "<span class='error_msg' style='color: red;font-weigh: 600'>" +
//                                value +
//                                "</span>");
//                        });
//                    });
//
//
//                } else if (result.isDenied) {
//                    Swal.fire('Changes are not saved', '', 'info')
//                }
//            })
//        }
      
    </script>
@endsection

