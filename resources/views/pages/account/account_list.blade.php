@extends('home')
@section('content')
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">List of Account</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="fs-5 color-900 mt-1 mb-0">List of Account.</h1>
                    <small class="text-muted">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </small>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-12 mt-2 mt-md-0">
                    <!-- daterange picker -->
                    <div class="input-group">
                        <button class="btn btn-secondary" style="margin-left: 46%;" type="button" data-bs-toggle="tooltip"
                            title="Create Account"><a style="color: white" href="{{ url('accounts/create') }}">Create
                                Account</a><i class="fa fa-envelope"></i></button>
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
                                    <th>Name</th>
                                    <th>Account Type</th>
                                    <th>Account Number</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th>Balance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($list as $row)
                                    @php
                                        $balance = get_acoount_current_balance_by_account_id($row->account_id);
                                        
                                    @endphp
                                    <tr>
                                        <td class="sorting_{{ $sl }}}">{{ $sl }}</td>
                                        <td>{{ $row->account_name }}</td>
                                        <td>{{ $row->account_type }}</td>
                                        <td>{{ $row->account_number }}</td>
                                        <td>{{ $row->account_bank_name }}</td>
                                        <td>{{ $row->account_branch_name }}</td>
                                        <td>{{ $balance }}</td>
                                        <td>
                                            <a href="{{ 'accounts/' . $row->account_id . '/' . 'edit' }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteNow({{ $row->account_id }})">Delete</button>
                                            <a href="{{ 'accounts/' . $row->account_id }}"
                                                class="btn btn-sm btn-info">View</a>
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
                    url: "accounts" + '/' + params,
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
