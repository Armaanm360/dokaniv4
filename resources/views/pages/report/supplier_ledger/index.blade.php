
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
                        <li class="breadcrumb-item active" aria-current="page">Supplier Ledger</li>
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
                            <h6 class="card-title mb-0">Supplier Ledger</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="search_form">
                                @csrf

                                 <div class="col-lg-3 col-md-3 col-sm-12">
                                    <span class="float-label">
                                        <select name="supplier_id" id="supplier_id" class="form-control">
                                            <option value="">Select One</option>
                                            @foreach ($supplier as $item)
                                                <option value="{{$item->supplier_id}}">{{$item->supplier_name}}</option>
                                            @endforeach
                                        </select>
                                        <label class="form-label" for="TextInput">Select Supplier </label>
                                    </span>
                                 </div>

                                <div class="col-lg-3 col-md-3 col-sm-12">
                                    <div class="input-group" style="height: 53px;">
                                        <input class="form-control" type="text" id="daterange" name="daterange">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12">
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

            $(".error_msg").html('');
            var data = new FormData($('#search_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('reports/get-datewise-supplier-ledger-report') }}",
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
                // window.location.href = "{{ url('get-client-ledger-report') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });

        // $('#warehouseID').autocomplete({
        //         html: true,
        //         source: function(request, response) {
        //             $.ajax({
        //                 type: "GET",
        //                 url: "{{ url('search-warehouse') }}",
        //                 dataType: "json",
        //                 data: {
        //                     q: request.term,
        //                 },
        //                 success: function(data) {
        //                     response(data.content);
        //                 }
        //             });
        //         },
        //         select: function(event, ui) {
        //             $(this).val(ui.item.label);
        //             $('#hiddenWarehouseID').val(ui.item.value);
        //             return false;
        //         },
        //         minLength: 1,
        //         open: function() {

        //             $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        //         },
        //         close: function() {

        //             if ($('#hiddenWarehouseID').val() == '') {
        //                 $(this).val('');
        //                 $('#hiddenWarehouseID').val('');
        //             }
        //             $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        //         }
        //     });


    </script>


@endsection
