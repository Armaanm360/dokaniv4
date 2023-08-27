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
                        <li class="breadcrumb-item"><a class="text-secondary">Report</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Datewise Sales Report</li>
                    </ol>
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
                            <h6 class="card-title mb-0">Datewise Sales Report</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="search_form">
                                @csrf
                                 <div class="col-lg-3 col-md-3 col-sm-12">

                                                <span class="float-label">
                                                    <select name="branch_id" id="branch_id" class="form-control">
                                                        <option value="">Select One</option>
                                                        @foreach ($branch as $item)
                                                            <option value="{{$item->branch_id}}">{{$item->branch_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="form-label" for="TextInput">Select Branch </label>
                                                </span>

                                </div>
                                 <div class="col-lg-3 col-md-3 col-sm-12">

                                                <span class="float-label">
                                                    <select name="customer_type" id="customer_type" class="form-control">
                                                        <option value="">Select One</option>
                                                        <option value="online">Online</option>
                                                        <option value="offline">Offline</option>
                                                    </select>
                                                    <label class="form-label" for="TextInput">Sales Type </label>
                                                </span>

                                </div>

                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="input-group" style="height: 53px;">
                                        <input class="form-control" type="text" id="daterange" name="daterange">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>


                            </form>

                            <div id="showReport"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- .row end -->

        </div>
    </div>
    <!-- end form section -->



    <script type="text/javascript">

        $("#search_form").submit(function(e) {
            e.preventDefault();
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(".error_msg").html('');
            $('.loader').show();
            var data = new FormData($('#search_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('report/get-date-wise-sales-report') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('#showReport').html(data);
                    $('.loader').hide();
                }
            }).done(function() {
                $("#success_msg").html("Data Fetched Successfully");
                $('.loader').hide();
                // window.location.href = "{{ url('purchases') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $(".loader").hide();
                $(this).find(':input[type=submit]').prop('enabled', true);
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
