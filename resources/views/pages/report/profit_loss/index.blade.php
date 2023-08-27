
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
                        <li class="breadcrumb-item active" aria-current="page">Profit loss</li>
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
                            <h6 class="card-title mb-0">Profit loss</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="search_form">
                                @csrf
                                 
                                 <div class="col-lg-2 col-md-2 col-sm-12">
                                    
                                </div>
                                 
                                <div class="col-lg-6 col-md-6 col-sm-12">
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
           
            $(".error_msg").html('');
            var data = new FormData($('#search_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('reports/get-profit-loss') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('#showReport').html(data);

                }
            }).done(function() {
                $("#success_msg").html("Data Fetched Successfully");
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


    </script>
    

@endsection
