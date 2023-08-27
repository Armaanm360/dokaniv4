@extends('home')
@section('content')
    <!-- Form section -->
    <!-- start: page toolbar -->

    <!-- start: page body -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> User List</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $users)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $users->name }}</td>
                                        <td>{{ $users->email }}</td>
                                        <td>{{ $users->phone }}</td>
                                        <td>{{ $users->role }}</td>
                                        <td><a href="{{ 'users/' . $users->id . '/' . 'edit' }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteUser({{ $users->id }})">Delete</button>
                                            <a href="{{ 'users/' . $users->id }}" class="btn btn-sm btn-info">View</a>
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
        
               function deleteUser(params) {
            var isConfirm = confirm('Are You Sure!');
    if (isConfirm) {          
                    $('.loader').show();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        url: "users" + '/' + params,
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
  
        $(document).ready(function() {


        });


        (document).on();
    </script>
@endsection
