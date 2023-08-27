@extends('home')
@section('content')
    @inject('productGet', 'App\Models\Product\Product')
    @inject('productItem', 'App\Models\Product\PurchaseItems')
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('') }}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('invoice') }}">Return Sale</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice Sale Return</li>
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
                                <h6 class="card-title mb-0">Sale Return Info</h6>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="exampleFormControlSelect1">Customer Type</label>
                                            <input type="text" class="form-control form-control-lg"
                                                value="{{ $return[0]->customer_type }}" readonly>
                                        </span>
                                        <input type="hidden" id="hiddenAccId" name="expense_account">
                                    </div>

                                    <input type="hidden" name="sale_id" value="{{ $return[0]->sale_id }}">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Client</label>
                                            <input type="text" class="form-control form-control-lg" id="client"
                                                placeholder="Select Customer/Client" name="client"
                                                value="{{ getClientName($return[0]->client_id) }}" readonly>
                                        </span>
                                        <input type="hidden" id="hidden_client_id" name="hidden_client_id"
                                            value="{{ $return[0]->client_id }}">
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
                                            <label for="warehouse">Branch</label>
                                            <input type="text" class="form-control form-control-lg" id="branchName"
                                                placeholder="branch" name="branch_id"
                                                value="{{ getBranchName($return[0]->branch_id) }}" readonly>

                                            <input type="hidden" class="form-control form-control-lg" id="hidden_branch_id"
                                                placeholder="Brnach" name="hidden_brnach_id"
                                                value="{{ $return[0]->branch_id }}">
                                        </span>
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
                                            <label for="warehouse">Staff</label>
                                            <input type="text" class="form-control form-control-lg" id="staff"
                                                placeholder="Select Staff" name="staff"
                                                value="{{ getStaffName($return[0]->staff_id) }}" readonly>
                                        </span>
                                        <input type="hidden" id="hidden_staff_id" name="hidden_staff_id" value="">
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Invoice No</label>
                                            <input type="text" class="form-control form-control-lg" id="invoice_no"
                                                placeholder="Invoice No" name="invoice_no"
                                                value="{{ $return[0]->invoice_no }}" readonly>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Invoice Date</label>
                                            <input type="text" class="form-control form-control-lg" id="invoice_no"
                                                placeholder="Invoice No" name="invoice_no"
                                                value="{{ $return[0]->invoice_date }}" readonly>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Sales Date</label>
                                            <input type="text" class="form-control form-control-lg" id="invoice_no"
                                                placeholder="Invoice No" name="invoice_no"
                                                value="{{ $return[0]->sales_date }}" readonly>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Return Surcharge Account *</label>
                                            <input type="hidden" name="account_id" id="account_id"
                                                value="{{ $return[0]->account }}">
                                            <select class="form-control form-control-lg" id="account" name="account">
                                                <option disabled selected>Select</option>
                                                {{-- {{ getAccountInfo($return[0]->account) }} --}}
                                            </select>


                                        </span>

                                    </div>
                                    {{-- <div class="col-lg-6 col-sm-12">
                                        <span class="float-label">
                                            <label for="warehouse">Product</label>
                                            <input type="text" class="form-control form-control-lg" id="product_get"
                                                placeholder="Scan/Search Product by Name/Code" name="account">
                                        </span>
                                        <input type="hidden" id="hiddenAccId" name="expense_account">
                                    </div> --}}
                                </div>

                                {{-- <div class="row">
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
                                </div> --}}


                            </div>


                        </div>
                    </div>
                    <br>
                    <div class="card print_invoice">
                        <div class="card-head p-3">
                            <h2>Products*</h2>
                        </div>
                        <div class="card-body">
                            <div class="card p-3">
                                <div style="clear:both"></div>
                                <table class="items">
                                    <tbody>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Sale Price</th>
                                            <th>Quantity</th>
                                            <th>Return</th>
                                            <th>Total Price</th>
                                        </tr>
                                        <div id="billingDetailsList">
                                            <?php
                                            $sl = 0;
                                            ?>

                                            @foreach ($invoice as $invoice)
                                                @php
                                                    $sl++;
                                                    //$productName = '';
                                                    $productId = '';
                                                    //  $testProduct = $productGet->productNameGet($product->product_id);
                                                @endphp
                                                <tr class="item-row billing-details-row">
                                                    {{-- <td class="item-name">
                                                        <div class="col-12">
                                                            <span class="float-label">
                                                                <input type="hidden" readonly
                                                                    class="form-control product form-control-lg"
                                                                    id="productName{{ $sl }}"
                                                                    placeholder="Search Product"
                                                                    data-row="{{ $sl }}"
                                                                    name="product_{{ $sl }}"
                                                                    value="{{ $invoice->product_id }}">
                                                            </span>
                                                        </div>
                                                    </td> --}}
                                                    <td class="description">
                                                        <div class="col-12">
                                                            <span class="float-label">
                                                                <input readonly type="text"
                                                                    class="form-control product form-control-lg"
                                                                    id="productName{{ $sl }}"
                                                                    placeholder="Search Product"
                                                                    data-row="{{ $sl }}"
                                                                    name="purchase_product_id"
                                                                    value="{{ $productGet->productNameGet($invoice->product_id) }}">
                                                            </span>
                                                            <input type="hidden"
                                                                id="hiddenProductID_{{ $sl }}"
                                                                data-row="{{ $sl }}"
                                                                name="product_id_{{ $sl }}"
                                                                value="{{ $invoice->product_id }}">

                                                            <input type="hidden" id="total_qty" name="total_qty">

                                                        </div>
                                                    </td>
                                                    <td class="description">
                                                        <input type="number" id="price_{{ $sl }}"
                                                            data-row="{{ $sl }}"
                                                            name="price_{{ $sl }}"
                                                            value="{{ $invoice->price }}"
                                                            class="form-control form-control-lg price price_{{ $sl }}"
                                                            readonly>

                                                    </td>
                                                    <td class="description">
                                                        <input readonly type="number" id="qty_{{ $sl }}"
                                                            data-row="{{ $sl }}"
                                                            name="qty_{{ $sl }}" {{-- value="{{ getInvoiceCurrentStock($invoice->product_id, $invoice->sale_id) }}" --}}
                                                            value="{{ $invoice->quantity }}" {{-- {{ getBrnachCurrentStocks($invoice->product_id, $invoice->branch_id, $invoice->sale_id) }} --}}
                                                            class="form-control form-control-lg quantity qty_{{ $sl }}">
                                                    </td>
                                                    <td class="description">
                                                        <input type="number" id="return_quan_{{ $sl }}"
                                                            data-row="{{ $sl }}"
                                                            name="return_quan_{{ $sl }}" value=""
                                                            class="form-control form-control-lg return_quan return_quan_{{ $sl }}">
                                                    </td>

                                                    <td class="description">
                                                        <input readonly type="number"
                                                            id="total_price_{{ $sl }}"
                                                            data-row="{{ $sl }}"
                                                            name="total_price_{{ $sl }}"
                                                            value="{{ $invoice->quantity * $invoice->price }}"
                                                            class="form-control form-control-lg total_price total_price_{{ $sl }}">
                                                        <input type="hidden"
                                                            value="{{ $invoice->quantity * $invoice->price }}"
                                                            data-row="{{ $sl }}"
                                                            id="const_total_{{ $sl }}">
                                                    </td>



                                                    <input type="hidden" name="billing_rows[]" id="billing_row_num"
                                                        value="{{ $sl }}" />
                                                </tr>
                                            @endforeach






                                        </div>
                                    </tbody>
                                </table>

                                <table>
                                    <tbody>

                                        <tr>

                                            <td colspan="10" width="80%"
                                                class="total-line text-right invoice-subtotal"
                                                style="text-align: right;border:0">

                                            </td>
                                            <td> <button class="disabled btn btn-larage btn-secondary">Payment
                                                    Calculation</button></td>

                                        </tr>
                                        <tr>

                                            <td colspan="10" width="80%"
                                                class="total-line text-right invoice-subtotal"
                                                style="text-align: right;border:0">Subtotal</td>
                                            <td class="total-value">

                                                <input type="number" name="invoice_subtotal" id="invoiceSubTotal"
                                                    value="{{ $return[0]->subTotal }}" readonly>

                                                <input type="hidden" name="invoice_subtotal_withcharges"
                                                    id="invoice_subtotal_withcharges" value="{{ $return[0]->subTotal }}"
                                                    readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Vat</td>
                                            <td class="total-value">
                                                <input type="number" name="vat_rate" id="vat_rate"
                                                    value="{{ $return[0]->vat_amount }}" readonly>
                                            </td>
                                        </tr>


                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Discount</td>
                                            <td class="total-value">
                                                <input type="number" name="overall_discount" id="overall_discount"
                                                    value="{{ $return[0]->overall_discount }}">
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                <b class="text-danger">Return Charge</b>
                                            </td>
                                            <td class="total-value">
                                                <input type="number" name="return_charge" id="return_charge"
                                                    value="0">
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Net Total</td>
                                            <td class="total-value">
                                                <input type="number" name="net_total" id="net_total"
                                                    value="{{ $return[0]->grand_total }}" readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Paid</td>
                                            <td class="total-value">
                                                <input type="number" name="paid" id="paid"
                                                    value="{{ $return[0]->total_paying }}" readonly>
                                            </td>
                                        </tr>
                                        <tr>

                                            <td colspan="10" class="total-line" style="text-align: right;border:0">
                                                Return Amount</td>
                                            <td class="total-value">
                                                <input type="number" name="return_total" id="return_total"
                                                    value="" readonly>
                                            </td>
                                        </tr>





                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 text-center text-md-start p-3" id="InvoiceButtonArea">
                            <button type="submit" class="btn btn-lg btn-primary"><i class="fa fa-print me-2"></i>Return
                                Sale</button>
                            <button type="button" class="btn btn-lg btn-danger"><i
                                    class="fa fa-envelope me-2"></i>Reset</button>
                        </div>
                    </div>

                </div>





                <div class="col-12 text-center text-md-end" id="InvoiceSkipButtonArea" style="display: none">
                    {{-- <a type="button" class="btn btn-lg btn-secondary"
                                href="{{ url('invoice/' . $invoiceNO) }}"><i class="fa fa-envelope me-2"></i>SKIP MONEY
                                RECEIPT</a> --}}
                </div>







    </form>

    <div id='checkMoneyReceipt'></div>

    <script type="text/javascript">
        $(document).ready(function() {

            let account_id = $('#account_id').val();

            $.ajax({
                method: "GET",
                url: "{{ url('invoice-return-account') }}" + '/' + account_id,
                success: function(data, textStatus, jqXHR) {

                    $('#account').html(data);
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

        $(document).on('keyup', '.return_quan', function() {



            var billing_row = $(this).attr('data-row');


            var check_stock = $('#qty_' + billing_row).val();
            var check_input = $('#return_quan_' + billing_row).val();
            var invoice_subtotal_withcharges = $('#invoice_subtotal_withcharges').val();

            var final_output = (check_input).toString().padStart(2, 0);
            var final_stock = (check_stock).toString().padStart(2, 0);
            $('#paid_amount').val(0);
            $('#changed_amount').val(0);


            if (final_output > 0 && final_output != 0) {
                if (final_output > final_stock) {
                    alert('Quantity is exceeded the stock limit');
                    var const_total = $('#const_total_' + billing_row).val();
                    var check_input = $('#return_quan_' + billing_row).val(' ');
                    $('#total_price_' + billing_row).val(const_total);
                    // var check_input = $('#return_quan_' + billing_row).val(1);
                } else {

                    $('.discount_get').val(0);
                    //$('.total_price_quantity_' + billing_row).val(get_purchase_total(billing_row));
                    // getReturnPriceTotal()

                    var vat_rate = $('#vat_rate').val();
                    var vat_amount = $('#vat_amount').val();

                    //alert(getReturnPriceTotal(billing_row));
                    var const_total = $('#const_total_' + billing_row).val();

                    $('#total_price_' + billing_row).val(const_total - getReturnPriceTotal(billing_row));
                    $('#invoiceSubTotal').val(const_total - getReturnPriceTotal(billing_row));
                    $('#return_total').val(invoice_subtotal_withcharges - getReturnPriceTotal(billing_row));
                    $('#net_total').val(invoice_subtotal_withcharges - getReturnPriceTotal(billing_row));
                    $('#total_qty').val(get_total_qty());


                }
            } else {
                alert('Quantity cannot be 0 or below 0');
                $('.qty_get').val('');
                var const_total = $('#const_total_' + billing_row).val();
                var check_input = $('#return_quan_' + billing_row).val(' ');
                $('#total_price_' + billing_row).val(const_total);
                $('#invoiceSubTotal').val(const_total);
            }




        });


        $(document).on('keyup', '#return_charge', function() {

            var inp = $(this).val();
            var nettotal = $('#net_total').val();

            var final_inp = (inp).toString().padStart(2, 0);



            //alert();

            $('#net_total').val(parseInt(newNetTotal()) + parseInt(inp));
            $('#return_total').val(parseInt(newNetTotal()) - parseInt($(this).val()));






        });


        function getReturnPriceTotal(row_number) {
            var unitPrice = $('#price_' + row_number).val();
            var returnQuan = $('#return_quan_' + row_number).val();
            var totalPrice = $('#total_price_' + row_number).val();
            var const_total = $('#const_total_' + row_number).val();
            // alert(unitPrice);
            unitPrice = unitPrice.replace(/\,/g, '');
            unitPrice = parseInt(unitPrice, 10);
            var unitPriceR = parseInt(unitPrice) || 0;

            // // var billingQnty = $('.billing-quantity-' + row_number).val();
            returnQuan = returnQuan.replace(/\,/g, '');
            returnQuan = parseInt(returnQuan, 10);
            var returnQuanR = parseInt(returnQuan) || 0;

            const_total = totalPrice.replace(/\,/g, '');
            const_total = parseInt(const_total, 10);
            var const_totalR = parseInt(const_total) || 0;

            var ticketClientPrice = (parseInt(unitPriceR) * parseInt(returnQuanR));
            return parseInt(ticketClientPrice);
        }


        function newNetTotal() {

            var charge = $('#return_charge').val();
            var nettotal = $('#invoiceSubTotal').val();

            return $('#invoiceSubTotal').val();


            // return (parseInt(chargeR) + parseInt(nettotalR));



        }


        function get_total_qty() {
            var inputs_product_total = $('.return_quan');
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




        $("#add_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#add_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('invoice-return') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {

                    alert(data);
                    window.location.href = "{{ url('invoice-return') }}" + '/' + data.sale_return;
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
    </script>
@endsection
