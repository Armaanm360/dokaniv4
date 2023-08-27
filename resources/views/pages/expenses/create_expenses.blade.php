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
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Expense</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Expense</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('expenses') }}"><i class="fa fa-list me-2"></i>List
                        Expenses</a>
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
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Create Expense</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="expense_form">
                                @csrf
                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="branchName"
                                            placeholder="Branch" name="branch_id">
                                        <label class="form-label" for="agentID">Branch</label>
                                    </span>
                                    <input type="hidden" id="hidden_branch_id" name="hidden_branch_id">

                                </div>
                                <div class="col-8">
                                    <span class="float-label">
                                        <select class="form-control" id="expense_head" name="expense_head_id">
                                            <option disabled selected>Select Head</option>
                                            @foreach ($head as $head)
                                                <option value="{{ $head->expensehead_id }}">{{ $head->title }}</option>
                                            @endforeach


                                        </select>
                                        <label class="form-label" for="agentID">Expense Head</label>
                                    </span>
                                </div>

                                <div class="col-6">
                                    <span class="float-label">
                                        <select class="form-control" id="expense_sub_head_get" name="expense_sub_head_id">

                                        </select>
                                        <label class="form-label" for="expense_sub_head_get">Expense Sub Head</label>
                                    </span>
                                </div>

                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="account_get"
                                            placeholder="Account" name="account">
                                        <label class="form-label" for="agentID">Account</label>
                                    </span>
                                    <input type="hidden" id="hiddenAccId" name="expense_account">
                                </div>


                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="remaining"
                                            placeholder="remaining" name="remaining_amount" readonly>
                                        <label class="form-label" for="TextInput">Remaining Amount</label>
                                    </span>
                                </div>




                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="expense_sub_head"
                                            placeholder="amount" name="expense_amount">
                                        <label class="form-label" for="TextInput">Amount</label>
                                    </span>
                                </div>

                                <div class="col-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="expense_sub_head"
                                            placeholder="Expense Head" name="expense_date" value="{{ date('d-m-y') }}"
                                            readonly>
                                        <label class="form-label" for="TextInput">Date</label>
                                    </span>
                                </div>

                                <div class="col-6">
                                    <span class="float-label">
                                        <textarea name="expense_note" id="" cols="30" rows="5"></textarea>
                                        <label class="form-label" for="TextInput">Expense Note</label>
                                    </span>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- .row end -->

            <div class="row"></div>
        </div>
    </div>


    <!-- end form section -->

    <script type="text/javascript">
        $("#expense_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#expense_form')[0]);
            $('.loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('expenses') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    alert(data);
                    window.location.href = "{{ url('expenses') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Saved Successfully");
                window.location.href = "{{ url('expenses') }}";
                // location.reload();
                $('.loader').hide();
            }).fail(function(data, textStatus, jqXHR) {
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });


        $('#expense_head').on('change', function() {
            $("#loader").show();
            //alert('Hi');
            let expensehead = $(this).find(":selected").val();

            $.ajax({
                method: "GET",
                url: "{{ url('get-sub-head') }}/" + expensehead,
                success: function(data, textStatus, jqXHR) {
                    $('#expense_sub_head_get').html(data);
                    // $('#expense_sub_head_get').attr('selected');

                }
            }).done(function(data) {
                //  $('#expense_sub_head_get').html(data);
            }).fail(function(data, textStatus, jqXHR) {
                $("#loader").hide();
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    //                console.log(key);
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        })





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
                $(this).val(ui.item.label);
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

        $('#branchName').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('branch-name-search') }}",
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
                $('#hidden_branch_id').val(ui.item.value);
                // $('#remaining').val(ui.item.remain);
                return false;
            },
            minLength: 1,
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                if ($('#hidden_branch_id').val() == '') {
                    $(this).val('');
                    $('#hidden_branch_id').val('');
                    alert();
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
    </script>
@endsection
