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
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('purchases') }}">Purchase</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create Purchase</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
        </div>
    </div>
    <!-- start: page body -->
    <form class="row maskking-form" id="add_form">
        @csrf
        @php
            $date = date('y-m-d');
        @endphp
        <input type="hidden" id="row" value="{{ $row_count }}">
        <input type="hidden" id="date" value="{{ $date }}">
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
                                <input type="hidden" id="row" value="{{ $row_count }}">
                                <input type="hidden" id="date" value="{{ $date }}">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="warehouseID"
                                                placeholder="Search Warehouse" name="purchase_warehouse_id">
                                            <label class="form-label" for="warehouseID">Search Warehouse</label>
                                        </span>
                                        <input type="hidden" id="hiddenWarehouseID" name="purchase_warehouse_id">
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="supplierID"
                                                placeholder="Search Supplier" name="purchase_supplier_id">
                                            <label class="form-label" for="supplierID">Search Supplier</label>
                                        </span>
                                        <input type="hidden" id="hiddenSupplierID" name="purchase_supplier_id">
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg" id="purchase_number"
                                                placeholder="Purchase No" name="purchase_number">
                                            <label class="form-label" for="Purchase Number">Purchase No </label>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="text" class="form-control form-control-lg"
                                                id="purchase_po_reference" placeholder="PO Reference"
                                                name="purchase_po_reference">
                                            <label class="form-label" for="purchase_po_reference">PO Reference </label>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <textarea name="purchase_payment_terms" id="purchase_payment_terms" class="form-control"></textarea>
                                            <label class="form-label" for="purchase_payment_terms">Payment Terms</label>
                                        </span>
                                    </div>

                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="date" class="form-control form-control-lg today"
                                                id="purchase_date" name="purchase_date">
                                            <label class="form-label" for="purchase_date">Purchase Date</label>
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12 mt-5">
                                        <span class="float-label">
                                            <input type="date" class="form-control form-control-lg today" id="due_date"
                                                name="due_date">
                                            <label class="form-label" for="due_date">Due Date</label>
                                        </span>
                                    </div>


                                </div>


                            </div>
                        </div>


                        <br>
                        <hr>


                        <div class="card">
                            <div class="card-header border-bottom fs-4">
                                <h5 class="card-title mb-0">PURCHASE INFORMATION</h5>
                            </div>
                            <div>
                                <div class="search" style="padding-bottom: 20px">
                                    <span class="fa fa-search"></span>
                                    <input value="" id="productName" class="form-control"
                                        placeholder="Search Product By Name or Barcode">
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr style="background: lightgray;border-radius: 5px;">
                                            <th style="border: 1px solid white;">Product Name</th>
                                            <th style="border: 1px solid white;">Product Color</th>
                                            <th style="border: 1px solid white;">Product Size</th>
                                            <th style="width: 20%;text-align: center;border: 1px solid white;">
                                                Quantity<span style="color:red;"> * </span></th>
                                            <th style="width: 20%;text-align: center;border: 1px solid white;">Price</th>
                                            <th style="border: 1px solid white;width: 11%;">Total Price</th>
                                            <th style="width: 7%;text-align: center;border: 1px solid white;">#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDynamic">
                                        <tr id="old_msg" style="background: lightgray;border-radius: 5px;">
                                            <td style="text-align: center;border: 1px solid white;" colspan="5">Search
                                                By Name or Barcode</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="rightAlign" colspan="2">
                                                Total Qty
                                            </th>
                                            <th class="rightAlign">
                                                <input id="totalQuantity" type="text" value="0.00"
                                                    name="purchase_quantity" readonly="">
                                            </th>
                                            <th class="rightAlign">
                                                Total Price
                                            </th>
                                            <th class="rightAlign">
                                                <span id="totalprice">0.00</span>
                                            </th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <table style="margin-top: -20px;" class="table">
                                    <tr>
                                        <td style="width: 66%;border-top: medium none;">

                                        </td>
                                        <td style="width: 15%;border-top: medium none; text-align: right;" colspan="">
                                            Sub Total
                                        </td>
                                        <td style="border-top: medium none;">
                                            <input name="purchase_subtotal" type="text" id="subtotal" readonly
                                                placeholder="0.00" class="form-control rightAlign">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="5" style="border-top: medium none;">
                                            <label for="">Note<sup>*</sup></label>
                                            <textarea class="textarea" name="purchase_note" placeholder="Note"
                                                style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="border-top: medium none; text-align: right;" colspan="">
                                            Discount
                                        </td>
                                        <td style="border-top: medium none;">
                                            <input type="text" id="discount" name="purchase_discount"
                                                placeholder="0.00" class="form-control rightAlign floatPositive"
                                                value="0">
                                        </td>
                                    </tr>



                                    <tr>
                                        <td style="border-top: medium none; text-align: right;" colspan="">
                                            Net Total
                                        </td>
                                        <td style="border-top: medium none;">
                                            <input type="text" id="net_total" name="purchase_net_total" readonly
                                                placeholder="0.00" class="form-control rightAlign">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>



                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-sm"><i
                                class="fa fa-save"></i>&nbsp;&nbsp;Create</button>
                        <a href="" class="btn btn-danger  btn-sm"><i
                                class="fa fa-close"></i>&nbsp;&nbsp;Cancel</a>
                    </div>


                    <input type="hidden" name="total_rows" id="total_rows" value="" />
    </form>

    <table style="display: none;">
        <tbody id="dataSource">
            <tr>
                <td style="vertical-align: middle;">
                    <span class="item_details"></span>
                    <input type="hidden" name="product_id_" value="" class="productID">
                </td>

                <td style="vertical-align: middle;" class="color_name">
                    <select name="color_" class="form-control input-sm color_id">
                        <option value="">Select Color</option>
                        @foreach ($color as $item1)
                        <option value="{{$item1->attributes_value_id}}">{{$item1->attributes_value}}</option>
                        @endforeach
                    </select>
                </td>

                <td style="vertical-align: middle;" class="size_name">
                    <select name="size_" class="form-control input-sm size_id">
                        <option value="">Select Size</option>
                        @foreach ($size as $item)
                            <option value="{{$item->attributes_value_id}}">{{$item->attributes_value}}</option>
                        @endforeach

                    </select>
                </td>

                <td style="width: 8%;">
                    <input type="text" name="qty_" class="form-control integerPositive quantity rightAlign">
                </td>
                <td style="width: 15%;">
                    <input type="text" name="unit_price_" class="form-control floatPositive price rightAlign">
                </td>
                <td style="width: 20%;">
                    <input type="text" name="total_price_" class="form-control totalprice rightAlign" readonly>
                </td>
                <td>
                    <i class="fa fa-trash-o removeRow" style="cursor:pointer;"></i>
                    &nbsp;&nbsp;&nbsp;
                    <i class="fa fa-copy copyRow" style="cursor:pointer;"></i>
                </td>
            </tr>
        </tbody>
    </table>
    <script>
        var iterate_no = 0;

        function getTotalQuantity() {
            var totalQuantity = -1;

            $(".quantity").each(function(i, e) {
                totalQuantity += getValue($(e));
            });

            $('#totalQuantity').val(totalQuantity.toFixed(2));
        }

        function getSubTotal() {
            var total = 0;

            $(".totalprice").each(function(i, e) {
                total += getValue($(e));
            });

            $('#subtotal').val(total.toFixed(2));
        }

        function getNetTotal() {
            var net_total = 0;
            net_total += getValue($('#subtotal'));
            net_total -= getValue($('#discount'));


            $('#net_total').val(net_total.toFixed(2));
            $('#dueamount').val(net_total.toFixed(2));
        }

        function getTr(tr) {
            var quantity = getValue(tr.find('.quantity'));
            var price = getValue(tr.find('.price'));

            tr.find('.totalprice').val((quantity * price).toFixed(2));
        }

        function getValue(object) {
            var value = object.val();
            if (value == '') {
                value = 0;
            } else {
                value = Number(value);
            }
            return value;
        }

        $(document).on('input', '.quantity, .price', function() {
            getTotalQuantity();
            getTr($(this).closest('tr'));
            getSubTotal();
            getNetTotal();
        });

        $(document).on('input', '#discount', function() {
            getNetTotal();
        });

        $(document).on('click', '.removeRow', function() {
            if (confirm("Are you sure want to delete?.")) {
                $(this).closest('tr').remove();
                getTotalQuantity();
                getSubTotal();
                getNetTotal();
            }
            --iterate_no;
            $('#total_rows').val(iterate_no);
        });

        $(document).on('click', '.copyRow', function() {
            var object = $(this).closest('tr');
            addRowProduct({
                id: object.find('.productID').val(),
                value: ''
            }, object.find('.color_id').val());
        });

        var addRowProduct = function(object, isColorSelected = false) {
            ++iterate_no;
            console.log(object);
            $('#dataSource .productID').attr('value', object.code);
            $('#dataSource .productID').attr('name', 'product_id_' + iterate_no);
            $('#dataSource .quantity').attr('value', '1');
            $('#dataSource .quantity').attr('name', 'qty_' + iterate_no);
            $('#dataSource .item_details').text(object.value);
            $('#dataSource .size_id').attr('id', 'size_id_' + iterate_no);
            $('#dataSource .size_id').attr('name', 'size_' + iterate_no);
            $('#dataSource .color_id').attr('id', 'color_id_' + iterate_no);
            $('#dataSource .color_id').attr('name', 'color_' + iterate_no);
            $('#dataSource .price').attr('name', 'unit_price_' + iterate_no);
            $('#dataSource .totalprice').attr('name', 'total_price_' + iterate_no);
            var html = $('#dataSource').html();
            $('#dataSource .price').removeAttr('name');
            $('#dataSource .totalprice').removeAttr('name');
            $('#dataSource .quantity').removeAttr('name');
            $('#dataSource .size_id').removeAttr('id');
            $('#dataSource .color_id').removeAttr('id');
            $('#tableDynamic').append(html);

            // JSON.stringify(addRowProduct);

            getTotalQuantity();

            $('#total_rows').val(iterate_no);


        };
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#warehouseID').keyup(function() {
                let date1 = $('#date').val();
                let row_val = parseInt($('#row').val()) || 0;
                let x = Math.floor((Math.random() * 100000) + 1);
                let newdate = date1.replace(/-|\//g, "");
                let variable = newdate + (row_val + 1);
                $('#purchase_number').val(variable);

            });
            $('#supplierID').keyup(function() {
                let date1 = $('#date').val();
                let row_val = parseFloat($('#row').val()) || 0;
                let x = Math.floor((Math.random() * 100000) + 1);
                let newdate = date1.replace(/-|\//g, "");
                let variable = newdate + (row_val + 1);
                $('#purchase_number').val(variable);

            });

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

                    if ($('#hiddenSupplierID').val() == '') {
                        $(this).val('');
                        $('#hiddenSupplierID').val('');
                    }
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });



            $('#productName').autocomplete({
                html: true,
                source: function(request, response) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('search-product-ssk') }}",
                        dataType: "json",
                        data: {
                            q: request.term,
                        },
                        success: function(data) {
                            response(data.content);
                        }
                    });
                },
                response: function(event, ui) {
                    $("#old_msg").hide();
                    if (ui.content) {
                        if (ui.content.length == 1) {
                            addRowProduct(ui.content[0]);
                            $(this).val('');
                            $(this).focus();
                            $(this).autocomplete('close');
                            return false;
                        } else if (ui.content.length == 0) {
                            $(this).val('');
                            $(this).focus();
                            $(this).autocomplete('close');
                            return false;
                        } else {
                            //alert("This Character and code have no item!!");
                        }
                    }
                },
                select: function(event, ui) {
                    addRowProduct(ui.item);
                    $(this).val('');
                    return false;
                }
            });

        });

        $("#add_form").submit(function(e) {
            e.preventDefault();
            $(this).find(':input[type=submit]').prop('disabled', true);
            $(".error_msg").html('');
            $('.loader').show();
            var data = new FormData($('#add_form')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('purchases') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    $('.loader').hide();
                    window.location.href = "{{ url('purchases') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                $('.loader').hide();
                window.location.href = "{{ url('purchases') }}";
                // location.reload();
            }).fail(function(data, textStatus, jqXHR) {
                $(".loader").hide();
                $(this).find(':input[type=submit]').prop('enabled', true);
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
