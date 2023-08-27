@extends('home')
@section('content')
<style>
    .dropdown-menu1{
            --bs-dropdown-min-width: 10rem;
    --bs-dropdown-padding-x: 0;
    --bs-dropdown-padding-y: 0.5rem;
    --bs-dropdown-spacer: 0.125rem;
    --bs-dropdown-font-size: 1rem;
    --bs-dropdown-color: #212529;
    --bs-dropdown-bg: #ffffff;
    --bs-dropdown-border-color: var(--bs-border-color-translucent);
    --bs-dropdown-border-radius: 0.375rem;
    --bs-dropdown-border-width: 1px;
    --bs-dropdown-inner-border-radius: calc(0.375rem - 1px);
    --bs-dropdown-divider-bg: var(--bs-border-color-translucent);
    --bs-dropdown-divider-margin-y: 0.5rem;
    --bs-dropdown-box-shadow: 0 0.5rem 1rem rgba(25, 26, 28, 0.15);
    --bs-dropdown-link-color: #212529;
    --bs-dropdown-link-hover-color: #1e2125;
    --bs-dropdown-link-hover-bg: #e9ecef;
    --bs-dropdown-link-active-color: #ffffff;
    --bs-dropdown-link-active-bg: #0d6efd;
    --bs-dropdown-link-disabled-color: #adb5bd;
    --bs-dropdown-item-padding-x: 1rem;
    --bs-dropdown-item-padding-y: 0.25rem;
    --bs-dropdown-header-color: #6c757d;
    --bs-dropdown-header-padding-x: 1rem;
    --bs-dropdown-header-padding-y: 0.5rem;
    position: absolute;
    z-index: 1000;
    display: none;
    min-width: var(--bs-dropdown-min-width);
    padding: var(--bs-dropdown-padding-y) var(--bs-dropdown-padding-x);
    margin: 0;
    font-size: var(--bs-dropdown-font-size);
    color: var(--bs-dropdown-color);
    text-align: left;
    list-style: none;
    background-color: var(--bs-dropdown-bg);
    background-clip: padding-box;
    border: var(--bs-dropdown-border-width) solid var(--bs-dropdown-border-color);
    border-radius: var(--bs-dropdown-border-radius);
    width: 45%;    
    }
    
    .dropdown1.morphing:not(.scale-left) .dropdown-menu1.show, .dropdown1.morphing:not(.scale-right) .dropdown-menu1.show {
    
        opacity: 1;
    visibility: visible;
    transform: translateY(0)!important;
    display: block;
</style>
        <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center" id="menu-navi">
                  <div class="d-flex align-items-center my-1">
                    
                  </div>
                  <div class="fs-5 fw-bold my-1" id="renderRange"></div>
                  <div class="d-flex align-items-center my-1" style="width: 766px;">
                    <div class="dropdown1 morphing scale-left">
                      <button class="btn btn-primary dropdown-toggle" id="dropdownMenu" type="button" data-bs-toggle="dropdown"><i></i><span class="ms-1" id="searchBtn">Search</span></button>
                      <ul class="dropdown-menu1 border-0 shadow" id="showSearchModal" role="menu" >
                          <div class="modal-dialog modal-dialog-vertical modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-secondary rounded-0">
          <h5 class="modal-title text-light">Search Inputs</h5>
          <button type="button" class="btn-close btn-close1" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body custom_scroll">
          <div class="ps-2">
            <!--Timeline item-->
            <div class="timeline-item ti-primary" style="width:100%;max-width: 100%;">
              <div class="avatar sm rounded-circle no-thumbnail">
                <i class="fa fa-phone"></i>
              </div>
              <div class="timeline-content ms-3">
               <div class="main-search1 px-3 flex-fill">
                   <input class="form-control" id="Warehouse" type="text" placeholder="Select Warehouse" style="width: 260%;" OnChanged="warehouseInventory()">
                   <input class="form-control" id="WarehouseID" type="hidden" style="width: 260%;" >
              <div class="card shadow rounded-4 search-result1 slidedown" style="display: none">
                <div class="card-body">     
                  <small class="text-uppercase text-muted">Suggestions</small>
                  <div class="card list-group list-group-flush list-group-custom mt-2">
                  
                      
                                   <input type="hidden" value="" data-row="">
                      <a class="list-group-item list-group-item-action text-truncate place-value" >
                      <div class="fw-bold place-this-value"data-row="">Select Warehouse</div>
                      <!--<small class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>-->
                    </a> 
                      
                      @foreach($warehouses as $row)
                    <input type="hidden" value="{{$row->warehouse_id}}" data-row="{{$row->warehouse_id}}">
                      <a class="list-group-item list-group-item-action text-truncate place-value" >
                      <div class="fw-bold place-this-value"data-row="{{$row->warehouse_id}}">{{$row->warehouse_name}}</div>
                      <!--<small class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>-->
                    </a> 
                     @endforeach
                  </div>

                  
                </div>
              </div>
            </div>
                           <br>
                   <div class="col-6" style="width: 231%;">
                         <select class="form-control form-control-lg custom-select"
                                            name="product_category" id="productCategory">
                                  <option value="" disabled selected>
                                            Select Category
                                        </option>
                             @foreach($product_categories as $row) 
                                        <option value="{{$row->product_category_id }}">{{$row->product_category_name}}</option>
                              
                    @endforeach
                          </select>
                
                                </div>
                  <br>
                  <div class="input-group" style="width: 231%;">
                    <input class="form-control" type="text" id="daterange">
                   
                    <button class="btn btn-secondary" type="button" data-bs-toggle="tooltip" title="Generate Inventory"><i
                            class="fa fa-file-pdf-o"></i></button>
                    
                </div>
                  <br>
                   <div class="col-6">
                                    <span class="float-label" style="width: 460%;">
                                        <input type="text" class="form-control form-control-lg" id="productName"
                                            placeholder="Type" >
                                        <label class="form-label" for="productID">Product</label>
                                    </span>
                                    <input type="hidden" id="hiddenProductID" name="product_id">

                                </div>
         
<!--                  <br>
                   <button class="btn btn-primary" type="button" ><i></i><span class="ms-1" id="searchBtn">Search</span></button>
              </div>-->
            </div>
         
          </div>
        </div>
      </div>
    </div>
                      </ul>
                    </div>
               
                  </div>
                </div>
              </div>


<div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-body">
                <table id="multi-filter-select" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th>Sl</th>                      
                      <th>Product Name</th>
                      <th>Product Code</th>
<!--                      <th>Product Attribute</th>
                      <th>Warehouse</th>-->
                      <th>Purchase Quantity</th>
                      <th>Transfered to Branch</th>
                      <th>Sale Quantity</th>
                      <th>Sale Return Quantity</th>
                      <th>Purchase Return Quantity</th>
                      <th>Available Stock</th>
                      <th>Unit Price</th>
                      <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>



<script>


//      $(document).ready(function () {
          $('#searchBtn').click(function(){
              $('.dropdown-menu1').addClass('show');
//              $('#showSearchModal').addClass('show');
//          alert("Hi");    
          });

    

            
//          alert('Hi');
     var dataTable = $('#multi-filter-select').DataTable({
          "pageLength": 10,
          "processing": true,
          "dom": 'lrtip',
//          DataTables server-side processing mode
          "serverSide": true,
          "order": [],
//          alert('Hi');
    // Initial no order.
       "ajax": {
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "{{url("inventory-list")}}",
        type : 'POST'       
     },
      columns: [
         { data: 'sl' },
         { data: 'product_name' },
         { data: 'product_code' },
//         { data: 'product_attribute' },
//         { data: 'product_warehouse' },
       { data: 'purchase_quantity' }, 
       { data: 'transfered_to_branch' },           
       { data: 'sale_quantity' },            
         { data: 'sale_return_quantity' },
        { data: 'purchase_return_quantity' },
        { data: 'available_stock' },
        { data: 'unit_price' },
        { data: 'total_price' }
      ],
     
       });
       
        $("#productCategory").on('change', function () {
//   alert(this.value);
            dataTable.column(4).search(this.value).draw();
});
        $("#daterange").on('change keyup keydown focusout', function () {

            dataTable.column(5).search(this.value).draw();
});

        

//  });

        
          $('#productName').autocomplete({
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
                $('#hiddenProductId').val(ui.item.value);
                dataTable.column(3).search(ui.item.value).draw();
                return false;
            },
            minLength: 1,
            open: function() {

                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {

                if ($('#hiddenProductId').val() == '') {
                    $(this).val('');
                    $('#hiddenProductId').val('');
                    alert();
                }
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }

        });
        
            
          
          $('.btn-close1').click(function(){
             $('.dropdown-menu1').removeClass('show'); 
          });
          $(".main-search1 input").on("focus", function () {
                $(".search-result1").addClass("show");
                $(".search-result1").show();
            });
            $(".main-search1 input").on("blur", function () {
                setTimeout(function () {
                    $(".search-result1").removeClass("show");                    
                    $(".search-result1").hide();
                }, 200);
            });
            
                $('.place-value').click(function(){
        $('#Warehouse').val($(this).find(".place-this-value").text());
        $('#WarehouseID').val($(this).find(".place-this-value").attr("data-row"));
        dataTable.column(2).search($(this).find(".place-this-value").attr("data-row")).draw();
    });
    
</script>
@endsection