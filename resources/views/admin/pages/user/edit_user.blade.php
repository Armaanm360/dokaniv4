@extends('home')
@section('content')
    <!-- Form section -->
    <!-- start: page toolbar -->

    <!-- start: page body -->
    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Edit User</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="add_form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" class="form-control" name="id" id="id"
                                    value="{{ $userData->id }}" placeholder="Enter Name">
                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="TextInput"
                                            placeholder="Name" name="name" value="{{ $userData->name }}">
                                        <label class="form-label" for="TextInput">Name</label>
                                    </span>
                                </div>


                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="TextInput"
                                            placeholder="Email" name="email" value="{{ $userData->email }}">
                                        <label class="form-label" for="TextInput">Email</label>
                                    </span>
                                </div>
                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="password" class="form-control form-control-lg" id="TextInput"
                                            placeholder="password" name="password">
                                        <label class="form-label" for="TextInput">Password</label>
                                    </span>
                                </div>
<!--                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="emailInput"
                                            placeholder="Phone" name="phone" value="">
                                        <label class="form-label" for="emailInput">Phone</label>
                                    </span>
                                </div>-->
                                <div class="col-6">
                                    <label class="form-group float-label">

                                        <select class="form-control form-control-lg custom-select" name="role"
                                            id="role" style="width: 100%">
                                            <option value="" disabled>
                                                {{ __('Select Role') }}
                                            </option>
                                            @foreach ($all_roles as $row)
                                                <option value="{{ $row->id }}"
                                                    @if ($userData->role_id == $row->id) selected @endif>
                                                    {{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        <span>Role</span>
                                    </label>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div> <!-- .row end -->

        </div>
    </div>
    <!-- end form section -->

    <script type="text/javascript">
        $("#add_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#add_form')[0]);
            let getuser_id = $("[name=id]").val();
            $('#loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('users') }}/" + $("[name=id]").val(),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    window.location.href = "{{ url('users') }}/" + getuser_id;
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                //window.location.href = "{{ url('users') }}/";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $('#loader').hide();
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });
    </script>
@endsection
