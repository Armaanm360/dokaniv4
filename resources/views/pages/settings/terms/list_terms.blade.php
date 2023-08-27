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
       <a class="btn btn-primary" href="{{url('terms/create')}}" type="button">Add Terms</a>
      </div>
     </div>
    </div>
   </div>
   <div class="col-12">
    <table id="myDataTable_no_filter" class="table myDataTable align-middle custom-table">
     <thead>
      <tr>
       <th>#</th>
       <th>Terms</th>
       <th>Action</th>
      </tr>
     </thead>
     <tbody>
        @foreach ($terms_list as $data)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>
                 {{$data->terms_details}}
            </td>
            <td>
             <a type="button" href="{{ route('terms.edit', $data->terms_id) }}" class="btn btn-link btn-sm text-primary" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Edit"><i class="fa fa-gear"></i></a>
              <a type="button"  class="btn btn-link btn-sm text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Delete" onclick="deleteNow({{ $data->terms_id }})"><i class="fa fa-trash"></i></a>
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
                        url: "terms" + '/' + params,
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