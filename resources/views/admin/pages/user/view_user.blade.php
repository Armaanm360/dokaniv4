@extends('home')
@section('content')
    <!-- Form section -->
    <!-- start: page toolbar -->

    <!-- start: page body -->
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-md-6 mt-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>User Profile</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap flex-column align-items-center">
                            <div class="mb-3">
                                <img src="https://i.pinimg.com/736x/89/90/48/899048ab0cc455154006fdb9676964b3.jpg"
                                    class="rounded-circle img-thumbnail" alt="profile-image" width="150px" height="150px">
                            </div>
                            <ul class="list-group list-group-custom">
                                <li class="list-group-item"><a class="color-600" href="#">Name:
                                        {{ $user->name }}</a></li>
                                <li class="list-group-item"><a class="color-600" href="#">Email :
                                        {{ $user->email }}</a></li>
                                <li class="list-group-item"><a class="color-600" href="#">Phone :
                                        {{ $user->phone }}</a></li>
                                <li class="list-group-item"><a class="color-600" href="#">Role :
                                        {{ $get_role[0]->name }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <!-- end form section -->


    <script type="text/javascript">
        $(document).ready(function() {


        });


        (document).on();
    </script>
@endsection
