@extends('home')
@section('content')
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Accounts Balance Statement</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="fs-5 color-900 mt-1 mb-0">Accounts Balance Statement</h1>
                    <small class="text-muted">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </small>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-12 mt-2 mt-md-0">
                    <!-- daterange picker -->
             
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
                                    <th>Account</th>
                                    <th>Account Number</th>
                                    <th>Bank</th>
                                    <th>Branch</th>
                                    <th>Balance</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($data as $row)
                                    <tr>
                                        <td class="sorting_{{ $sl }}}">{{ $sl }}</td>
                                        <td>{{ $row->account_name }}</td>
                                        <td>{{ $row->account_number }}</td>
                                        <td>{{ $row->account_bank_name }}</td>                                       
                                        <td>{{ $row->account_branch_name }}</td>                                       
                                        <td>{{ $row->account_balance }}</td>
                                        <td><a href="{{ url('account/account-statement/' . $row->account_id) }}"
                                                class="btn btn-sm btn-warning">Statement</a></td>
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
   
@endsection
