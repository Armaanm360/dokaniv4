@extends('home')
@section('content')


<!-- start: page body -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
    <div class="container">
     <div class="row g-3">
   
   <div class="col-12">
    <form id="add_form">
        @method('PUT')
<div class="row">
  
    <div class="col-12">
        
           
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{__('Role Information')}}</div>
                </div>
                <div class="card-body">

                    <div class="col-md-12 col-lg-12">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="name">{{__('Name')}}</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{$roleData['name']}}" placeholder="Enter Name">
                                <input type="hidden" name="id" value="{{ $roleData->id }}">
                            </div>
                            <div class="form-group col-6">
                                Permissions
                                @foreach($all_permissions as $key => $val)
                                <hr>
                                <label class="form-label"> {{$key}} </label>
                                <hr>
                                @foreach($val as $row)                                         
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="checkbox" id="inlineCheckbox{{$key}}_{{ $loop->iteration }}" name="permissions[]" value="{{ $row->id }}" class="selectgroup-input" @if(in_array($row->id, $role_wise_permission_array)) checked="" @endif>
                                        <span class="selectgroup-button" for="inlineCheckbox{{$key}}_{{ $loop->iteration }}">  {{ $row->name }} </span>
                                    </label>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                        </div>

                         <div id="loader" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                    </div>
                </div>

            </div>
    </div>
    <div class="card-action">
        <button type="button" style="float: right" class="btn btn-success" id="add_btn">{{__('Submit')}}</button>
        <button class="btn btn-danger">{{__('Cancel')}}</button>
    </div>
    
</div>
</form>
   </div>
    </div>
   </div>

<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
<script>

    $("#add_btn").click(function () {
        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);
        $('#loader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("roles")}}/" + $("[name=id]").val(),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {

            }
        }).done(function () {
            $("#success_msg").html("Data Save Successfully");
            $("#success_msg").show();
            window.location.href = "{{ url('roles')}}";
            // location.reload();
        }).fail(function (data, textStatus, jqXHR) {
             $('#loader').hide();
            var json_data = JSON.parse(data.responseText);
            $.each(json_data.errors, function (key, value) {
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
</script>
@endsection