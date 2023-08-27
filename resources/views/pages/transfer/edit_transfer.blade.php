@extends('home')
@section('content')
    @inject('productGet', 'App\Models\Product\Product')
    @inject('productItem', 'App\Models\Product\PurchaseItems')
    <!-- Personal Information Card End -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('') }}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('transfer') }}">Transfer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Transfer</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
            {{-- @include('layouts.frontend.today_statistics') --}}
        </div>
    </div>
    <!-- start: page body -->
    <form class="row maskking-form" id="add_form">
        @csrf
        @method('PUT')
        <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
            <div class="container-fluid">
                <!-- Create invoice -->
                <div class="row g-3">
                    <div class="col-12">



                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">New Transfer</h6>

                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="transfer_date">Transfer Date</label>
                                            <input type="text" class="form-control form-control-lg" id="transfer_date"
                                                placeholder="Transfer Date" name="transfer_date" readonly
                                                value="{{ $transfer[0]->transferDate }}">
                                        </span>
                                    </div>

                                    <input type="hidden" value="{{ $transfer[0]->transfer_id }}" name="transfer_id"
                                        id="transfer_id">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="transfer_no">Transfer No</label>
                                            <input type="text" class="form-control form-control-lg" id="transfer_no"
                                                placeholder="Transfer No" name="transferNo" readonly value=""></span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label class="col-md-4 col-sm-4 col-form-label">From Warehouse</label>

                                            <select class="form-control form-control-lg" name="fromWarehouseID"
                                                id="from_warehouse">
                                                {{-- @foreach ($warehouse as $warehouse)
                                                    <option value="{{ $warehouse->warehouse_id }}">
                                                        {{ $warehouse->warehouse_name }}</option>
                                                @endforeach --}}

                                                @foreach ($warehouse as $warehouse)
                                                    <option value="{{ $warehouse->warehouse_id }}"
                                                        {{ $warehouse->warehouse_id == $transfer[0]->fromWarehouseID ? 'selected' : '' }}>
                                                        {{ $warehouse->warehouse_name }} </option>
                                                @endforeach

                                            </select>

                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label class="col-md-4 col-sm-4 col-form-label">To Warehouse</label>

                                            <select class="form-control form-control-lg" name="toWarehouseID"
                                                id="to_warehouse">

                                            </select>

                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <button disabled class="btn btn-lg btn-secondary text-white"
                                                style="width: 100%">Search
                                                By Name or
                                                Barcode</button>

                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <span class="float-label">
                                            <label for="">Search Product</label>
                                            <input type="text" class="form-control form-control-lg" id="product_get"
                                                placeholder="Scan/Search Product by Name/Code" name="account">
                                        </span>
                                        <input type="hidden" id="hiddenAccId" name="expense_account">
                                    </div>
                                    {{-- <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <button type="button" id="productAddBtn"
                                                class="btn btn-lg btn-info text-white addProductRow disabled"
                                                style="width: 100%"> +
                                                Add
                                                Product</button>

                                        </span>
                                    </div> --}}
                                </div>
                                <br>


                            </div>


                        </div>
                    </div>
                    <br>
                    <div class="card print_invoice">
                        <div class="card-body">
                            <div class="card p-3">
                                <div style="clear:both"></div>
                                <h3>Products*</h3>
                                <table class="items">
                                    <tbody>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Product Name</th>
                                            <th>Available Quantity</th>
                                            <th>Quantity</th>
                                            <th>#</th>
                                        </tr>
                                        <div id="billingDetailsList">
                                            <?php
                                            $sl = 0;
                                            ?>

                                            @foreach ($product as $product)
                                                @php
                                                    $sl++;
                                                    //$productName = '';
                                                    $productId = '';
                                                    $testProduct = $productGet->productNameGet($product->product_id);
                                                @endphp
                                                <tr class="item-row billing-details-row">
                                                    <td class="item-name">
                                                        <div class="col-12">
                                                            <span class="float-label">
                                                                <input type="text" readonly
                                                                    class="form-control product form-control-lg"
                                                                    id="productName{{ $sl }}"
                                                                    placeholder="Search Product"
                                                                    data-row="{{ $sl }}"
                                                                    name="product_{{ $sl }}"
                                                                    value="{{ $product->product_id }}">
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="description">
                                                        <div class="col-12">
                                                            <span class="float-label">
                                                                <input type="text"
                                                                    class="form-control product form-control-lg"
                                                                    id="productName{{ $sl }}"
                                                                    placeholder="Search Product"
                                                                    data-row="{{ $sl }}"
                                                                    name="purchase_product_id"
                                                                    value="{{ $productGet->productNameGet($product->product_id) }}">
                                                            </span>
                                                            <input type="hidden" id="hiddenProductID{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                name="product_id_{{ $sl }}"
                                                                value="{{ $product->product_id }}">

                                                        </div>
                                                    </td>
                                                    <td class="description">
                                                        <input type="number" id="qty_{{ $sl }}"
                                                            data-row="{{ $sl }}"
                                                            name="available_qty_{{ $sl }}"
                                                            value="{{ $productItem->pruchaseItems($product->product_id) }}"
                                                            class="form-control quantity available_qty_{{ $sl }}"
                                                            readonly>
                                                    </td>
                                                    <td class="description">
                                                        <input type="number" id="qty_{{ $sl }}"
                                                            data-row="{{ $sl }}"
                                                            name="qty_{{ $sl }}"
                                                            value="{{ $product->quantity }}"
                                                            class="form-control quantity qty_{{ $sl }}">
                                                    </td>
                                                    <td class="description">
                                                        <div class="delete-wpr"><button class="delete"
                                                                href="javascript:;" title="Remove row">Remove</button>
                                                        </div>
                                                        <input type="hidden" name="transferNo"
                                                            value="{{ $product->transferNo }}">
                                                    </td>


                                                    <input type="hidden" name="billing_rows[]" id="billing_row_num"
                                                        value="{{ $sl }}" />
                                                </tr>
                                            @endforeach






                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <label for="">Transfer Note</label>
                            <textarea name="note" id="" cols="10" rows="5"></textarea>

                            <br>
                            <div class="col-12 text-center text-md-end" id="InvoiceButtonArea">
                                <button type="submit" id="submitBtnConfirm" class="btn btn-lg btn-primary"><i
                                        class="fa fa-print me-2"></i>Confirm Transfer</button>
                                <button type="button" class="btn btn-lg btn-danger"><i
                                        class="fa fa-envelope me-2"></i>Reset</button>
                            </div>
                        </div>
                    </div>

                </div>




                <div class="col-12 text-center text-md-end" id="InvoiceSkipButtonArea" style="display: none">
                    {{-- <a type="button" class="btn btn-lg btn-secondary"
                                href="{{ url('invoice/' . $invoiceNO) }}"><i class="fa fa-envelope me-2"></i>SKIP MONEY
                                RECEIPT</a> --}}
                </div>







    </form>

    <script type="text/javascript">
        $(document).ready(function() {

            let r = 'TRNAS_' + Math.floor(Math.random() * 90000) + 10000;
            $('#transfer_no').val(r);

        });
        // $(document).on('click', '.addProductRow', function() {
        //     var billing_row = document.querySelectorAll('.billing-details-row').length + 1;
        //     // alert(billing_row);
        //     var billing_content = ' <tr class="item-row billing-details-row">' +
        //         '<td class="description">' +
        //         ' <textarea name="product_name_' + billing_row + ' class=' + ui.item
        //         .items_detail + '" ></textarea>' +
        //         ' </td>' +
        //         '<td class="description">' +
        //         ' <textarea name="product_id_' + billing_row + '" type="hidden">' +
        //         '  </textarea></td>' +
        //         ' <td><textarea class="available_qty_"' + billing_row + ' name="available_qty_' + billing_row +
        //         '" " data-row="' +
        //         billing_row + '" ></textarea></td>' +
        //         ' <td><textarea class="cost qty qty-' + billing_row + '" data-row="' +
        //         billing_row + '" name="billing_unit_price_' + billing_row + '"></textarea></td>' +
        //         ' <td><div class="delete-wpr"><button class="delete" href="javascript:;" title="Remove row">Remove</button></div></td>' +
        //         ' </tr>' +
        //         '<div style="clear:both"></div>' +
        //         '<span class="remove-flight-row"><i class="fa fa-times"></i></span>' +
        //         '<input type="hidden" name="billing_rows[]" value="' + billing_row + '" />' +
        //         '</div>';

        //     $('.items tr:last').after(billing_content);

        // });

        $(document).on('click', '.delete-wpr', function() {
            $(this).parent().parent().remove();
        });

        $(document).ready(function() {
            let transfer_no = $('#transfer_id').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: "{{ url('transfer/getToWareHouse') }}" + '/' + transfer_no,
                success: function(data, textStatus, jqXHR) {

                    alert(data);
                    $('#to_warehouse').val(data).prop('selected', true);
                    // alert(data);
                    // $('#InvoiceButtonArea').hide();
                    // $('#InvoiceSkipButtonArea').show();
                    //$('#checkMoneyReceipt').html(data);
                }
            }).done(function() {
                $("#success_msg").html("Data Saved Successfully");
                // window.location.href = "{{ url('agents') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $("#loader").hide();
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" +
                        value +
                        "</span>");
                });
            });

        });

        $('#from_warehouse').on('change', function() {
            let from_warehouse = $(this).find(":checked").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "GET",
                url: "{{ url('transfer/fromwarehouse') }}" + '/' + from_warehouse,
                success: function(data, textStatus, jqXHR) {

                    $('#to_warehouse').html(data);
                    $('#productAddBtn').removeClass('disabled');


                    // alert(data);
                    // $('#InvoiceButtonArea').hide();
                    // $('#InvoiceSkipButtonArea').show();
                    //$('#checkMoneyReceipt').html(data);
                }
            }).done(function() {
                $("#success_msg").html("Data Saved Successfully");
                // window.location.href = "{{ url('agents') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $("#loader").hide();
                var json_data = JSON.parse(data.responseText);
                $.each(json_data.errors, function(key, value) {
                    $("#" + key).after(
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" +
                        value +
                        "</span>");
                });
            });

        });

        let from_warehouse = $(this).find(":checked").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "GET",
            url: "{{ url('transfer/fromwarehouse') }}" + '/' + from_warehouse,
            success: function(data, textStatus, jqXHR) {

                $('#to_warehouse').html(data);
                $('#productAddBtn').removeClass('disabled');


                // alert(data);
                // $('#InvoiceButtonArea').hide();
                // $('#InvoiceSkipButtonArea').show();
                //$('#checkMoneyReceipt').html(data);
            }
        }).done(function() {
            $("#success_msg").html("Data Saved Successfully");
            // window.location.href = "{{ url('agents') }}";
            // location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            $("#loader").hide();
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function(key, value) {
                $("#" + key).after(
                    "<span class='error_msg' style='color: red;font-weigh: 600'>" +
                    value +
                    "</span>");
            });
        });








        $('#product_get').autocomplete({
            html: true,
            source: function(request, response) {
                let from_warehouse = $('#from_warehouse').find(":checked").val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-warehouse-product') }}/",
                    dataType: "json",
                    data: {
                        q: from_warehouse,
                    },
                    success: function(data) {
                        response(data.content);
                    }
                });
            },
            select: function(event, ui) {
                $(this).val(ui.item.label);
                $('#hiddenClientId_invoice').val(ui.item.value);
                var billing_row = document.querySelectorAll('.billing-details-row').length + 1;
                // alert(billing_row);
                var billing_content = ' <tr class="item-row billing-details-row">' +
                    '<td class="description">' +
                    ' <textarea name="product_' + billing_row + '" class=' + ui.item
                    .items_id + '  data-row="' + billing_row + '">' + ui.item.items_id + '</textarea>' +
                    ' </td>' +
                    '<td class="description">' +
                    ' <textarea readonly name="product_name_' + billing_row + '" type="hidden"  data-row="' +
                    billing_row + '">' + ui.item
                    .items_detail +
                    '  </textarea></td>' +
                    ' <td><textarea readonly class="available_qty_' + billing_row + '" name="available_qty_' +
                    billing_row +
                    '" " data-row="' +
                    billing_row + '" >' + ui.item.items_quantity + '</textarea></td>' +
                    ' <td><textarea class="qty qty-' + billing_row +
                    '" data-row="' +
                    billing_row + '" name="qty_' + billing_row + '"></textarea></td>' +
                    ' <td><div class="delete-wpr"><button class="delete" href="javascript:;" title="Remove row">Remove</button></div></td>' +
                    ' </tr>' +
                    '<div style="clear:both"></div>' +
                    '<span class="remove-flight-row"><i class="fa fa-times"></i></span>' +
                    '<input type="hidden" name="billing_rows[]" value="' + billing_row + '" />' +
                    '</div>';

                $('.items tr:last').after(billing_content);
                return false;
            },
            minLength: 1,
            open: function() {

                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {

                if ($('#hiddenClientId_invoice').val() == '') {
                    $(this).val('');
                    $('#hiddenClientId_invoice').val('');
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });

        $(document).on('keyup', '.qty', function() {
            var billing_row = $(this).attr('data-row');


            var check_stock = $('.available_qty_' + billing_row).val();
            var check_input = $('.qty-' + billing_row).val();

            if (check_input > check_stock) {
                alert('Quantity is exceeded the stock limit');
                $('.qty-' + billing_row).val('');
            } else {
                $('#submitBtnConfirm').removeClass('disabled');

            }


        });



        $("#add_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            $('.loader').show();
            let transfer_id = $('#transfer_id').val();
            var data = new FormData($('#add_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('transfer') }}" + '/' + transfer_id,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {

                    alert(data);

                    // $('.loader').hide();
                    // window.location.href = "{{ url('transfer') }}";
                    // $('#submitBtnConfirm').addClass('disabled');
                    // $('#add_form')[0].reset();
                    //$('#checkMoneyReceipt').html(data);
                }
            }).done(function() {
                $("#success_msg").html("Data Saved Successfully");
                // window.location.href = "{{ url('agents') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $("#loader").hide();
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
