
 @extends('home')
 @section('content')
<!-- Form section -->
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Suppliers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Supplier</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('suppliers') }}"><i class="fa fa-list me-2"></i>List Suppliers</a>
                    {{-- <a class="btn btn-secondary" href="{{ 'agents/create' }}"><i class="fa fa-user me-2"></i>Create
    Agent</a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- start: page body -->
    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container-fluid">
            <div class="row g-3">


                <!-- Form Validation -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Edit Supplier</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="supplier_form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="supplier_id" value="{{$data->supplier_id}}">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="supplier_name"
                                            placeholder="Supplier Name" name="supplier_name" value="{{$data->supplier_name}}">
                                        <label class="form-label" for="TextInput">Supplier Name</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="supplier_entry_id"
                                            placeholder="Supplier Entry ID" name="supplier_entry_id" value="{{$data->supplier_entry_id}}" readonly>
                                        <label class="form-label" for="TextInput">Supplier Entry ID</label>
                                    </span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="supplier_phone_number"
                                            placeholder="Supplier Phone" name="supplier_phone_number" value="{{$data->supplier_phone_number}}">
                                        <label class="form-label" for="supplier_phone_number">Supplier Phone</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="email" class="form-control form-control-lg" id="supplier_email"
                                            placeholder="Supplier Email" name="supplier_email" value="{{$data->supplier_email}}">
                                        <label class="form-label" for="supplier_email">Supplier Email</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="supplier_address"
                                            placeholder="Supplier Address" name="supplier_address" value="{{$data->supplier_address}}">
                                        <label class="form-label" for="supplier_address">Supplier Address</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="branch_id"
                                            placeholder="Branch" name="branch_id" value="{{$data->branch_id}}">
                                        <label class="form-label" for="branch_id">Branch</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input class="form-control" type="file" id="filecheck" name="supplier_image" accept=".jpg,.png,.jpeg">
                                        <label class="form-label" for="supplier_image">Supplier Image</label>
                                    </span>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label class="form-group float-label">
                                            <select class="form-control form-control-lg custom-select"
                                                name="supplier_transaction_type" id="">
                                                <option value="" disabled selected>
                                                    {{ __('Select Opening Balance') }}
                                                </option>
                                                <option value="credit">Advance</option>
                                                <option value="debit">Due</option>
                                            </select>
                                            <span>Transaction Type</span>
                                        </label>
                                    </div>

                                    <div class="col-6" id="">
                                        <span class="float-label">
                                            <input type="number" class="form-control form-control-lg" id="balance"
                                                name="supplier_opening_balance" value="{{$data->supplier_opening_balance}}">
                                            <label class="form-label" for="emailInput">Opening Balance</label>
                                        </span>
                                    </div>

                                </div>



                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
        $("#supplier_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#supplier_form')[0]);
            let getpassport_id = $("[name=supplier_id]").val();
            $('#loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('suppliers') }}/" + $("[name=supplier_id]").val(),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    window.location.href = "{{ url('suppliers') }}";
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

        var uploadField = document.getElementById("filecheck");

            uploadField.onchange = function() {
                if(this.files[0].size > 2097152){
                alert("File is too big!");
                this.value = "";
                };
            };
    </script>


@endsection
