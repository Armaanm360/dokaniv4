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
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('purchase-return') }}">Purchase Return</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Purchase Return</li>
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

                @method('PUT')
            <div class="col-12">



                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">BASIC INFORMATION</h6>
                    </div>
                    <div class="card-body">
                        <input type="hidden" id="purchase_return_id" name="purchase_return_id" value="{{$data->purchase_return_id}}">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 mt-5">
                                <span class="float-label">
                                    <input type="text" class="form-control form-control-lg"
                                        id="purchase_number" placeholder="Purchase No" name="purchase_number" value="{{$data->purchase_number}}">
                                    <label class="form-label" for="Purchase Number">Purchase No </label>
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-12 mt-5">
                                <span class="float-label">
                                    <input type="text" class="form-control form-control-lg"
                                        id="purchase_return_number" placeholder="Purchase Return Number" name="purchase_return_number" value="{{$data->purchase_return_number}}">
                                    <label class="form-label" for="purchase_return_number">Purchase Return Number </label>
                                </span>
                            </div>
                        </div>


                    </div>
                </div>


             <br>
             <hr>


                <div class="card print_invoice">
                <div class="card-header border-bottom fs-4">
                  <h5 class="card-title mb-0">PURCHASE RETURN INFORMATION</h5>
                </div>
                <div class="card-body">
                    <div class="card p-3">
                      <div style="clear:both"></div>
                      <table class="items">
                        <tbody>
                          <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Purchase Quantity</th>
                            <th>Balance Quantity</th>
                            <th>Return Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Return Price</th>
                          </tr>
                          <?php
                             $sl = 0;
                           ?>
                          @foreach ($purchase_return_items as $purchase)
                          @php
                          $sl++;
                              $product_name = '';
                              $product_returned = '';
                              $product = App\Models\Product\Product::productName($purchase->purchase_product_id);
                              if ($product) {
                                 $product_name = $product->product_name;
                              }
                             $product3 = App\Models\Product\PurchaseReturnItems::productBalance($data->purchase_number,$purchase->purchase_product_id);

                             $product_returned = $product3;
                          @endphp
                              <tr>
                                 <td>{{ $loop->index + 1 }}</td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product form-control-lg" data-row = "{{$sl}}" value="{{$product_name}}" readonly>
                                         </span>
                                         <input type="hidden" id="purchase_product_id_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_id_{{$sl}}" value="{{$purchase->purchase_product_id}}" readonly>

                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product form-control-lg"
                                                 id="purchase_product_color_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_color_{{$sl}}" value="{{$purchase->purchase_product_color}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product form-control-lg"
                                                 id="purchase_product_size_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_size_{{$sl}}" value="{{$purchase->purchase_product_size}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product-purchase-quantity product-purchase-quantity-{{$sl}} form-control-lg"
                                                 id="purchase_product_quantity_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_quantity_{{$sl}}" value="{{$purchase->purchase_product_quantity}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product-balance product-balance-amount-{{$sl}} form-control-lg"
                                                 id="purchase_product_balance_{{$sl}}" data-row = "{{$sl}}" value="{{ $purchase->purchase_product_quantity - $product_returned}}" name="purchase_product_balance_{{$sl}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product-return product-return-amount-{{$sl}} form-control-lg"
                                                 id="purchase_product_return_quantity_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_return_quantity_{{$sl}}" value="{{$purchase->purchase_product_return_quantity}}">
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product-unit-price-{{$sl}} form-control-lg"
                                                 id="purchase_product_price_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_price_{{$sl}}" value="{{$purchase->purchase_product_price}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product form-control-lg"
                                                 id="purchase_product_total_price_{{$sl}}" data-row = "{{$sl}}" name="purchase_product_total_price_{{$sl}}" value="{{$purchase->purchase_product_total_price}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <td>
                                     <div class="col-12">
                                         <span class="float-label">
                                             <input type="text" class="form-control product-total-price form-control-lg"
                                                 id="purchase_return_product_total_price_{{$sl}}" data-row = "{{$sl}}" name="purchase_return_product_total_price_{{$sl}}" value="{{$purchase->purchase_return_product_total_price}}" readonly>
                                         </span>
                                     </div>
                                 </td>
                                 <input type="hidden" name="total_rows" id="total_rows" value="{{$sl}}" />
                             </tr>
                          @endforeach

                        </tbody>
                      </table>

                          <table>
                              <tbody>
                          {{-- <tr>
                            <td class="total-line text-right invoice-subtotal" style="text-align: right;border:0">Total Purchase Balance</td>
                            <td class="total-value">
                             <input type="number" name="purchase_quantity_balance" id="purchase_quantity_balance" value="" class="form-control" readonly>
                            </td>
                          </tr> --}}
                          <tr>

                            <td class="total-line text-right invoice-subtotal" style="text-align: right;border:0">Total Purchase Quantity</td>
                            <td class="total-value">
                             <input type="number" name="purchase_total_quantity" id="purchase_total_quantity" value="{{$data->purchase_total_quantity}}" class="form-control"  readonly>
                            </td>
                            <td class="total-line text-right invoice-subtotal" style="text-align: right;border:0">Total Return Quantity</td>
                            <td class="total-value">
                             <input type="number" name="purchase_return_total_quantity" id="purchase_return_total_quantity" class="form-control" value="{{$data->purchase_return_total_quantity}}" readonly>
                            </td>
                          </tr>
                          <tr>

                            <td class="total-line" style="text-align: right;border:0">Purchase Sub Total</td>
                            <td class="total-value">
                              <input type="number" class="form-control purchase-subtotal" name="purchase_subtotal" id="purchase_subtotal" value="{{$data->purchase_subtotal}}" readonly>
                            </td>
                            <td class="total-line" style="text-align: right;border:0">Return Sub Total</td>
                            <td class="total-value">
                              <input type="number" class="form-control purchase-return-subtotal" name="purchase_return_subtotal" id="purchase_return_subtotal" value="{{$data->purchase_return_subtotal}}"  readonly>
                            </td>
                          </tr>

                          <tr>

                              <td class="total-line" style="text-align: right;border:0">Purchase Discount</td>
                              <td class="total-value">
                                <input type="number" class="form-control purchase-discount" name="purchase_discount" id="purchase_discount" value="{{$data->purchase_discount}}">
                              </td>
                              <td class="total-line" style="text-align: right;border:0">Return Discount</td>
                              <td class="total-value">
                                <input type="number" class="form-control purchase-return-discount" name="purchase_return_discount" id="purchase_return_discount" value="{{$data->purchase_return_discount}}">
                              </td>
                            </tr>

                          <tr>
                            <td class="total-line balance" style="text-align: right;border:0">Purchase Net Total</td>
                            <td class="total-value balance">
                              <div class="due">
                                  <input class="form-control purchase-net-total" type="number" name="purchase_net_total" id="purchase_net_total" value="{{$data->purchase_net_total}}" readonly>
                              </div>
                            </td>
                            <td class="total-line balance" style="text-align: right;border:0">Return Net Total</td>
                            <td class="total-value balance">
                              <div class="due">
                                  <input class="form-control purchase-return-net-total" type="number" name="purchase_return_net_total" id="purchase_return_net_total" value="{{$data->purchase_return_net_total}}" readonly>
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
              <button type="submit" class="btn btn-lg btn-primary" ><i class="fa fa-print me-2"></i>Update Purchase Return</button>
            </div>


          </form>


          <script type="text/javascript">

            $(document).ready(function(){

                $("#add_form").submit(function(e) {
                    alert('test');
                        e.preventDefault();
                        $(".error_msg").html('');
                        var data = new FormData($('#add_form')[0]);
                        let getpassport_id = $("[name=purchase_return_id]").val();
                        $('#loader').show();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            method: "POST",
                            url: "{{ url('purchase-return') }}/" + $("[name=purchase_return_id]").val(),
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(data, textStatus, jqXHR) {
                                window.location.href = "{{ url('purchase-return') }}";
                            }
                        }).done(function() {
                            $("#success_msg").html("Data Save Successfully");
                            window.location.href = "{{ url('purchase-return') }}";
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

                $(document).on('keyup', '.product-return', function(){
                    var row_number = $(this).attr('data-row');
                       let returnamount = $('.product-return-amount-'+row_number).val();
                       returnamount =returnamount.replace(/\,/g,'');
                       returnamount=parseInt(returnamount,10);
                       var returnamountR = parseInt(returnamount) || 0;

                       let balanceamount = $('.product-balance-amount-'+row_number).val();
                       balanceamount =balanceamount.replace(/\,/g,'');
                       balanceamount=parseInt(balanceamount,10);
                       var balanceamountR = parseInt(balanceamount) || 0;

                       let text = 0;

                        if(returnamountR > balanceamountR){
                        alert('Return Amount cannot be greated than Balance Amount');

                        $('#purchase_product_return_quantity_'+row_number).val(text);

                        // let getValue= document.getElementById("date_of_passport_expiry");
                        // if (getValue.value !="") {
                        //     getValue.value = "";
                        // }

                       }

                      else{
                        $('#purchase_product_return_quantity_'+row_number).val(returnamountR);
                      }

                    var row_number = $(this).attr('data-row');
                    $('#purchase_return_total_quantity').val(get_total_quantity(row_number));
                    $('#purchase_return_product_total_price_'+row_number).val(get_row_calc(row_number));

                    // $('#purchase_product_balance_'+row_number).val(get_row_calc_balance(row_number));

                    $('#purchase_return_subtotal').val(get_sub_total());
                    $('#purchase_return_net_total').val(get_net_total());


                });


            });
            $(document).on('keyup', '.purchase-return-discount', function(){
                                $('#purchase_return_net_total').val(get_net_total());
                            });
            function get_total_quantity(row_number)
            {
                var sum = 0;
                $('.product-return').each(function()
                {
                    sum += parseFloat($(this).val());
                });
                return parseInt(sum);

            }
            function get_sub_total()
            {
                var total = 0;
                $('.product-total-price').each(function()
                {
                    total += parseFloat($(this).val());
                });
                return parseFloat(total);

            }
            function get_row_calc(row_number)
            {
                var unitPrice = $('.product-unit-price-'+row_number).val();

                var unitPriceR = parseFloat(unitPrice) || 0;

                var billingQnty = $('.product-return-amount-'+row_number).val();
                billingQnty=billingQnty.replace(/\,/g,'');
                billingQnty=parseInt(billingQnty,10);
                var billingQntyR = parseInt(billingQnty) || 0;

                var rowcalcPrice = parseFloat(unitPriceR) * parseInt(billingQntyR);
                return parseFloat(rowcalcPrice);
            }



            function get_net_total()
            {
                var purchaseDiscount = $('.purchase-return-discount').val();
                var purchaseDiscountR = parseFloat(purchaseDiscount) || 0;

                var subTotal = $('.purchase-return-subtotal').val();
                var subTotalR = parseFloat(subTotal) || 0;

                var netTotal = parseFloat(subTotalR) - purchaseDiscountR;
                return parseFloat(netTotal);
            }


            </script>



@endsection
