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
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Delivery Man</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Delivery Man</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('delivery-men') }}"><i class="fa fa-list me-2"></i>List of
                        Delivery Man</a>
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
                            <h6 class="card-title mb-0">Create Delivery Man</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="Delivery_Man_form">
                                @csrf
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="delivery_men_name"
                                            placeholder="Delivery Man Name" name="delivery_men_name">
                                        <label class="form-label" for="delivery_men_name">Delivery Man Name</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg"
                                            id="delivery_men_entry_id" placeholder="Delivery Man Entry ID"
                                            name="delivery_men_entry_id" readonly>
                                        <label class="form-label" for="delivery_men_entry_id">Delivery Man Entry ID</label>
                                    </span>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="number" class="form-control form-control-lg"
                                            id="delivery_men_phone_number" placeholder="Delivery Man Phone"
                                            name="delivery_men_phone_number">
                                        <label class="form-label" for="delivery_men_phone_number">Delivery Man Phone</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="delivery_men_address"
                                            placeholder="Delivery Man Address" name="delivery_men_address">
                                        <label class="form-label" for="delivery_men_address">Delivery Man Address</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <select class="form-select" aria-label="Default select example"
                                            name="delivery_men_vehicle">
                                            <option selected disabled>Select Vehicle</option>
                                            @foreach ($delivery_men_Vehicle as $delivery_men_Vehicle)
                                                <option value="{{ $delivery_men_Vehicle->delivery_vehicles_id }}">
                                                    {{ $delivery_men_Vehicle->delivery_vehicles_name }}</option>
                                            @endforeach
                                        </select>
                                        <label class="form-label" for="delivery_men_address">Delivery Man Vahicle</label>
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
        $('#delivery_men_name').keyup(function() {
            let rand = $('#delivery_men_name').val();
            let x = Math.floor((Math.random() * 100000) + 1);

            $('#delivery_men_entry_id').val(rand + x);

        });


        $("#Delivery_Man_form").submit(function(e) {
            e.preventDefault();
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(".error_msg").html('');
            $('.loader').show();
            var data = new FormData($('#Delivery_Man_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('delivery-men') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    // alert();
                    // $('.loader').hide();
                    window.location.href = "{{ url('delivery-men') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                $('.loader').hide();
                // window.location.href = "{{ url('delivery-men') }}";
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
            if (this.files[0].size > 2097152) {
                alert("File is too big!");
                this.value = "";
            };
        };
    </script>
@endsection
