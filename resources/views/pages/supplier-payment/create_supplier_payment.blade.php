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
                        <li class="breadcrumb-item active" aria-current="page">Supplier Payment</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('suppliers') }}"><i class="fa fa-list me-2"></i>List
                        Suppliers</a>
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


                <div class="col-3"></div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Supplier Payment</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="supplier_form">
                                @csrf
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="search_supplier"
                                            placeholder="Supplier*" name="supplier">
                                        <label class="form-label" for="TextInput">Supplier *</label>
                                    </span>
                                    <input type="hidden" name="hiddenSupplierId" id="hiddenSupplierId">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="due_remaining"
                                            placeholder="Due Remaining" name="due_remaining" readonly>
                                        <label class="form-label" for="TextInput">Due Remaining</label>
                                    </span>
                                </div>
                                {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                                    <span class="float-label">
                                        <label for="exampleFormControlSelect1">Adjust Advance</label>
                                        <select class="form-control form-control-lg" id="adjust_advance"
                                            name="adjust_advance">
                                            <option value="yes">Yes</option>
                                            <option value="no" selected>No</option>
                                        </select>
                                    </span>
                                </div> --}}
                                <div class="col-lg-12 col-md-12 col-sm-12" id="accounts_div">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="account_get"
                                            placeholder="Accounts *" name="account">
                                        <input type="hidden" class="form-control form-control-lg" id="hiddenAccId"
                                            placeholder="Accounts *" name="hiddenAccId">


                                        <input type="hidden" class="form-control form-control-lg" id="amount_check"
                                            placeholder="Accounts *" name="amount_check">
                                        <label class="form-label" for="TextInput">Accounts</label>
                                    </span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12" id="amount_div">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="amount"
                                            placeholder="Amount" name="amount">
                                        <label class="form-label" for="TextInput">Amount</label>
                                    </span>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12" id="available_balance_div">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="available_balance"
                                            placeholder="" name="available_balance">
                                        <label class="form-label" for="Available Balance">Available Balance</label>
                                    </span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12" id="adjust_amount_div">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg" id="adjust_amount"
                                            placeholder="" name="adjust_amount">
                                        <label class="form-label" for="Ajust An">Adjust Amount</label>
                                    </span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="date"
                                            placeholder="Date" name="date" value="{{ date('Y-m-d') }}" readonly>
                                        <label class="form-label" for="TextInput">Date</label>
                                    </span>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <span class="float-label">
                                        <textarea name="note" id="note" cols="30" rows="5"></textarea>
                                        <label class="form-label" for="TextInput">Note</label>
                                    </span>
                                </div>





                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>


                <!-- Form Validation -->
                {{-- <div class="col-12">
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
                                        <input type="number" class="form-control form-control-lg"
                                            id="supplier_phone_number" placeholder="Supplier Phone"
                                            name="supplier_phone_number">
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
                                        <input class="form-control" type="file" id="filecheck" name="supplier_image"
                                            accept=".jpg,.png,.jpeg">
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
                </div> --}}
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

        $('#available_balance_div').hide();
        $('#adjust_amount_div').hide();
        $('#accounts_div').show();
        $('#amount_div').show();
        $('#adjust_advance').change(function() {
            let adjust_advance = $('#adjust_advance').find(":selected").val();

            if (adjust_advance == 'yes') {

                $('#available_balance_div').show();
                $('#adjust_amount_div').show();
                $('#accounts_div').hide();
                $('#amount_div').hide();

            }

            if (adjust_advance == 'no') {
                $('#available_balance_div').hide();
                $('#adjust_amount_div').hide();
                $('#accounts_div').show();
                $('#amount_div').show();
            }
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
                url: "{{ url('supplier-payment') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    window.location.href = "{{ url('supplier-payment') }}" + '/' + data
                        .supplier_transaction;
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                // $('.loader').hide();
                // window.location.href = "{{ url('suppliers') }}";
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

        // var uploadField = document.getElementById("filecheck");

        // uploadField.onchange = function() {
        //     if (this.files[0].size > 2097152) {
        //         alert("File is too big!");
        //         this.value = "";
        //     };
        // };




        $('#search_supplier').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search_supplier_info') }}",
                    dataType: "json",
                    data: {
                        q: request.term,
                    },
                    success: function(data) {
                        response(data.content);
                    }
                });
            },
            select: function(event, ui) {
                $(this).val(ui.item.label);
                $('#hiddenSupplierId').val(ui.item.value);
                $('#due_remaining').val(ui.item.supplier_current_bal);
                let showClient =
                    '<textarea class="form-control address" disabled style="background:white;margin-top:10px">\nb' +
                    ui.item.client_name + '\nb' + ui.item.value + '\nb' + ui.item.client_address +
                    '\nb' + ui.item.client_phone + '</textarea>';

                $('#showClient').html(showClient);
                return false;
            },
            minLength: 1,
            open: function() {

                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {

                if ($('#hiddenSupplierId').val() == '') {
                    $(this).val('');
                    $('#hiddenSupplierId').val('');
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });




        $('#account_get').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-account-trans') }}",
                    dataType: "json",
                    data: {
                        q: request.term,
                    },
                    success: function(data) {
                        response(data.content);
                    }
                });
            },
            select: function(event, ui) {
                $(this).val(ui.item.label + '  ' + '[' + 'Balance :' + ui.item.remain + ']');
                $('#amount_check').val(ui.item.remain);
                $('#hiddenAccId').val(ui.item.value);
                $('#remaining').val(ui.item.remain);

                return false;
            },
            minLength: 1,
            open: function() {

                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {

                if ($('#hiddenAccId').val() == '') {
                    $(this).val('');
                    $('#hiddenAccId').val('');
                    alert();
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
    </script>
@endsection
