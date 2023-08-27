@extends('home')
@section('content')

<div class="content">
    <div class="page-inner">

        <div class="row">
            <div class="col-md-12">
                <form class="maskking-form"  id="add_form">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">{{__('Permission Information')}}</div>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="Name">
                                        {{__('Permission Section')}}
                                        </label>
                                        <input type="text" class="form-control" name="section_name" id="section_name" placeholder="Permission Section">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="Name">
                                        {{__('Permission Name')}}  <span class="add" style="color: green;cursor: pointer;">[Add New Permission]</span>
                                        </label>
                                        <div class="optionBox">
                                            <div class="block">
                                                <input type="text" class="form-control" name="name[]" id="name.0" placeholder="Permission Name">
                                            </div>
                                        </div>
                                    </div>
                                 <div id="loader" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                              
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-action">
                        <button type="button" class="btn btn-success" id="add_btn">{{__('Submit')}}</button>
                        <button class="btn btn-danger">{{__('Cancel')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>-->
<script>
    
    $("#add_btn").click(function (){
        $(".error_msg").html('');
        var data = new FormData($('#add_form')[0]);
        $("#loader").show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: "{{url("permissions")}}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, jqXHR) {
                
            }
        }).done(function() {
            $("#success_msg").html("Data Save Successfully");
            $("#success_msg").show();
            setInterval(function() {
                window.location.href = "{{ url('permissions')}}";
            }, 2000);
            // location.reload();
        }).fail(function(data, textStatus, jqXHR) {
            $("#loader").hide();
            var json_data = JSON.parse(data.responseText);
            $.each(json_data, function(key, value){
//                console.log(key);
                $("#" + key).after("<span class='error_msg' style='color: red;font-weigh: 600'>" + value + "</span>");
            });
        });
    });
    
    
    var id = 1;
    $('.add').click(function () {
        id++;
//        alert(id);
        $('.block:last').after('<div class="block" style="text-align: left;">\
                                    <div class="row"><input type="text" class="form-control" name="name[]" id="name.'+id+'" placeholder="Permission Name" style="width: 86%;float: left;margin: 10px 15px 0 auto;">\
                                    <span class="remove btn btn-danger" style="margin: 10px 0;">X</span>\
                               </div> </div>');
    
    });
    
    $('.optionBox').on('click', '.remove', function () {
        $(this).parent().remove();
    });
</script>
@endsection