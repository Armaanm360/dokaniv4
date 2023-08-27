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
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('purchases') }}">List of Transfers (Warehouse to Branch)</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Transfer</li>
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
                                <h6 class="card-title mb-0">New Transfer (Warehouse to Branch)</h6>
                            </div>
                            <div class="card-body">
<input type="hidden" name="transfer_id" value="{{ $data->warehouse_to_branch_transfer_id }}">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="transfer_date">Transfer Date</label>
                                            <input type="text" class="form-control form-control-lg" id="transfer_date"
                                                placeholder="Transfer Date" name="transfer_date" readonly
                                                value="{{ $data->transfer_date }}">
                                        </span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label for="transfer_no">Transfer No</label>
                                            <input type="text" class="form-control form-control-lg" id=""
                                                placeholder="Transfer No" name="warehouse_to_branch_transfer_number" readonly value="{{ $data->warehouse_to_branch_transfer_number }}"></span>
                                    </div>
                                    <div class="col-lg-3 col-sm-12">
                                        <span class="float-label">
                                            <label class="col-md-4 col-sm-4 col-form-label">From Warehouse</label>

                                            <select class="form-control form-control-lg" name="warehouse_id"
                                                id="from_warehouse">
                                                <option selected disabled>Select Warehouse</option>
                                                @foreach ($warehouseList as $warehouse)
                                                    <option value="{{ $warehouse->warehouse_id }}" @if ($warehouse->warehouse_id == $data->warehouse_id) selected @endif>
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
                                                    <option value="{{ $warehouse->branch_id }}" @if ($warehouse->branch_id == $data->branch_id) selected @endif>
                                                        {{ $warehouse->branch_name }}</option>
                                                @endforeach

                                            </select>

                                            </select>

                                    </div>
                                </div>

                            </div>
                        </div>


                      <br>
                      <hr>


                         <div class="card print_invoice">
                         <div class="card-header border-bottom fs-4">
                           <h5 class="card-title mb-0">TRANSFER INFORMATION</h5>
                         </div>
                         <div class="card-body">
                           <div class="card p-3">
                             <div style="clear:both"></div>
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
                                     <?php

                                     $sl = 0;
                                             ?>
                                     @foreach($transfer_items as $row)
                                     @php
                                        $sl++;
                                        $productName = "";
                                        $productbal = "";
                                     $receipt_by = "";
                                     $product = App\Models\Product\Product::product($row->transfer_product_id);
                                     if ($product) {
                                          $productName = $product->product_name;
                                         }
                                     $productquantity = App\Models\Product\Product::productBal($row->transfer_product_id,$data->warehouse_id);
                                     if ($productquantity) {
                                          $productbal = $productquantity;
                                         }
                                     @endphp
                                 <tr class="item-row billing-details-row">
                                   <td class="item-name">
                                     <div class="col-12">
                                         <input type="text" class="form-control" id="hiddenProductID{{$sl}}" data-row = "{{$sl}}" name="product_id_{{$sl}}" value="{{$row->transfer_product_id}}">
                                     </div>
                                   </td>
                                   <td class="item-name">
                                     <div class="col-12">
                                         <span class="float-label">
<input type="text" class="form-control product form-control-lg" id="productName{{$sl}}" placeholder="Search Product" data-row = "{{$sl}}" name="" value="{{$productName}}">
                                         </span>
                                     </div>
                                   </td>
                                   <td class="description">
                                     <input type="number" id="available_qty_{{$sl}}" data-row = "{{$sl}}" name="available_qty_{{$sl}}" value="{{$productbal}}" class="form-control available_qty available_qty_{{$sl}}" readonly>
                                   </td>
                                   <td class="description">
                                     <input type="" id="qty_{{$sl}}" data-row = "{{$sl}}" name="qty_{{$sl}}" value="{{$row->transfer_product_amount}} "class="form-control qty qty_{{$sl}}">
                                   </td>
                                   <td>
                                    <div class="delete-wpr"><a class="delete" href="javascript:;" title="Remove row">X Remove</a></div>
                                   </td>

                                   <input type="hidden" name="billing_rows" id="billing_row_num" value="{{$sl}}" />
                                 </tr>
                                 @endforeach
                             </div>
                               </tbody>
                             </table>

                                 <table>
                                     <tbody>
                                 <tr id="hiderow">
                                   <td colspan="5"><a id="addProductRow" class="addProductRow" href="javascript:;" title="Add a row">Add a row</a></td>
                                 </tr>

                               </tbody>
                             </table>
                           </div>
                         </div>
                       </div>

                     </div>

                     <label for="">Transfer Note</label>
                     <textarea name="transfer_note" id="" cols="10" rows="5">{!!$data->transfer_note!!}</textarea>

                     <br>

                     <div class="col-12 text-center text-md-end" id="InvoiceButtonArea">
                       <button type="submit" class="btn btn-lg btn-primary" ><i class="fa fa-print me-2"></i>Update Purchase</button>
                     </div>


                   </form>

          </div>
        </div>
    </div>




            <script type="text/javascript">


         $(document).on('click', '.addProductRow', function () {
          var billing_row = document.querySelectorAll('.billing-details-row').length + 1;
        var billing_content = ' <tr class="item-row billing-details-row">'+
                          '<td class="item-name">'+
                            ' <div class="delete-wpr"><a class="delete" href="javascript:;" title="Remove row">X Remove</a></div>'+
                            '<div class="col-12">'+
                                '<span class="float-label">'+
                                    '<input type="text" class="form-control" id="hiddenProductID'+billing_row+'" data-row = "'+ billing_row +'" name="product_id_'+ billing_row +'">'+
                                '</span>'+
                             '</div>'+
                          '</td>'+
                          '<td class="description">'+
                           '<input type="text" id="productName'+billing_row +'" data-row = "'+ billing_row +'" class="form-control product form-control-lg">'+
                         ' </td>'+
                          '<td class="description">'+
                           '<input type="number" id="available_qty_'+billing_row +'" name="available_qty_'+billing_row +'" data-row = "'+ billing_row +'" class="form-control available_qty available_qty_'+billing_row +'" readonly>'+
                         ' </td>'+
                          '<td class="description">'+
                           '<input type="" id="qty_'+billing_row +'" name="qty_'+billing_row +'" data-row = "'+ billing_row +'" class="form-control qty qty_'+billing_row +' ">'+
                         ' </td>'+
                       ' </tr>' +
                '<div style="clear:both"></div>' +
                '<span class="remove-flight-row"><i class="fa fa-times"></i></span>' +
                '<input type="hidden" name="billing_rows" id="billing_row_num" value="'+billing_row+'" />' +
                '</div>';



                $('.items tr:last').after(billing_content);

                            $('.product').autocomplete({
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
                            $('#hiddenProductID'+$(this).data('row')).val(ui.item.items_id);
                            $('#available_qty_'+$(this).data('row')).val(ui.item.items_quantity);
                            return false;
                        },
                        minLength: 1,
                        open: function() {

                            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                        },
                        close: function() {

                            if ($('#hiddenProductID'+$(this).data('row')).val() == '') {
                                $(this).val('');
                                $('#hiddenProductID'+$(this).data('row')).val('');
                            }
                            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                        }
                    });

                });

    $(document).on('click', '.delete-wpr', function () {
    $(this).parent().parent().remove();
    })
            </script>


