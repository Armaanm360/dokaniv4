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
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('invoice') }}">Invoice</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Invoice</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
            {{-- @include('layouts.frontend.today_statistics') --}}
        </div>
    </div>
    <!-- start: page body -->
    <form class="row maskking-form" id="add_form">
        @csrf
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
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="exampleFormControlSelect1">Select Customer Type</label>
                                            <select class="form-control form-control-lg" id="customer_type"
                                                name="customer_type">
                                                <option disabled selected>Select Customer Type</option>
                                                <option value="online">Online</option>
                                                <option value="offline">Offline</option>
                                            </select>
                                        </span>
                                        <input type="hidden" id="hiddenAccId" name="expense_account">
                                    </div>
                                    {{-- <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Select Warehouse</label>
                                            <input type="text" class="form-control form-control-lg" id="warehouse"
                                                placeholder="Wearhouse" name="wearhouse">

                                            <input type="hidden" class="form-control form-control-lg"
                                                id="hidden_warehouse_id" placeholder="Wearhouse" name="hidden_warehouse_id"
                                                value=""> </span>
                                    </div> --}}
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Select Branch</label>
                                            <input type="text" class="form-control form-control-lg" id="branchName"
                                                placeholder="branch" name="branch_id">

                                            <input type="hidden" class="form-control form-control-lg" id="hidden_branch_id"
                                                placeholder="Brnach" name="hidden_branch_id" value=""> </span>
                                    </div>
                                    {{-- <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="account_get"
                                                placeholder="Select Sales Man" name="sales_man">
                                        </span>
                                        <input type="hidden" id="hiddenAccId" name="sales_man_id" value="1">
                                    </div> --}}
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Select Staff</label>
                                            <input type="text" class="form-control form-control-lg" id="staff"
                                                placeholder="Select Staff" name="staff">
                                        </span>
                                        <input type="hidden" id="hidden_staff_id" name="hidden_staff_id" value="">
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Select Client</label>
                                            <input type="text" class="form-control form-control-lg" id="client"
                                                placeholder="Select Customer/Client" name="client">
                                        </span>
                                        <input type="hidden" id="hidden_client_id" name="hidden_client_id" value="">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Invoice No</label>
                                            <input type="text" class="form-control form-control-lg" id="invoice_no"
                                                placeholder="Invoice No" name="invoice_no" value="" readonly>
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Product</label>
                                            <input type="text" class="form-control form-control-lg" id="product_get"
                                                placeholder="Scan/Search Product by Name/Code" name="account">
                                        </span>
                                        <input type="hidden" id="hiddenAccId" name="expense_account">
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="delivery">
                                        <br>
                                        <div class="col-lg-3 col-sm-12">
                                            <span class="float-label">
                                                <label for="exampleFormControlSelect1">Select Delivery Man</label>
                                                <select class="form-control form-control-lg" id="delivery_man"
                                                    name="delivery_man">
                                                    <option disabled selected>Select</option>
                                                    @foreach ($delivery as $delivery)
                                                        <option value="{{ $delivery->delivery_men_id }}">
                                                            {{ $delivery->delivery_men_name }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                        </div>

                                        <br>
                                        <div class="col-lg-3 col-sm-12">
                                            <span class="float-label">
                                                <label for="warehouse">Vehicle</label>
                                                <input type="text" readonly class="form-control form-control-lg"
                                                    id="vehicle" value="">
                                            </span>
                                        </div>

                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>
                    <br>
                    <div class="card print_invoice">
                        <div class="card-body">
                            <div class="card p-3">
                                <div style="clear:both"></div>
                                <table class="items">
                                    <tbody>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Item Details</th>
                                            <th>Stock</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Unit Price</th>
                                            <th>Total Unit Price</th>
                                            <th>Discount(%)</th>
                                            <th>Total Price</th>
                                            <th>#</th>
                                        </tr>

                                        <div id="billingDetailsList">
                                            {{-- where loop started --}}
                                        </div>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>
                                        <tr id="hiderow">
                                            {{-- <td colspan="5"><a id="addProductRow" class="addProductRow"
                                                    href="javascript:;" title="Add a row">Add a row</a></td> --}}
                                        </tr>
                                        <tr>

                                            <td colspan="10" width="80%"
                                                class="total-line text-right invoice-subtotal"
                                                style="text-align: right;border:0">Subtotal</td>
                                            <td class="total-value">

                                                <input type="number" name="invoice_subtotal" id="invoiceSubTotal"
                                                    value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Product Discount</td>
                                            <td class="total-value">
                                                <input type="number" name="product_discount" id="productDiscount"
                                                    value="" readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Vat Rate(%)</td>
                                            <td class="total-value">
                                                <input type="number" name="vat_rate" id="vat_rate" value="7.50"
                                                    readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Vat Amount(%)</td>
                                            <td class="total-value">
                                                <input type="number" name="vat_amount" id="vat_amount" value=""
                                                    readonly>
                                            </td>
                                        </tr>

                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Overall Discount</td>
                                            <td class="total-value">
                                                <input type="number" name="overall_discount" id="overall_discount"
                                                    value="">
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Grand Total</td>
                                            <td class="total-value">
                                                <input type="number" name="grand_total" id="grand_total" value=""
                                                    readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Payment Type</td>
                                            <td class="total-value">
                                                <span class="float-label">
                                                    <select class="form-control form-control-lg" id="payment_type"
                                                        name="payment_type">
                                                        <option selected disabled>Select Payment Type</option>

                                                        <option value="BANK">BANK</option>
                                                        <option value="CASH">CASH</option>
                                                        <option value="MOBILE_BANKING">MOBILE_BANKING</option>
                                                    </select>
                                                </span>
                                                <input type="hidden" id="hiddenAccId" name="expense_account">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Account</td>
                                            <td class="total-value">
                                                <span class="float-label">
                                                    <select class="form-control form-control-lg" id="getAccount"
                                                        name="account">

                                                    </select>
                                                </span>
                                                <input type="hidden" id="hiddenAccId" name="expense_account">
                                            </td>
                                        </tr>


                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Total Paying</td>
                                            <td class="total-value">
                                                <input type="number" name="paid_amount" id="paid_amount"
                                                    value="">
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line balance"
                                                style="text-align: right;border:0" id="changed_text_due">Change</td>
                                            <td class="total-value balance">
                                                <div class="due">
                                                    <input class="invoice-due" type="number" name="changed_amount"
                                                        id="changed_amount" value="" readonly>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="col-12 text-center text-md-end" id="InvoiceButtonArea">
                    <button type="submit" class="btn btn-lg btn-primary"><i
                            class="fa fa-print me-2"></i>Payment</button>
                    <button type="button" class="btn btn-lg btn-secondary"><i class="fa fa-envelope me-2"></i>Send
                        PDF</button>
                </div>

                <div class="col-12 text-center text-md-end" id="InvoiceSkipButtonArea" style="display: none">
                    {{-- <a type="button" class="btn btn-lg btn-secondary"
                                href="{{ url('invoice/' . $invoiceNO) }}"><i class="fa fa-envelope me-2"></i>SKIP MONEY
                                RECEIPT</a> --}}
                </div>







    </form>

    <div id='checkMoneyReceipt'></div>

    <script type="text/javascript">
        $('#product_get').autocomplete({
            html: true,
            source: function(request, response) {
                let hidden_branch_id = $('#hidden_branch_id').val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-purchased-product') }}",
                    dataType: "json",
                    data: {
                        q: hidden_branch_id,
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
                var billing_row = document.querySelectorAll('.billing-details-row').length + 1;
                // alert(billing_row);
                var billing_content = ' <tr class="item-row billing-details-row">' +
                    '<input type="hidden" name="billing_rows[]" value="' + billing_row + '">' +
                    '<td class="item-name">' +
                    '<div class="col-12">' +
                    '<td class="description">' +
                    ' <textarea name="billing_description_' + billing_row + '">' + ui.item
                    .items_detail + '</textarea>' +
                    ' <input type="hidden" name="product_' + billing_row + '" value="' + ui.item
                    .items_id + '"/>' +
                    ' </td>' +
                    '</div>' +
                    '</td>' +
                    '<td class="description">' +
                    ' <textarea readonly " data-row="' + billing_row + '" name="item_stock_' + billing_row +
                    '" class="item_stock_' + billing_row + '">' +
                    ui.item
                    .items_quantity + '</textarea>' +
                    ' </td>' +
                    '<td class="description">' +
                    ' <textarea name="item_qty_' + billing_row + '" class="item_qty_' + billing_row +
                    ' qty_get" " data-row="' + billing_row + '"></textarea>' +
                    ' </td>' +
                    ' <td><textarea readonly class="cost" name="item_unit_' + billing_row +
                    '">pcs</textarea></td>' +
                    ' <td><textarea class="cost billing-unit-price item_price item_price_' + billing_row +
                    '" data-row="' + billing_row + '" name="item_unit_price_' + billing_row + '">' + ui.item
                    .items_price +
                    '</textarea></td>' +
                    ' <td><textarea readonly class="qty billing-quantity total_unit_price total_price_quantity_' +
                    billing_row +
                    '" data-row="' +
                    billing_row + '" name="total_price_quantity_' + billing_row + '"></textarea></td>' +

                    '<td>' +
                    ' <textarea name="item_discount_' + billing_row + '" class="item_discount_' + billing_row +
                    ' discount_get" " data-row="' + billing_row + '"></textarea>' +
                    ' </td>' +
                    '<td>' +
                    ' <textarea readonly name="with_discount_' + billing_row + '" class="with_discount_' +
                    billing_row +
                    ' with_discount" " data-row="' + billing_row + '"></textarea>' +
                    '</td>' +
                    '<td><div class="delete-wpr"><a class="delete" href="javascript:;" title="Remove row"><i class="fa-solid fa-trash"></i></a></div></td>'
                ' </tr>' +
                '<div style="clear:both"></div>' +
                '<span class="remove-flight-row"><i class="fa fa-times"></i></span>' +

                '</div>';

                $('.items tr:last').after(billing_content);
                console.log(billing_content);
                $('#product_get').val('');

                return false;
            },
            minLength: 1,
            open: function() {

                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {

                if ($('#hiddenAccId').val() == '') {
                    // $(this).val('');
                    // $('#hiddenAccId').val('');
                    // alert();

                    // $('#ui-menu-item').hide();

                    alert();
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }

        });




        $(document).ready(function() {
            $('div#delivery').hide();
            $('#customer_type').on('change', function() {
                let rand = Math.floor(1000000 + Math.random() * 9000000);
                $('#invoice_no').val(rand);
                if (this.value == 'online') {
                    $('div#delivery').show();
                } else {
                    $('div#delivery').hide();
                }
            });
            $('#delivery_man').on('change', function() {
                let delivery_man = $('#delivery_man').find(":selected").val();
                //alert(delivery_man);
                $.ajax({
                    method: "GET",
                    url: "{{ url('invoice/get-delivery-vehicle') }}" + '/' + delivery_man,
                    success: function(data, textStatus, jqXHR) {
                        $('#vehicle').val(data);
                        // alert(data);
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
            $('#payment_type').on('change', function() {
                let payment_type = $(this).find(":checked").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "GET",
                    url: "{{ url('invoice/account-type') }}" + '/' + payment_type,
                    success: function(data, textStatus, jqXHR) {
                        $('#getAccount').html(data);
                        // $('#productAddBtn').removeClass('disabled');
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
            $(document).on('keyup', '.invoice-quantity', function() {
                var row_number = $(this).attr('data-row');
                // alert(row_number);
                $('.billing-total-' + row_number).val(get_product_price_total(row_number));
                $('#invoiceSubTotal').val(get_sub_total());
                $('#invoiceNetTotal').val(get_net_total());
                $('#due_amount').val(get_net_total());
                $('#invoiceDue').text(get_net_total());
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
            $(document).on('keyup', '.unit-price', function() {
                var row_number = $(this).attr('data-row');
                $('.billing-total-' + row_number).val(get_product_price_total(row_number));
                $('#invoiceSubTotal').val(get_sub_total());
                $('#invoiceNetTotal').val(get_net_total());
                $('#due_amount').val(get_net_total());
                $('#invoiceDue').text(get_net_total());
            });
            $(document).on('blur', '.qty_get', function() {
                var billing_row = $(this).attr('data-row');
                var check_stock = $('.item_stock_' + billing_row).val();
                var check_input = $('.item_qty_' + billing_row).val();
                var final_output = (check_input).toString().padStart(2, 0);
                var final_stock = (check_stock).toString().padStart(2, 0);
                $('#paid_amount').val(0);
                $('#changed_amount').val(0);
                if (final_output > 0 && final_output != 0) {
                    if (final_output > final_stock) {
                        alert('Quantity is exceeded the stock limit');
                        $('.qty_get').val(1);
                    } else {
                        $('.discount_get').val(0);
                        $('.total_price_quantity_' + billing_row).val(get_purchase_total(billing_row));
                        var new_billing_row = $(this).attr('data-row');
                        var vat_rate = $('#vat_rate').val();
                        var vat_amount = $('#vat_amount').val();
                        $('.with_discount_' + new_billing_row).val(get_grand_total(new_billing_row));
                        $('#invoiceSubTotal').val(get_sub_total());
                        $('#productDiscount').val(total_unit_price() - get_sub_total());
                        $('#vat_amount').val(get_sub_total() * (vat_rate / 100));
                        $('#grand_total').val((get_sub_total() * (vat_rate / 100)) + get_sub_total());
                    }
                } else {
                    alert('Quantity cannot be 0 or below 0');
                    $('.qty_get').val('');
                }
            });
            $(document).on('keyup', '.item_price', function() {
                var billing_row = $(this).attr('data-row');
                $('#paid_amount').val(0);
                $('#changed_amount').val(0);
                $('.discount_get').val(0);
                $('.total_price_quantity_' + billing_row).val(get_purchase_total(billing_row));
                var new_billing_row = $(this).attr('data-row');
                var vat_rate = $('#vat_rate').val();
                var vat_amount = $('#vat_amount').val();
                $('.with_discount_' + new_billing_row).val(get_grand_total(new_billing_row));
                $('#invoiceSubTotal').val(get_sub_total());
                $('#productDiscount').val(total_unit_price() - get_sub_total());
                $('#vat_amount').val(get_sub_total() * (vat_rate / 100));
                $('#grand_total').val((get_sub_total() * (vat_rate / 100)) + get_sub_total());
            });
            $(document).on('keyup', '.invoice-discount', function() {
                $('#invoiceNetTotal').val(get_net_total());
                $('#due_amount').val(get_net_total());
                $('#invoiceDue').text(get_net_total());
            });
            $(document).on('click', '.delete', function() {
                $("#add_form").trigger('reset');
            });
            $(document).on('keyup', '.discount_get', function() {
                var new_billing_row = $(this).attr('data-row');
                var vat_rate = $('#vat_rate').val();
                var vat_amount = $('#vat_amount').val();
                $('.with_discount_' + new_billing_row).val(get_grand_total(new_billing_row));
                $('#invoiceSubTotal').val(get_sub_total());
                $('#productDiscount').val(total_unit_price() - get_sub_total());
                $('#vat_amount').val(get_sub_total() * (vat_rate / 100));
                $('#grand_total').val((get_sub_total() * (vat_rate / 100)) + get_sub_total());
                //alert(get_grand_total(new_billing_row));
            });
            $(document).on('keyup', '#overall_discount', function() {
                var overall_discount = $(this).val();
                var vat_rate = $('#vat_rate').val();
                var vat_amount = $('#vat_amount').val();
                //var paid_amount = $('#paid_amount').val();
                //var grand_total = $('#grand_total').val();
                //$('#changed_amount').val(paid_amount - grand_total);
                $('#grand_total').val(((get_sub_total() * (vat_rate / 100)) + get_sub_total()) -
                    overall_discount);
            });
            $(document).on('keyup', '#paid_amount', function() {
                var paid_amount = $('#paid_amount').val();
                var grand_total = $('#grand_total').val();
                $('#changed_amount').val(paid_amount - grand_total);
            });
        });

        function get_product_price_total(row_number) {
            var unitPrice = $('.billing-unit-price-' + row_number).val();
            // alert(unitPrice);
            unitPrice = unitPrice.replace(/\,/g, '');
            unitPrice = parseInt(unitPrice, 10);
            var unitPriceR = parseInt(unitPrice) || 0;
            var billingQnty = $('.billing-quantity-' + row_number).val();
            billingQnty = billingQnty.replace(/\,/g, '');
            billingQnty = parseInt(billingQnty, 10);
            var billingQntyR = parseInt(billingQnty) || 0;
            var ticketClientPrice = parseInt(unitPriceR) * parseInt(billingQntyR);
            return parseInt(ticketClientPrice);
        }

        function get_sub_total() {
            var inputs_product_total = $('.with_discount');
            var unitPrice = 0;
            for (var i = 0; i < inputs_product_total.length; i++) {
                var getValue = $(inputs_product_total[i]).val();
                var num = getValue.replace(/\,/g, '');
                num = parseInt(num, 10);
                if (!isNaN(num)) {
                    unitPrice += num;
                }
            }
            return parseInt(unitPrice);
        }

        function total_unit_price() {
            var inputs_product_total = $('.total_unit_price');
            var unitPrice = 0;
            for (var i = 0; i < inputs_product_total.length; i++) {
                var getValue = $(inputs_product_total[i]).val();
                var num = getValue.replace(/\,/g, '');
                num = parseInt(num, 10);
                if (!isNaN(num)) {
                    unitPrice += num;
                }
            }
            return parseInt(unitPrice);
        }

        function get_net_total() {
            var inputs_product_total = $('.billing-single-total');
            var unitPrice = 0;
            for (var i = 0; i < inputs_product_total.length; i++) {
                var getValue = $(inputs_product_total[i]).val();
                console.log(inputs_product_total[i]);
                var num = getValue.replace(/\,/g, '');
                num = parseInt(num, 10);
                if (!isNaN(num)) {
                    unitPrice += num;
                }
            }
            var invoiceDiscount = $('.invoice-discount').val();
            invoiceDiscount = invoiceDiscount.replace(/\,/g, '');
            invoiceDiscount = parseInt(invoiceDiscount, 10);
            var invoiceDiscountR = parseInt(invoiceDiscount) || 0;
            var netTotal = parseInt(unitPrice) - invoiceDiscountR;
            return parseInt(netTotal);
        }

        function get_product_price_total(row_number) {
            var unitPrice = $('.billing-unit-price-' + row_number).val();
            // alert(unitPrice);
            unitPrice = unitPrice.replace(/\,/g, '');
            unitPrice = parseInt(unitPrice, 10);
            var unitPriceR = parseInt(unitPrice) || 0;
            var billingQnty = $('.billing-quantity-' + row_number).val();
            billingQnty = billingQnty.replace(/\,/g, '');
            billingQnty = parseInt(billingQnty, 10);
            var billingQntyR = parseInt(billingQnty) || 0;
            var ticketClientPrice = parseInt(unitPriceR) * parseInt(billingQntyR);
            return parseInt(ticketClientPrice);
        }
        var billing_row = document.querySelectorAll('.billing-details-row').length + 1;

        function get_purchase_total(billing_row) {
            var unitPrice = $('.item_qty_' + billing_row).val();
            unitPrice = unitPrice.replace(/\,/g, '');
            var unitPriceR = parseInt(unitPrice) || 0;
            var billingQnty = $('.item_price_' + billing_row).val();
            //  alert(billing_row + '=' + billingQnty);
            billingQnty = billingQnty.replace(/\,/g, '');
            billingQnty = parseInt(billingQnty, 10);
            var billingQntyR = parseInt(billingQnty) || 0;
            var ticketClientPrice = parseInt(unitPriceR) * parseInt(billingQntyR);
            return parseInt(ticketClientPrice);
        }
        var new_billing_row = document.querySelectorAll('.billing-details-row').length + 1;

        function get_grand_total(new_billing_row) {
            var discount = $('.item_discount_' + new_billing_row).val();
            discount = discount.replace(/\,/g, '');
            var discountR = parseInt(discount) || 0;
            var billingQnty = $('.total_price_quantity_' + new_billing_row).val();
            billingQnty = billingQnty.replace(/\,/g, '');
            billingQnty = parseInt(billingQnty, 10);
            var billingQntyR = parseInt(billingQnty) || 0;
            //var ticketClientPrice = parseInt(billingQntyR) * parseInt((discountR / 100));
            var ticketClientPrice = billingQntyR - (billingQntyR * (discountR / 100));
            //  alert(ticketClientPrice);
            return parseInt(ticketClientPrice);
        }

        function grandTotal() {
            let subtotal = get_sub_total();
            let vat_amount = $('#vat_amount').val();
            return grandTotal = parseInt(vat_amount, 10) + parseInt(subtotal, 10);
            // return get_sub_total;
        }
        $(document).ready(function() {
            $('#agentID').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-agent') }}",
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
                    $('#hiddenAgentID').val(ui.item.value);
                    return false;
                },
                minLength: 1,
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    if ($('#hiddenClientId').val() == '') {
                        $(this).val('');
                        $('#hiddenClientId').val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });
            $('#searchClient').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-client-full-information') }}",
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
                    $('#hiddenClientID').val(ui.item.value);
                    let showClient =
                        '<textarea class="form-control address" disabled style="background:white;margin-top:10px">\nb' +
                        ui.item.client_name + '\nb' + ui.item.value + '\nb' + ui.item.client_address +
                        '\nb' + ui.item.client_phone + '</textarea>';
                    $('#showClient').html(showClient);
                    return false;
                },
                minLength: 1,
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    if ($('#hiddenClientId').val() == '') {
                        $(this).val('');
                        $('#hiddenClientId').val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });
            $('#searchDeligate').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-deligate') }}",
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
                    $('#hiddenDeligateID').val(ui.item.value);
                    return false;
                },
                minLength: 1,
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    if ($('#hiddenClientId').val() == '') {
                        $(this).val('');
                        $('#hiddenClientId').val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });
            $('#searchSponser').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-sponser') }}",
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
                    $('#hiddenSponserID').val(ui.item.value);
                    return false;
                },
                minLength: 1,
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    if ($('#hiddenSponserID').val() == '') {
                        $(this).val('');
                        $('#hiddenSponserID').val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });
        });
        $("#add_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#add_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('invoice') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    window.location.href = "{{ url('invoice') }}" + '/' + data.sale_id;
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
                        "<span class='error_msg' style='color: red;font-weigh: 600'>" + value +
                        "</span>");
                });
            });
        });
        // $('#warehouse').autocomplete({
        //     html: true,
        //     source: function(request, response) {
        //         $.ajax({
        //             type: "GET",
        //             url: "{{ url('search-warehouse') }}",
        //             dataType: "json",
        //             data: {
        //                 q: request.term,
        //             },
        //             success: function(data) {
        //                 response(data.content);
        //             }
        //         });
        //     },
        //     select: function(event, ui) {
        //         $(this).val(ui.item.label);
        //         $('#hidden_warehouse_id').val(ui.item.value);
        //         // $('#remaining').val(ui.item.remain);
        //         return false;
        //     },
        //     minLength: 1,
        //     open: function() {
        //         $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        //     },
        //     close: function() {
        //         if ($('#hidden_warehouse_id').val() == '') {
        //             $(this).val('');
        //             $('#hidden_warehouse_id').val('');
        //             alert();
        //         }
        //         $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        //     }
        // });
        // $('#branch').on('keyup', function() {
        //     alert();
        // })
        $('#staff').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-staff') }}",
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
                $('#hidden_staff_id').val(ui.item.value);
                // $('#remaining').val(ui.item.remain);
                return false;
            },
            minLength: 1,
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                if ($('#hidden_staff_id').val() == '') {
                    $(this).val('');
                    $('#hidden_staff_id').val('');
                    alert();
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
        $('#client').autocomplete({
            html: true,
            source: function(request, response) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('search-client') }}",
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
                $('#hidden_client_id').val(ui.item.value);
                // $('#remaining').val(ui.item.remain);
                return false;
            },
            minLength: 1,
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                if ($('#hidden_client_id').val() == '') {
                    $(this).val('');
                    $('#hidden_client_id').val('');
                    alert();
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });
    </script>
@endsection
