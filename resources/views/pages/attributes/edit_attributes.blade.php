
 @extends('home')
 @section('content')
<!-- Form section -->
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-secondary" href="javascript:void()">Attributes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Attributes</li>
                    </ol>
                </div>
                <div class="col text-md-end">
                    <a class="btn btn-primary" href="{{ url('attributes') }}"><i class="fa fa-list me-2"></i>List Of Attributes</a>
                    {{-- <a class="btn btn-secondary" href="{{ 'agents/create' }}"><i class="fa fa-user me-2"></i>Create
    Agent</a> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- start: page body -->
    <div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
        <div class="container-fluid">
            <div class="row g-3">


                <!-- Form Validation -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Edit Attributes</h6>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 maskking-form" id="attributes_form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="attributes_id" value="{{$data->attributes_id}}">
                                <div class="col-lg-12">
                                    <span class="float-label">
                                        <input type="text" class="form-control form-control-lg" id="attributes_name"
                                            placeholder="Attributes Name" name="attributes_name" value="{{$data->attributes_name}}">
                                        <label class="form-label" for="TextInput">Attributes Name</label>
                                    </span>
                                </div>


                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
        $("#attributes_form").submit(function(e) {
            e.preventDefault();
            $(".error_msg").html('');
            var data = new FormData($('#attributes_form')[0]);
            let getpassport_id = $("[name=attributes_id]").val();
            $('#loader').show();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: "{{ url('attributes') }}/" + $("[name=attributes_id]").val(),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data, textStatus, jqXHR) {
                    window.location.href = "{{ url('attributes') }}";
                }
            }).done(function() {
                $("#success_msg").html("Data Save Successfully");
                //window.location.href = "{{ url('users') }}/";
                // location.reload();
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

        var uploadField = document.getElementById("filecheck");

            uploadField.onchange = function() {
                if(this.files[0].size > 2097152){
                alert("File is too big!");
                this.value = "";
                };
            };
    </script>


@endsection
