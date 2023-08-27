@extends('home')
@section('content')
<!-- Form section -->
<!-- start: page toolbar -->
<div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
    <div class="container-fluid">
        <div class="row g-3 mb-3 align-items-center">
            <div class="col">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{url('/dashboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{url('/accounts')}}">Cashbook</a></li>
                    <li class="breadcrumb-item active">Create Non Invoice Income</li>
                </ol>
            </div>
        </div> <!-- .row end -->
        <div class="row align-items-center">
            <div class="col">
                <h1 class="fs-5 color-900 mt-1 mb-0">Create Non Invoice Income !</h1>
                <small class="text-muted"><div id="MyClockDisplay" class="clock" onload="showTime()"></div> </small>
            </div>
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-12 mt-2 mt-md-0">
                <!-- daterange picker -->
                <div class="input-group">           
                    <button class="btn btn-secondary" style="margin-left: 46%;" type="button" data-bs-toggle="tooltip" title="List"><a style="color: white" href="{{url('account-transfer')}}">List</a><i
                            class="fa fa-envelope"></i></button>

                </div>
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
                        <h4>Non Invoice Income Information</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 maskking-form" id="submitForm">
                            @csrf
                                <div class="col-lg-6 col-sm-12">
                                <span class="float-label">
                                    <input type="text" class="form-control form-control-lg" id="searchClient"
                                        placeholder="Search Client" name="client_name">                                       
                                    <label class="form-label" for="TextInput">Search Client</label>
                                </span>
                                <input type="hidden" class="form-control form-control-lg" id="hiddenClientID"
                                name="non_invoice_client_id">
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                                <span class="float-label">
                                    <input type="text" class="form-control form-control-lg" id="account_to_name"
                                           placeholder="Search ..." >
                                    <input type="hidden" class="form-control form-control-lg" id="HiddenAccountToId"
                                           name="non_invoice_account_id">
                                    <label class="form-label" for="account_to">To Account ?</label>
                                </span>
                            </div>
                            
                            <div class="col-lg-6 col-sm-12">
                                <span class="float-label">
                                    <input type="number" class="form-control form-control-lg" id="amount"
                                           placeholder="Amount" name="non_invoice_amount">
                                    <label class="form-label" for="TextInput">Amount</label>
                                </span>
                            </div>    
                            
                                    <div class="col-lg-6 col-sm-12">
                                <span class="float-label">
                                    <input type="date" class="form-control form-control-lg" id="date"
                                           placeholder="Date" name="non_invoice_date">
                                    <label class="form-label" for="TextInput">Date</label>
                                </span>
                            </div> 
                            
                            
                            
                            <div class="col-lg-6 col-sm-12">
                                <span class="float-label">
                                    <input type="text" class="form-control form-control-lg" id="note"
                                           placeholder="Note" name="non_invoice_note">
                                    <label class="form-label" for="transaction_note">Note</label>
                                </span>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <button type="submit" class="btn btn-primary" style="width: 100%; height:100%;">Submit</button>
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
        
        $("#submitForm").submit(function(e) {
            e.preventDefault();
            $('.loader').show();
            let submitButton = $(this).find(':input[type=submit]');
            submitButton.prop('disabled', true);
            $(".error_msg").html('');
            
            var data = new FormData($('#submitForm')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('account/save-non-invoice-income') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {   
                    $('.loader').hide();
                    window.location.href = "{{ url('accounts') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                $('.loader').hide();                
                window.location.href = "{{ url('accounts') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $(".loader").hide();
                submitButton.prop('disabled', false);
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });
        
        $(document).ready(function() {
        $('#account_name').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-account-full-data') }}",
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
                $('#HiddenAccountId').val(ui.item.value);
                $("input#account_name").after('<a> Current balance : '+ui.item.account_balance+'</a>');
                return false;
            },
            minLength: 1,
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                if ($('#HiddenAccountId').val() == '') {
                    $(this).val('');
                    $('#HiddenAccountId').val('');
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        $('#account_to_name').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-account-full-data') }}",
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
                $('#HiddenAccountToId').val(ui.item.value);
                $("input#account_to_name").after('<a> Current balance : '+ui.item.account_balance+'</a>');
                return false;
            },
            minLength: 1,
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                if ($('#HiddenAccountId').val() == '') {
                    $(this).val('');
                    $('#HiddenAccountId').val('');
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        });
        
              $('#searchClient').autocomplete({
            html: true,
            source: function (request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{url('money-receipt-search-client')}}",
                    dataType: "json",
                    data: {
                        q: request.term,
                    },
                    success: function (data) {
                        response(data.content);
                    }
                });
            },
            select: function (event, ui) {
                $(this).val(ui.item.label);  
                $('#hiddenClientID').val(ui.item.value);
//                $('#money_receipt_client_id').val(ui.item.value);              
//                $('#showClient').html(showClient);
                return false;
            },
            minLength: 1,
            open: function () {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function () {
                if( $('#hiddenClientId').val() == ''){
                    $(this).val('');
                    $('#hiddenClientId').val('');
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
    </script>
@endsection