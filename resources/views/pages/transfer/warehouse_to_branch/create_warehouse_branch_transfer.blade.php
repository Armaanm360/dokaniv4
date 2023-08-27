@extends('home')
@section('content')
    <style>
        .search {
            position: relative;
            color: #aaa;
            font-size: 16px;
        }

        /*input {

                height: 32px;

                background: #fcfcfc;
                border: 1px solid #aaa;
                border-radius: 5px;
                box-shadow: 0 0 3px #ccc, 0 10px 15px #ebebeb inset;
            }*/
        .search input {

            height: 32px;

            background: #fcfcfc;
            border: 1px solid #aaa;
            border-radius: 5px;
            box-shadow: 0 0 3px #ccc, 0 10px 15px #ebebeb inset;
        }

        .search input {
            text-indent: 32px;
        }

        .search .fa-search {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .rightAlign {
            text-align: right;
        }
    </style>
    <!-- start: page toolbar -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('') }}}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><a class="text-secondary"
                                href="{{ url('warehouse-branch-transfer') }}">Transfer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Transfer (Warehouse to Branch)</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
        </div>
    </div>
    <form class="row maskking-form" id="add_form">
        @csrf
        <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
            <div class="container-fluid">
                <!-- Create invoice -->
                <div class="row g-3">
                    <div class="col-12">



                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">New Transfer (Warehouse to Branch)</h6>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="transfer_date">Transfer Date</label>
                                            <input type="text" class="form-control form-control-lg" id="transfer_date"
                                                placeholder="Transfer Date" name="transfer_date" readonly
                                                value="{{ date('d-m-Y') }}">
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="transfer_no">Transfer No</label>
                                            <input type="text" class="form-control form-control-lg" id="transfer_no"
                                                placeholder="Transfer No" name="warehouse_to_branch_transfer_number"
                                                readonly value=""></span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label class="col-md-4 col-sm-4 col-form-label">From Warehouse</label>

                                            <select class="form-control form-control-lg" name="warehouse_id"
                                                id="from_warehouse">
                                                <option selected disabled>Select Warehouse</option>
                                                @foreach ($warehouseList as $warehouse)
                                                    <option value="{{ $warehouse->warehouse_id }}">
                                                        {{ $warehouse->warehouse_name }}</option>
                                                @endforeach

                                            </select>

                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label class="col-md-4 col-sm-4 col-form-label">To Branch</label>

                                            <select class="form-control form-control-lg" name="branch_id"
                                                id="from_warehouse">
                                                <option selected disabled>Select Branch</option>
                                                @foreach ($branchList as $warehouse)
                                                    <option value="{{ $warehouse->branch_id }}">
                                                        {{ $warehouse->branch_name }}</option>
                                                @endforeach

                                            </select>

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
                                            Add Product</button>

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
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Available Quantity</th>
                                            <th>Quantity</th>
                                            <th>#</th>
                                        </tr>
                                        <div id="billingDetailsList">
                                            {{-- where loop started --}}
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer">
                            <label for="">Transfer Note</label>
                            <textarea name="transfer_note" id="" cols="10" rows="5"></textarea>

                            <br>
                            <div class="col-12 text-center text-md-end" id="InvoiceButtonArea">
                                <button type="submit" id="submitBtnConfirm" class="btn btn-lg btn-primary disabled"><i
                                        class="fa fa-print me-2"></i>Confirm Transfer</button>
                                {{-- <button type="button" class="btn btn-lg btn-danger"><i
                                    class="fa fa-envelope me-2"></i>Reset</button> --}}
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

            let r = 'TRANS-' + Math.floor(Math.random() * 90000) + 10000;
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



        $('#product_get').autocomplete({
            html: true,
            source: function(request, response) {
                let from_warehouse = $('#from_warehouse').find(":checked").val();
                $.ajax({
                    type: "GET",
                    url: "{{ url('get-purchased-product-list') }}/",
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

            var final_stock = (check_stock).toString().padStart(3, 0);
            var final_input = (check_input).toString().padStart(3, 0);

            if (final_input > final_stock) {
                alert('Quantity is exceeded the stock limit');
                $('.qty-' + billing_row).val('');
            } else {
                $('#submitBtnConfirm').removeClass('disabled');

            }


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
                url: "{{ url('warehouse-branch-transfer') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {

                    $('.loader').hide();
                    window.location.href = "{{ url('warehouse-branch-transfer') }}";

                    // alert('hoise');
                    // $('#InvoiceButtonArea').hide();
                    // $('#InvoiceSkipButtonArea').show();
                    //$('#checkMoneyReceipt').html(data);
                }
            }).done(function() {
                $("#success_msg").html("Data Saved Successfully");
                $('.loader').hide();
                window.location.href = "{{ url('warehouse-branch-transfer') }}";
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
