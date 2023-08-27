
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
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Product</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('products') }}"><i class="fa fa-list me-2"></i>List Product</a>
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
                            <h6 class="card-title mb-0">Create Product</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="product_form">
                                @csrf
                                @php
                                    $date = date('y-m-d');
                                @endphp
                                <input type="hidden" id="row" value="{{$row_count}}">
                                <input type="hidden" id="date" value="{{$date}}">
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <select class="form-control form-control-lg custom-select"
                                            name="product_category">
                                            <option value="" disabled selected>
                                                {{ __('Select Product Category') }}
                                            </option>
                                            @foreach ($productCategory as $category)
                                                <option value="{{$category->product_category_id}}">{{$category->product_category_name}}</option>
                                            @endforeach

                                        </select>
                                        <label class="form-label" for="TextInput">Product Category</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="product_name"
                                            placeholder="Product Name" name="product_name">
                                        <label class="form-label" for="TextInput">Product Name</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="product_entry_id"
                                            placeholder="Product Entry ID" name="product_entry_id" readonly>
                                        <label class="form-label" for="TextInput">Product Entry ID</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="product_code"
                                            placeholder="Product Code" name="product_code" readonly>
                                        <label class="form-label" for="TextInput">Product Code</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="product_retail_price"
                                            placeholder="Product Retail Price" name="product_retail_price">
                                        <label class="form-label" for="TextInput">Product Retail Price</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="product_wholesale_price"
                                            placeholder="Product Wholesale Price" name="product_wholesale_price">
                                        <label class="form-label" for="TextInput">Product Wholesale Price</label>
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
        $('#product_name').keyup(function() {
            let rand = $('#product_name').val();
            let date1 = $('#date').val();
            let row_val = parseFloat($('#row').val()) || 0;
            let x = Math.floor((Math.random() * 100000) + 1);
            let newdate = date1.replace(/-|\//g, "");
            let variable = newdate + (row_val+1);

            $('#product_entry_id').val(rand + x);
            $('#product_code').val(variable);

        });



        $("#product_form").submit(function(e) {
            e.preventDefault();
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(".error_msg").html('');
            $('.loader').show();
            var data = new FormData($('#product_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('products') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    window.location.href = "{{ url('products') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                $('.loader').hide();
                window.location.href = "{{ url('products') }}";
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
