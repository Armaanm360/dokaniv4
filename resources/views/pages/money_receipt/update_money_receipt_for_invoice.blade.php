
    @inject('MoneyReciept','App\Models\MoneyReciept\MoneyReciept')
    @php
    $selectedAccount = $MoneyReciept->get_selected_account($moneyReceipt[0]->money_reciept_account_transaction_id);
    @endphp
    <!-- start: page body -->
    <form class="row maskking-form" id="money_receipt_form">
        @method("PUT")
        
        <!--Hidden Inputs-->
        <input type="hidden" name="money_reciept_client_id" value="{{$invoice['invoice_client_id']}}">
        <input type="hidden" name="money_reciept_id" id="money_reciept_id" value="{{$moneyReceipt[0]->money_reciept_id}}">
        <input type="hidden" name="money_reciept_client_transaction_id" value="{{$moneyReceipt[0]->money_reciept_client_transaction_id}}">
        <input type="hidden" name="money_reciept_account_transaction_id" value="{{$moneyReceipt[0]->money_reciept_account_transaction_id}}">
        
        
        
        <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
            <div class="container-fluid">
                <!-- Create invoice -->
                <div class="row g-3">
                    <div class="col-12">
                

                        <div class="card print_invoice">
                            <div class="card-header border-bottom fs-4">
                                <h5 class="card-title mb-0">MONEY RECEIPT INFORMATION</h5>
                            </div>
                            <div class="card-body">
                                <div class="card p-3">
                                    <div class="border-bottom pb-2">
                                    

                                        <div class="logoInvoice"> 
                                            <img src="{{asset('public')}}/frontend/assets/img/logo.png" width="530px" alt="logo">
                                        </div>
                                    </div>                                    
                                    <div class="customer mt-4">
                                        <table class="meta">
                                            <tbody>
                                                <tr>
                                                    <td class="meta-head">Voucher No</td>
                                                    <td><textarea class="form-control" name="money_reciept_voucher_no">{{$MoneyReciept->generate_vouchar_no()}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="meta-head">Date</td>
                                                    <td><textarea class="form-control" id="invoice_date">{{date('d-m-Y')}}</textarea></td>
                                                </tr>
                                                <tr>
                                                    <td class="meta-head">Amount Due</td>
                                                    <td>
                                                        <div class="due" id="invoiceDue"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="clear:both"></div>
                                    <table class="items">
                                        <tbody>
                                            <tr>
                                                <th>Invoice No.</th>
                                                <th>Select Account</th>
                                                <th>Invoice Net Total</th>
                                                <th style="width: 140px;">Invoice Due Amount</th>
                                                <th style="width: 140px;">Paid Amount</th>
                                                <th style="width: 70px;">Discount</th>
                                                <th style="width: 140px;">Payment Date</th>
                                            </tr>
                                        <div id="billingDetailsList">
                                            <tr class="item-row billing-details-row">
                                                <td class="item-name">
                                                    <div class="col-12">
                                                <textarea name="money_reciept_invoice_no" readonly>{{$invoice['invoice_no']}}</textarea>
                                                       

                                                    </div>
                                                </td>
                                                <td class="description">
                                                    <select class="form-control form-control-lg custom-select" name="money_reciept_account_id">
                                                         <option value="" disabled selected>
                                                                Select Account
                                                            </option>  
                                                        @foreach($MoneyReciept->list_of_account() as $row)        
                                                            <option value="{{$row->account_id}}" @if($row->account_id == $selectedAccount) selected @endif>{{$row->account_bank_name.', '.$row->account_number}}</option>
                                                            @endforeach
                                                        </select>
                                                </td>

                                                <td class="description">
                                                    <textarea name="money_reciept_invoice_net_total" readonly>{{$invoice['invoice_net_total']}}</textarea>
                                                </td>


                                                <td><textarea class="cost" name="money_reciept_invoice_due_amount" readonly>{{$invoice['due_amount']}}</textarea></td>
                                                <td><textarea class="cost " data-row="1" name="money_reciept_amount"></textarea></td>
                                                <td><textarea class="qty " name="money_reciept_discount" data-row="1"></textarea></td>
                                                <td><input type="date" class="qty" data-row="1" name="money_reciept_date" ></td>
                                            </tr>
                                        </div>
                                        </tbody>
                                    </table>

                                    <div class="footer-note mt-5">
                                        <h5>Note</h5>
                                        <textarea name="money_reciept_note" class="form-control bg-light"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 text-center text-md-end">
                        <a type="button" class="btn btn-lg btn-secondary" href="{{url('invoice/'.$invoice['invoice_no'])}}"><i class="fa fa-envelope me-2"></i>SKIP</a>
                        <button type="submit" class="btn btn-lg btn-primary" ><i class="fa fa-print me-2"></i>Update Money Receipt</button>
                    </div>
                    </form>





    <script type="text/javascript">
       

     var billing_row = document.querySelectorAll('.billing-details-row').length + 1;

 $(document).on('click', '.addProductRow', function () {
           
var billing_content = ' <tr class="item-row billing-details-row">'+ 
                  '<td class="item-name">'+
                    ' <div class="delete-wpr"><a class="delete" href="javascript:;" title="Remove row">X Remove</a></div>'+  
                    '<div class="col-12">'+
                        '<select class="form-control form-control-lg custom-select" name="billing_product_' + billing_row + '">'+
                                '<option value="" disabled selected>Select Product</option> '+                                       
                                    '<option value="PASSPORT">Passport</option>'+
                                    '<option value="VISA">Visa</option>'+
                                    '<option value="MANPOWER">Man Power</option>'+
                                    '<option value="MEDICAL_TEST">Medical Test</option>'+
                                    '<option value="POLICE_CLEARENCE">Police Clearence</option>'+
                                    '<option value="TRAINING_CARD">Training Card</option>'+
                            '</select>'+
                            '</div>'+
                  '</td>'+
                  '<td class="description">'+
                   ' <textarea name="billing_description_' + billing_row + '"></textarea>'+
                 ' </td>'+
                  '<td class="description">'+
                   ' <textarea name="billing_vendor_' + billing_row + '"></textarea>'+
                '  </td>'+
                 ' <td><textarea class="cost" name="billing_cost_price_' + billing_row + ' "></textarea></td>'+
                 ' <td><textarea class="cost billing-unit-price billing-unit-price-' + billing_row + '" data-row="' + billing_row + '" name="billing_unit_price_' + billing_row + ' "></textarea></td>'+
                 ' <td><textarea class="qty billing-quantity billing-quantity-' + billing_row + '" data-row="' + billing_row + '" name="billing_quantity_' + billing_row + ' "></textarea></td>'+
                '  <td><textarea class="qty billing-single-total billing-total billing-total-' + billing_row + '" data-row="' + billing_row + '" name="billing_total_' + billing_row + '" readonly></textarea></td>'+
               ' </tr>' +
        '<div style="clear:both"></div>' +
        '<span class="remove-flight-row"><i class="fa fa-times"></i></span>' +
        '<input type="hidden" name="flight_rows[]" value="' + billing_row + '" />' +
        '</div>';
                   
        $('.items tr:last').after(billing_content);

        });

$(document).on('click', '.delete-wpr', function () {
$(this).parent().parent().remove();
});
    </script>


    <script type="text/javascript">          
    
        $("#money_receipt_form").submit(function(e) {
                e.preventDefault();
                $(".error_msg").html('');
                var data = new FormData($('#money_receipt_form')[0]);
                $moneyReceipt = $('#money_reciept_id').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: "POST",
                    url: "{{ url('money-reciept') }}/"+$moneyReceipt,
                    data: data,
                    cache: false, 
                    contentType: false,
                    processData: false,               
                    success: function(data, textStatus, jqXHR) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Money Receipt has been updated successfully.',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,

                        })
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