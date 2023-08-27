 @extends('home')
 @section('content')
 <!-- start: page body -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
 <div class="container">
  <div class="row g-3">
   <!-- Personal Information Card End -->
   <div class="col-12">
    <div class="card">
     <div class="card-header">
      <h6 class="card-title mb-0">Terms</h6>
     </div>
     <div class="card-body">
      <form class="row g-3" id="terms_form">
        @csrf
       <div class="col-lg-12">
        <label class="form-label">Terms</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="textarea" class="form-control" id="terms_details" name="terms_details">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building"
           viewBox="0 0 16 16">
           <path fill-rule="evenodd"
            d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z" />
           <path
            d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z" />
          </svg>
         </div>
        </fieldset>
       </div>


       <div class="col-12">
        <button type="submit" class="btn btn-primary">Save</button>
        <button class="btn btn-outline-secondary">Cancel</button>
       </div>
      </form>
     </div>
    </div>
   </div>

  </div> <!-- .row end -->

 </div>
</div>
<!-- end form section -->
<script type="text/javascript">

    $("#terms_form").submit(function(e) {
        e.preventDefault();
        $(".error_msg").html('');
        var data = new FormData($('#terms_form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{ url('terms') }}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {
              window.location.href = "{{ url('terms') }}";  
            }
        }).done(function() {
            $("#success_msg").html("Data Saved Successfully");
            window.location.href = "{{ url('terms') }}";
           
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