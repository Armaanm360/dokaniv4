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
      <h6 class="card-title mb-0">Company Information</h6>
     </div>
     <div class="card-body">
      <form class="row g-3" id="company_form">
        @csrf
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Name</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control" id="company_name" name="company_name">
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
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Number</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_phone" name="company_phone">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Email</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_email" name="company_email">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Website</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_website" name="company_website">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Facebook Page</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_facebook_page" name="company_facebook_page">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Currency</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_currency" name="company_currency">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Database</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_database_backup_email" name="company_database_backup_email">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">User Limit</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_user_limit" name="company_user_limit">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Address</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_address" name="company_address">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Logo Width</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_logo_width" name="company_logo_width">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Logo Height</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="text" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_logo_height" name="company_logo_height">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
          </svg>
         </div>
        </fieldset>
       </div>
       <div class="col-lg-4 col-md-6 col-sm-6">
        <label class="form-label">Company Logo</label>
        <fieldset class="form-icon-group left-icon position-relative">
         <input type="file" class="form-control phone-number" placeholder="Ex: (000) 000-00-00" id="company_logo" name="company_logo">
         <div class="form-icon position-absolute">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone"
           viewBox="0 0 16 16">
           <path
            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
           <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
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

    $("#company_form").submit(function(e) {
        e.preventDefault();
        $(".error_msg").html('');
        var data = new FormData($('#company_form')[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{ url('company-info') }}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data, textStatus, jqXHR) {
              window.location.href = "{{ url('company-info') }}";  
            }
        }).done(function() {
            $("#success_msg").html("Data Saved Successfully");
            window.location.href = "{{ url('company-info') }}";
           
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