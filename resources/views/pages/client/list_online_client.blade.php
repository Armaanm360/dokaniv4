@extends('home')
@section('content')
<!-- Form section -->
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Clients</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List of Online Clients</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('client/create') }}"><i class="fa fa-list me-2"></i>Create
                        Client</a>
                    {{-- <a class="btn btn-secondary" href="{{ 'agents/create' }}"><i class="fa fa-user me-2"></i>Create
                        Agent</a> --}}
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
                        <h3>Online Client List</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Photo</th>
                                    <th>Client Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Branch</th>
                                    <th>Type</th>
                                    <th>Supplier Entry ID</th>
                                    <th>Due Amount</th>
                                    {{-- <th>Address</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientList as $client)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if($client->client_image != null)
                                            <img src="{{ asset('public').'/'.$client->client_image }}" alt="" width="30px" height="30px">
                                            @endif
                                        </td>
                                        <td>{{ $client->client_name }}</td>
                                        <td>{{ $client->client_phone_number }}</td>
                                        <td>{{ $client->client_email }}</td>
                                        <td>{{ $client->branch_name }}</td>
                                        <td>{{ $client->client_type }}</td>
                                        <td>{{ $client->client_entry_id }}</td>
                                        <td>Due Amount</td>
                                        {{-- <td>{{ $client->client_address }}</td> --}}
                                        <td>
                                            <a href="{{ 'client/' . $client->client_id . '/' . 'edit' }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteNow({{ $client->client_id }})">Delete</button>
                                            <a href="{{ 'client/' . $client->client_id }}"
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

        function deleteNow(params) {

        var isConfirm = confirm('Are You Sure!');
        if (isConfirm) {

        $('.loader').show();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'DELETE',
                    url: "client" + '/' + params,
                    success: function(data) {
                        location.reload();

                    }
                }).done(function() {
                    $("#success_msg").html("Data Save Successfully");
                    //window.location.href = "{{ url('users') }}/";
                    Swal.fire('Client Has Been Deleted', '', 'success')
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




        // })
        }


    </script>
@endsection
