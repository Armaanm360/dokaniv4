 @extends('home')
 @section('content')
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
 <div class="container-fluid">
  <div class="row g-3">
   <div class="col-12">
    <div class="card">
     <div class="card-body">
      <div class="input-group">
       <input type="text" class="form-control" placeholder="Search...">
       <button class="btn btn-secondary" type="button">Search</button>
       {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_customers" type="button">Add Company</button> --}}
       <a class="btn btn-primary" href="{{url('company-info/create')}}" type="button">Add Company</a>
      </div>
      <!-- Modal: Add new Customers -->
      <!-- <button class="btn btn-primary px-4 text-uppercase" data-bs-toggle="modal" data-bs-target="#add_customers" type="button">Add new Customers</button> -->
      {{-- <div class="modal fade" id="add_customers" tabindex="-1" aria-labelledby="add_customers" aria-hidden="true">
       <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
         <div class="modal-header">
          <h5 class="modal-title">Add new Customers</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
          <h6 class="fw-bold">Basic Information</h6>
          <div class="row g-3">
           <div class="col-lg-6 col-md-12">
            <div class="form-floating">
             <input type="text" class="form-control" placeholder="First Name">
             <label>Enter First Name</label>
            </div>
           </div>
           <div class="col-lg-6 col-md-12">
            <div class="form-floating">
             <input type="text" class="form-control" placeholder="Last Name">
             <label>Enter Last Name</label>
            </div>
           </div>
           <div class="col-lg-6 col-md-12">
            <div class="form-floating">
             <input type="date" class="form-control" placeholder="Date of Birth">
             <label>Date of Birth </label>
            </div>
           </div>
           <div class="col-lg-6 col-md-12">
            <div class="form-floating">
             <input type="text" class="form-control" placeholder="Bank details">
             <label>Bank details</label>
            </div>
           </div>
           <div class="col-lg-6 col-md-12">
            <div class="form-floating">
             <select class="form-select form-control">
              <option value="1">VIP</option>
              <option value="2">Vendors</option>
              <option value="2">Regular</option>
             </select>
             <label for="floatingSelect">Customer type</label>
            </div>
           </div>
           <div class="col-lg-6 col-md-12">
            <div class="form-floating">
             <select class="form-select form-control">
              <option value="1">Male</option>
              <option value="2">Female</option>
             </select>
             <label for="floatingSelect">Gender</label>
            </div>
           </div>
           <div class="col-lg-12">
            <label for="formFile" class="form-label">Select Avatar</label>
            <input class="form-control" type="file" id="formFile">
           </div>
           <div class="col-lg-12 col-md-12">
            <div class="form-floating">
             <textarea type="text" class="form-control" placeholder="Address" style="height: 100px"></textarea>
             <label>Address</label>
            </div>
           </div>
          </div>
         </div>
         <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Submit</button>
         </div>
        </div>
       </div>
      </div> --}}
     </div>
    </div>
   </div>
   <div class="col-12">
    <table id="myDataTable_no_filter" class="table myDataTable align-middle custom-table">
     <thead>
      <tr>
       <th>#</th>
       <th>Company Name</th>
       <th>Mobile</th>
       <th>Email</th>
       <th>Address</th>
       <th>Action</th>
      </tr>
     </thead>
     <tbody>
        @foreach ($company_info_list as $data)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>
                 {{$data->company_name}}
            </td>
            <td>{{$data->company_phone}}</td>
            <td>{{$data->company_email}}</td>
            <td>
                {{$data->company_address}}
            </td>
            <td>
             <a type="button" href="{{ route('company-info.edit', $data->company_id) }}" class="btn btn-link btn-sm text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Edit"><i class="fa fa-gear"></i></a>
              <a type="button"  class="btn btn-link btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Delete" onclick="deleteNow({{ $data->company_id }})"><i class="fa fa-trash"></i></a>
            </td>
           </tr>
        @endforeach
     </tbody>
    </table>
   </div>
  </div> <!-- .row end -->
 </div>
</div>
<script type="text/javascript">
        function deleteNow(params) {
            var isConfirm = confirm('Are You Sure!');
    if (isConfirm) {          
                    $('.loader').show();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        url: "company-info" + '/' + params,
                        success: function(data) {
                            location.reload();
                        }
                    }).done(function() {
                        $("#success_msg").html("Data Save Successfully");
                    }).fail(function(data, textStatus, jqXHR) {
                        $('.loader').hide();
                        var json_data = JSON.parse(data.responseText);
                        $.each(json_data.errors, function(key, value) {
                            $("#" + key).after(
                                "<span class='error_msg' style='color: red;font-weigh: 600'>" +
                                value +
                                "</span>");
                        });
                    });
    } else {
        $('.loader').hide();
    }
        }



 
</script>
  @endsection