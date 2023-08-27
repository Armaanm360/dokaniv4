@extends('home')
@section('content')
    <div class="page-toolbar px-xl-4 px-sm-2 px-0 py-3">
        <div class="container-fluid">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col">
                    <ol class="breadcrumb bg-transparent mb-0">
                        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Barcode</li>
                    </ol>
                </div>
            </div> <!-- .row end -->
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="fs-5 color-900 mt-1 mb-0">List of Product</h1>
                    <small class="text-muted">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </small>
                </div>
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-12 mt-2 mt-md-0">
                    <!-- daterange picker -->
                    <div class="input-group">
                        <button class="btn btn-secondary" style="margin-left: 46%;" type="button" data-bs-toggle="tooltip"
                            title="Create Account"><a style="color: white" href="{{ url('barcode/create') }}">Create
                                Barcode</a><i class="fa fa-envelope"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="barcode">
    <p class="name">{{$product->name}}</p>
    <p class="price">Price: {{$product->sale_price}}</p>
    {!! DNS1D::getBarcodeHTML($product->pid, "C128",1.4,22) !!}
    <p class="pid">{{$product->pid}}</p>
</div>
    </div>
@endsection