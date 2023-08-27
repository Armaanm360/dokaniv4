@inject('profitLoss','App\Models\Reports\ProfitLoss\ProfitLoss') 
    <!-- Form section -->
    <!-- start: page toolbar -->
    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container-fluid">
            <div class="row g-3">
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 style="color: darkcyan;font-weight: bold">Gross Profit Loss
                                
                                @php
                                $sales = $profitLoss->get_sales($from,$to);
                                $costs = $profitLoss->get_costs($from,$to);
                                $salesProfit = $sales - $costs;   
                                $generalExpense = $profitLoss->get_general_expense($from,$to);
                                $invoiceDiscount = $profitLoss->get_total_invoice_discount($from,$to);
                                $moneyReceiptDiscount = $profitLoss->get_total_money_receipt_discount($from,$to);
                                $totalExpense = $generalExpense + $invoiceDiscount + $moneyReceiptDiscount;
                                $grossProfit = $salesProfit;
                                $netProfit = $grossProfit - $totalExpense;
                                @endphp
</h5>
                        </div>
                        <div class="card-body">
                            <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                                
                                
                                <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">Total Sales: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$sales}}</td>
				
			</tr>
                        
                        <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">Total Cost: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$costs}}</td>
				
			</tr>
                      
                        <tr>
				<td colspan="1" style="text-align: right;font-weight:bold;">Sales Profit: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$salesProfit}}</td>
				
			</tr>
                        
                        <tr>
				<td colspan="1" style="text-align: right;font-weight:bold;color: #684b4b">Gross Profit Loss </td>
				<td style="text-align:left;font-weight:bold;color: #684b4b;">{{$grossProfit}}</td>
				
			</tr>
                                
                                
                               
                               
                            </table>
                        </div>
                    </div>
                    
                    <br>
                    
                          <div class="card">
                        <div class="card-header">
                            <h5 style="color: darkcyan;font-weight: bold">Expense</h5>
</h5>
                        </div>
                        <div class="card-body">
                            <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                                
                                
                                <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">General Expense: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$generalExpense}}</td>
				
			</tr>
                        
                        <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">Invoice Discount: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$invoiceDiscount}}</td>
				
			</tr>
                      
                        <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">Money Receipt Discount: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$moneyReceiptDiscount}}</td>
				
			</tr>
                        
                       
                        <tr>
				<td colspan="1" style="text-align: right;font-weight:bold;color: red">Total Expense: </td>
				<td style="text-align:left;font-weight:bold;color: red;">{{$totalExpense}}</td>
				
			</tr>
                                
                                
                               
                               
                            </table>
                        </div>
                    </div>
                    
                    
                      <br>
                    
                          <div class="card">
                        <div class="card-header">
                            <h5 style="color: darkcyan;font-weight: bold">Net Profit Loss</h5>
</h5>
                        </div>
                        <div class="card-body">
                            <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                                
                                
                                <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">Total Gross Profit Loss: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$grossProfit}}</td>
				
			</tr>
                        
                        <tr>
				<td colspan="1" style="text-align: center;font-weight:bold;">Total Expense: </td>
				<td style="text-align:left;font-weight:bold;color: black;">{{$totalExpense}}</td>
				
			</tr>
                      
                       
                        <tr>
				<td colspan="1" style="text-align: right;font-weight:bold;color:#8f0f0f">Net Profit Loss: </td>
				<td style="text-align:left;font-weight:bold;color: #8f0f0f;">{{$netProfit}}</td>
				
			</tr>
                                
                                
                               
                               
                            </table>
                        </div>
                    </div>
         
                </div>
            </div>
        </div>
    </div>

    <!-- start: page body -->

    <!-- end form section -->


    <script type="text/javascript">
        function deleteUser(params) {
            Swal.fire({
                title: 'Do You Want To Delete The Deligate?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    let getuser_id = $("[name=deligate_id]").val();
                    $('#loader').show();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: 'delegate/clear'+ '/' + params,
                        success: function(data) {
                            window.location.href = "{{ url('deligates') }}/";

                        }
                    }).done(function() {
                        $("#success_msg").html("Data Deleted Successfully");
                        //window.location.href = "{{ url('users') }}/";
                        Swal.fire('Deligate Has Been Deleted', '', 'success')
                    }).fail(function(data, textStatus, jqXHR) {
                        $('#loader').hide();
                        var json_data = JSON.parse(data.responseText);
                        $.each(json_data.errors, function(key, value) {
                            $("#" + key).after(
                                "<span class='error_msg' style='color: red;font-weigh: 600'>" +
                                value +
                                "</span>");
                        });
                    });


                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            })
        }
        $(document).ready(function() {


        });


        (document).on();
    </script>
