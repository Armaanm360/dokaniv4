@extends('home')
@section('content')
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">List of Account Transfer</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="fs-5 color-900 mt-1 mb-0">List of Account Transfer.</h1>
                    <small class="text-muted">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </small>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-12 mt-2 mt-md-0">
                    <!-- daterange picker -->
                    <div class="input-group">
                        <button class="btn btn-secondary" style="margin-left: 46%;" type="button" data-bs-toggle="tooltip"
                            title="Create"><a style="color: white" href="{{ url('account-transfer/create') }}">Create
                                </a><i class="fa fa-envelope"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Account From</th>
                                    <th>Account To</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($data as $row)
                                    <tr>
                                        <td class="sorting_{{ $sl }}}">{{ $sl }}</td>
                                        <td>{{ get_account_information_by_id($row->account_from)[0]->account_name }}</td>
                                        <td>{{ get_account_information_by_id($row->account_to)[0]->account_name }}</td>
                                        <td>{{ $row->amount }}</td>                                       
                                        <td>
                                           
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteNow({{ $row->transfer_id }})">Delete</button>
                                           
                                        </td>
                                    </tr>
                                    @php
                                        $sl++;
                                    @endphp
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
                        url: "account-transfer" + '/' + params,
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
