@extends('home')
@section('content')
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('') }}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('purchases') }}">Purchase</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Purchase</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
        </div>
    </div>
    <!-- start: page body -->

    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container-fluid">
            <!-- Create invoice -->
            <div class="row g-3">
                <form class="row maskking-form" id="add_form">
                    @csrf
                    @method('PUT')
                    <div class="col-12">



                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">BASIC INFORMATION</h6>
                            </div>
                            <div class="card-body">
                                <input type="hidden" id="purchase_id" name="purchase_id" value="{{ $data->purchase_id }}">
                                <input type="hidden" id="purchase_items_rows" name="purchase_items_rows"
                                    value="{{ $purchase_items_rows }}">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="warehouseID"
                                                placeholder="Search Warehouse" name="purchase_warehouse_id">
                                            <label class="form-label" for="warehouseID">Search Warehouse</label>
                                        </span>
                                        <input type="hidden" id="hiddenWarehouseID" name="purchase_warehouse_id"
                                            value="{{ $data->purchase_warehouse_id }}">
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="supplierID"
                                                placeholder="Search Supplier" name="purchase_supplier_id">
                                            <label class="form-label" for="supplierID">Search Supplier</label>
                                        </span>
                                        <input type="hidden" id="hiddenSupplierID" name="purchase_supplier_id"
                                            value="{{ $data->purchase_supplier_id }}">
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="purchase_number"
                                                placeholder="Purchase No" name="purchase_number"
                                                value="{{ $data->purchase_number }}">
                                            <label class="form-label" for="Purchase Number">Purchase No </label>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg"
                                                id="purchase_po_reference" placeholder="PO Reference"
                                                name="purchase_po_reference" value="{{ $data->purchase_po_reference }}">
                                            <label class="form-label" for="purchase_po_reference">PO Reference </label>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <textarea name="purchase_payment_terms" id="purchase_payment_terms" class="form-control">{!! $data->purchase_payment_terms !!}</textarea>
                                            <label class="form-label" for="purchase_payment_terms">Payment Terms</label>
                                        </span>
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="date" class="form-control form-control-lg today"
                                                id="purchase_date" name="purchase_date" value="{{ $data->purchase_date }}">
                                            <label class="form-label" for="purchase_date">Purchase Date</label>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="date" class="form-control form-control-lg today" id="due_date"
                                                name="due_date" value="{{ $data->due_date }}">
                                            <label class="form-label" for="due_date">Due Date</label>
                                        </span>
                                    </div>


                                </div>


                            </div>
                        </div>


                        <br>
                        <hr>


                        <div class="card print_invoice">
                            <div class="card-header border-bottom fs-4">
                                <h5 class="card-title mb-0">PURCHASE INFORMATION</h5>
                            </div>
                            <div class="card-body">
                                <div class="card p-3">
                                    <div style="clear:both"></div>
                                    <table class="items">
                                        <tbody>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Product Color</th>
                                                <th>Product Size</th>
                                                <th style="width: 140px;">Quantity</th>
                                                <th style="width: 140px;">Price</th>
                                                <th style="width: 70px;">Total Price</th>
                                            </tr>
                                            <div id="billingDetailsList">
                                                <?php
                                                // $invoice_id = $invoice[0]->invoice_id;
                                                // $billings = $InvoiceBilling->invoice_billings($invoice_id);
                                                $sl = 0;
                                                ?>
                                                @foreach ($purchase_items as $row)
                                                    @php
                                                        $sl++;
                                                        $productName = '';
                                                        $receipt_by = '';
                                                        $product = App\Models\Product\Product::product($row->purchase_product_id);
                                                        if ($product) {
                                                            $productName = $product->product_name;
                                                        }
                                                    @endphp
                                                    <tr class="item-row billing-details-row">
                                                        <td class="item-name">
                                                            <div class="col-12">
                                                                <span class="float-label">
                                                                    <input type="text"
                                                                        class="form-control product form-control-lg"
                                                                        id="productName{{ $sl }}"
                                                                        placeholder="Search Product"
                                                                        data-row="{{ $sl }}"
                                                                        name="purchase_product_id"
                                                                        value="{{ $productName }}">
                                                                </span>
                                                                <input type="hidden"
                                                                    id="hiddenProductID{{ $sl }}"
                                                                    data-row="{{ $sl }}"
                                                                    name="product_id_{{ $sl }}"
                                                                    value="{{ $row->purchase_product_id }}">

                                                            </div>
                                                        </td>
                                                        <td class="description">
                                                            <select name="color_{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                class="form-control input-sm color_id">
                                                                <option value="">Select Color</option>

                                                            </select>
                                                        </td>
                                                        <td class="description">
                                                            <select name="size_{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                class="form-control input-sm color_id">
                                                                <option value="">Select Size</option>

                                                            </select>
                                                        </td>
                                                        <td class="description">
                                                            <input type="number" id="qty_{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                name="qty_{{ $sl }}"
                                                                value="{{ $row->purchase_product_quantity }}"
                                                                class="form-control quantity quantity-id-{{ $sl }}">
                                                        </td>
                                                        <td class="description">
                                                            <input type="" id="unit_price_{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                name="unit_price_{{ $sl }}"
                                                                value="{{ $row->purchase_product_price }} "class="form-control unit-price unit-price-{{ $sl }}">
                                                        </td>
                                                        <td class="description">
                                                            <input type="number" id="total_price_{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                name="total_price_{{ $sl }}"
                                                                value="{{ $row->purchase_product_total_price }}"
                                                                class="form-control totalprice">
                                                        </td>

                                                        <input type="hidden" name="billing_rows" id="billing_row_num"
                                                            value="{{ $sl }}" />
                                                    </tr>
                                                @endforeach
                                            </div>
                                        </tbody>
                                    </table>

                                    <table>
                                        <tbody>
                                            <tr id="hiderow">
                                                <td colspan="5"><a id="addProductRow" class="addProductRow"
                                                        href="javascript:;" title="Add a row">Add a row</a></td>
                                            </tr>
                                            <tr>

                                                <td colspan="10" width="80%"
                                                    class="total-line text-right invoice-subtotal"
                                                    style="text-align: right;border:0">Total Quantity</td>
                                                <td class="total-value">
                                                    <input type="number" name="purchase_quantity" id="quantity_total"
                                                        value="{{ $data->purchase_quantity }}" class="form-control"
                                                        readonly>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                    Sub Total</td>
                                                <td class="total-value">
                                                    <input type="number" class="form-control purchase-subtotal"
                                                        name="purchase_subtotal" id="purchase_subtotal"
                                                        value="{{ $data->purchase_subtotal }}" readonly>
                                                </td>
                                            </tr>

                                            <tr>

                                                <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                    Discount</td>
                                                <td class="total-value">
                                                    <input type="number" class="form-control purchase-discount"
                                                        name="purchase_discount" id="discount"
                                                        value="{{ $data->purchase_discount }}">
                                                </td>
                                            </tr>



                                            <tr>

                                                <td colspan="10" class="total-line balance"
                                                    style="text-align: right;border:0">Net Total</td>
                                                <td class="total-value balance">
                                                    <div class="due">
                                                        <input class="form-control purchase-net-total" type="number"
                                                            name="purchase_net_total" id="purchase_net_total"
                                                            value="{{ $data->purchase_net_total }}" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div style="clear:both"></div>
                                    <div class="footer-note mt-5">
                                        <h5>Terms</h5>
                                        <textarea name="purchase_note" class="form-control bg-light">{!! $data->purchase_note !!}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="col-12 text-center text-md-end" id="InvoiceButtonArea">
                        <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-print me-2"></i>Update
                            Purchase</button>
                    </div>


                </form>

            </div>
        </div>
    </div>




    <script type="text/javascript">
        $(document).on('click', '.addProductRow', function() {
            var billing_row = document.querySelectorAll('.billing-details-row').length + 1;
            var billing_content = ' <tr class="item-row billing-details-row">' +
                '<td class="item-name">' +
                ' <div class="delete-wpr"><a class="delete" href="javascript:;" title="Remove row">X Remove</a></div>' +
                '<div class="col-12">' +
                '<span class="float-label">' +
                '<input type="text" data-row = "' + billing_row +
                '" class="form-control product form-control-lg" id="productName' + billing_row +
                '" placeholder="Search Product" name="purchase_product_id">' +
                '</span>' +
                '<input type="hidden" id="hiddenProductID' + billing_row + '" data-row = "' + billing_row +
                '" name="product_id_' + billing_row + '">' +
                '</div>' +
                '</td>' +

                '<td class="description">' +
                ' <select name="color_' + billing_row + '" data-row = "' + billing_row +
                '" class="form-control input-sm color_id">' +
                '<option value="">Select Color</option>' +
                '</select>' +
                ' </td>' +
                '<td class="description">' +
                ' <select name="size_' + billing_row + ' "data-row = "' + billing_row +
                '" class="form-control input-sm color_id">' +
                '<option value="">Select Size</option>' +
                '</select>' +
                ' </td>' +
                '<td class="description">' +
                '<input type="number" id="qty_' + billing_row + '" name="qty_' + billing_row + '" data-row = "' +
                billing_row + '" class="form-control quantity quantity-id-' + billing_row + '">' +
                ' </td>' +
                '<td class="description">' +
                '<input type="" id="unit_price_' + billing_row + '" name="unit_price_' + billing_row +
                '" data-row = "' + billing_row + '" class="form-control unit-price unit-price-' + billing_row +
                '">' +
                ' </td>' +
                '<td class="description">' +
                '<input type="" id="total_price_' + billing_row + '" name="total_price_' + billing_row +
                '" data-row = "' + billing_row + '" class="form-control totalprice">' +
                ' </td>' +
                ' </tr>' +
                '<div style="clear:both"></div>' +
                '<span class="remove-flight-row"><i class="fa fa-times"></i></span>' +
                '<input type="hidden" name="billing_rows" id="billing_row_num" value="' + billing_row + '" />' +
                '</div>';



            $('.items tr:last').after(billing_content);

            $('.product').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-product') }}",
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
                    $('#hiddenProductID' + $(this).data('row')).val(ui.item.code);
                    return false;
                },
                minLength: 1,
                open: function() {

                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {

                    if ($('#hiddenProductID' + $(this).data('row')).val() == '') {
                        $(this).val('');
                        $('#hiddenProductID' + $(this).data('row')).val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });

        });

        $(document).on('click', '.delete-wpr', function() {
            $(this).parent().parent().remove();
        })
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('keyup', '.quantity', function() {

                var row_number = $(this).attr('data-row');
                $('#quantity_total').val(get_total_quantity(row_number));
                $('#total_price_' + row_number).val(get_row_calc(row_number));

                $('#purchase_subtotal').val(get_sub_total());
                $('#purchase_net_total').val(get_net_total());
            });
            $(document).on('keyup', '.unit-price', function() {
                var row_number = $(this).attr('data-row');
                $('#quantity_total').val(get_total_quantity(row_number));
                $('#total_price_' + row_number).val(get_row_calc(row_number));

                $('#purchase_subtotal').val(get_sub_total());

                $('#purchase_net_total').val(get_net_total());
            });
            $(document).on('keyup', '.purchase-discount', function() {
                $('#purchase_net_total').val(get_net_total());
            });

        });

        function get_total_quantity(row_number) {
            var sum = 0;
            $('.quantity').each(function() {
                sum += parseFloat($(this).val());
            });
            return parseInt(sum);

        }

        function get_sub_total() {
            var total = 0;
            $('.totalprice').each(function() {
                total += parseFloat($(this).val());
            });
            return parseFloat(total);

        }

        function get_row_calc(row_number) {
            var unitPrice = $('.unit-price-' + row_number).val();

            var unitPriceR = parseFloat(unitPrice) || 0;

            var billingQnty = $('.quantity-id-' + row_number).val();
            billingQnty = billingQnty.replace(/\,/g, '');
            billingQnty = parseInt(billingQnty, 10);
            var billingQntyR = parseInt(billingQnty) || 0;

            var rowcalcPrice = parseFloat(unitPriceR) * parseInt(billingQntyR);
            return parseFloat(rowcalcPrice);
        }

        function get_net_total() {
            var purchaseDiscount = $('.purchase-discount').val();
            var purchaseDiscountR = parseFloat(purchaseDiscount) || 0;

            var subTotal = $('.purchase-subtotal').val();
            var subTotalR = parseFloat(subTotal) || 0;
            var netTotal = parseFloat(subTotalR) - purchaseDiscountR;
            return parseFloat(netTotal);
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#warehouseID').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-warehouse') }}",
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
                    $('#hiddenWarehouseID').val(ui.item.value);
                    return false;
                },
                minLength: 1,
                open: function() {

                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {

                    if ($('#hiddenWarehouseID').val() == '') {
                        $(this).val('');
                        $('#hiddenWarehouseID').val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });

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



            $('.product').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-product') }}",
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
                    $('#hiddenProductID' + $(this).data('row')).val(ui.item.code);
                    return false;
                },
                minLength: 1,
                open: function() {

                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {

                    if ($('#hiddenProductID' + $(this).data('row')).val() == '') {
                        $(this).val('');
                        $('#hiddenProductID' + $(this).data('row')).val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });

        });

        $("#add_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#add_form')[0]);
            let getpassport_id = $("[name=purchase_id]").val();
            $('#loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('purchases') }}/" + $("[name=purchase_id]").val(),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    window.location.href = "{{ url('purchases') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                window.location.href = "{{ url('purchases') }}/";
//                location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $('#loader').hide();
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
