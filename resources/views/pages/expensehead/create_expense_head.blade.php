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
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Expense Head</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Expense Head</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('expense-head') }}"><i class="fa fa-list me-2"></i>List
                        Expense Heads</a>
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
                            <h6 class="card-title mb-0">Create Expense Head</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="expense_head">
                                @csrf
                                <div class="col-8">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="expense_head"
                                            placeholder="Expense Head" name="title">
                                        <label class="form-label" for="TextInput">Expense Head</label>
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

        </div>
    </div>
    <!-- end form section -->

    <script type="text/javascript">
        $("#expense_head").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#expense_head')[0]);
            $('.loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('expense-head') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    // alert(data);
                    window.location.href = "{{ url('expense-head') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Saved Successfully");
                window.location.href = "{{ url('expense-head') }}";
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
    </script>
@endsection