<script type="text/javascript">
    // $(document).ready(function() {

    //     let r = 'TRANS-' + Math.floor(Math.random() * 90000) + 10000;
    //     $('#transfer_no').val(r);

    // });

    $(document).on('keyup', '.qty', function() {
        var billing_row = $(this).attr('data-row');


        var check_stock = $('.available_qty_' + billing_row).val();
        var check_input = $('.qty_' + billing_row).val();


        var final_stock = (check_stock).toString().padStart(2, 0);
        var final_input = (check_input).toString().padStart(2, 0);

        if (final_input > final_stock) {
            alert('Quantity is exceeded the stock limit');
            $('.qty_' + billing_row).val('');
        } else {
            $('#submitBtnConfirm').removeClass('disabled');

        }


    });



    $('.product').autocomplete({
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
                            $('#hiddenProductID'+$(this).data('row')).val(ui.item.items_id);
                            $('#available_qty_'+$(this).data('row')).val(ui.item.items_quantity);
                            return false;
                        },
                        minLength: 1,
                        open: function() {

                            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                        },
                        close: function() {

                            if ($('#hiddenProductID'+$(this).data('row')).val() == '') {
                                $(this).val('');
                                $('#hiddenProductID'+$(this).data('row')).val('');
                            }
                            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                        }
                    });

    $(document).on('click', '.delete-wpr', function() {
        $(this).parent().parent().remove();
    });



    // $('#from_warehouse').on('change', function() {
    //     let from_warehouse = $(this).find(":checked").val();
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         method: "GET",
    //         url: "{{ url('transfer/fromwarehouse') }}" + '/' + from_warehouse,
    //         success: function(data, textStatus, jqXHR) {

    //             $('#to_warehouse').html(data);
    //             // $('#productAddBtn').removeClass('disabled');

    //             // alert(data);
    //             // $('#InvoiceButtonArea').hide();
    //             // $('#InvoiceSkipButtonArea').show();
    //             //$('#checkMoneyReceipt').html(data);
    //         }
    //     }).done(function() {
    //         $("#success_msg").html("Data Saved Successfully");
    //         // window.location.href = "{{ url('agents') }}";
    //         // location.reload();
    //     }).fail(function(data, textStatus, jqXHR) {
    //         $("#loader").hide();
    //         var json_data = JSON.parse(data.responseText);
    //         $.each(json_data.errors, function(key, value) {
    //             $("#" + key).after(
    //                 "<span class='error_msg' style='color: red;font-weigh: 600'>" +
    //                 value +
    //                 "</span>");
    //         });
    //     });

    // });


    $(document).on('keyup', '.qty', function() {
        var billing_row = $(this).attr('data-row');


        var check_stock = $('.available_qty_' + billing_row).val();
        var check_input = $('.qty_' + billing_row).val();

        if (check_input > check_stock) {
            alert('Quantity is exceeded the stock limit');
            $('.qty_' + billing_row).val('');
        } else {
            $('#submitBtnConfirm').removeClass('disabled');

        }


    });



    $("#add_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#add_form')[0]);
            let getpassport_id = $("[name=transfer_id]").val();
            $('#loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('warehouse-branch-transfer') }}/" + $("[name=transfer_id]").val(),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    window.location.href = "{{ url('warehouse-branch-transfer') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                window.location.href = "{{ url('warehouse-branch-transfer') }}/";
                location.reload();
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
