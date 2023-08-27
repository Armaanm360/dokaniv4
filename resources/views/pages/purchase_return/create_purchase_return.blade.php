
 @extends('home')
 @section('content')

 <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
    <div class="container-fluid">
        <div class="row g-3 mb-3 align-items-center">
            <div class="col">
                <ol class="breadcrumb bg-transparent mb-0">
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('') }}}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('purchase-return') }}">Purchase Return</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Purchase Return</li>
                </ol>
            </div>
        </div> <!-- .row end -->
    </div>
</div>
{{-- @if (Session::has('warning'))
    <div class="alert alert-warning">
        <div>
            <p>{{ Session::get('warning') }}</p>
        </div>
    </div>
@endif --}}
<!-- start: page body -->

        @php
            $date = date('y/m/d');
        @endphp
        <input type="hidden" id="row" value="{{$row_count}}">
        <input type="hidden" id="date" value="{{$date}}">
        <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
            <div class="container-fluid">
                <!-- Create invoice -->
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">BASIC INFORMATION</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg"
                                                id="supplierID" placeholder="Search Supplier" name="purchase_supplier_id">
                                            <label class="form-label" for="supplierID">Search Supplier</label>
                                        </span>
                                        <input type="hidden" id="hiddenSupplierID" name="purchase_supplier_id">
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <label class="form-group float-label">
                                            <select class="form-control" name="purchase_number" id="purchase_number">

                                            </select>
                                            <span>Purchase Number</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg"
                                                id="purchase_return_number" placeholder="Purchase Return Number" name="purchase_return_number">
                                            <label class="form-label" for="purchase_return_number">Purchase Return Number </label>
                                        </span>
                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div id="showReport"></div>




<script type="text/javascript">

    $(document).ready(function() {


        $('#supplierID').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-supplier') }}",
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
                $('#hiddenSupplierID').val(ui.item.value);
                $.ajax({
                    method: "GET",
                url: "{{ url('get-supplier-id') }}/" + ui.item.value,
                success: function(data, textStatus, jqXHR) {
                    $('#purchase_number').html(data);
                    // $('#expense_sub_head_get').attr('selected');

                }
                });

                return false;
            },
            minLength: 1,
            open: function() {

                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {

                if ($('#hiddenSupplierID').val() == '') {
                    $(this).val('');
                    $('#hiddenSupplierID').val('');
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        $('#supplierID').keyup(function() {
            let date1 = $('#date').val();
            let row_val = parseFloat($('#row').val()) || 0;
            let x = Math.floor((Math.random() * 100000) + 1);
            let newdate = date1.replace(/-|\//g, "");
            let variable = newdate + (row_val+1);
            $('#purchase_return_number').val(variable);
        });
        $("#purchase_number").change(function(e) {
            // alert("The text has been changed.");
            e.preventDefault();
            // $(this).find(':input[type=submit]').prop('disabled', true);
            $(".error_msg").html('');
            $('.loader').show();
            var data = $('#purchase_number').val();
            var data1 = $('#hiddenSupplierID').val();
            var data2 = $('#purchase_return_number').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('get-purchase-data') }}",
                data: {purchase_number:data,supplier_id:data1,purchase_return_number:data2},
                // cache: false,
                // contentType: false,
                // processData: false,
                success: function(data, textStatus, jqXHR) {
                    // alert(data);
                    $('#showReport').html(data);
                    // window.location.href = "{{ url('purchases') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                $('.loader').hide();
                // window.location.href = "{{ url('purchases') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $("#loader").hide();
                // $(this).find(':input[type=submit]').prop('enabled', true);
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });

    });


</script>

 @endsection
