
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
                        <li class="breadcrumb-item active" aria-current="page">Create Supplier</li>
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
                            <h6 class="card-title mb-0">Create Supplier</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="supplier_form">
                                @csrf
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="supplier_name"
                                            placeholder="Supplier Name" name="supplier_name">
                                        <label class="form-label" for="TextInput">Supplier Name</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="supplier_entry_id"
                                            placeholder="Supplier Entry ID" name="supplier_entry_id" readonly>
                                        <label class="form-label" for="TextInput">Supplier Entry ID</label>
                                    </span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="supplier_phone_number"
                                            placeholder="Supplier Phone" name="supplier_phone_number">
                                        <label class="form-label" for="supplier_phone_number">Supplier Phone</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="email" class="form-control form-control-lg" id="supplier_email"
                                            placeholder="Supplier Email" name="supplier_email">
                                        <label class="form-label" for="supplier_email">Supplier Email</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="supplier_address"
                                            placeholder="Supplier Address" name="supplier_address">
                                        <label class="form-label" for="supplier_address">Supplier Address</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="branch_id"
                                            placeholder="Branch" name="branch_id">
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
                                                name="supplier_transaction_type" id="opbalance">
                                                <option value="" disabled selected>
                                                    {{ __('Select Opening Balance') }}
                                                </option>
                                                <option value="credit">Advance</option>
                                                <option value="debit">Due</option>
                                            </select>
                                            <span>Transaction Type</span>
                                        </label>
                                    </div>

                                    <div class="col-6" id="full_div">
                                        <span class="float-label">
                                            <input type="number" class="form-control form-control-lg" id="balance"
                                                name="supplier_opening_balance">
                                            <label class="form-label" for="emailInput">Opening Balance</label>
                                        </span>
                                    </div>

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
        $('#supplier_name').keyup(function() {
            let rand = $('#supplier_name').val();
            let x = Math.floor((Math.random() * 100000) + 1);

            $('#supplier_entry_id').val(rand + x);

        });



        let balance = $('#full_div').hide();
        let selectaccount = $('#selectaccount').hide();

        $('#opbalance').change(function() {

            let balance = $('#full_div').show();
            let selectaccount = $('#selectaccount').show();

        });

        $("#supplier_form").submit(function(e) {
            e.preventDefault();
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(".error_msg").html('');
            $('.loader').show();
            var data = new FormData($('#supplier_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('suppliers') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    window.location.href = "{{ url('suppliers') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                $('.loader').hide();
                window.location.href = "{{ url('suppliers') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $("#loader").hide();
                $(this).find(':input[type=submit]').prop('enabled', true);
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
