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
                    <h1 class="fs-5 color-900 mt-1 mb-0">Print Barcode/Label</h1>
                    
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
                        <h4>Print Barcode/Label</h4>
                    </div>
                    <div class="card-body">
                        <form class="row g-3 maskking-form" id="BarcodeForm">
                            @csrf
                            
                            <div class="col-12">
                                <span class="float-label">
                                 <input type="hidden" class="form-control form-control-lg"
                                        id="hidden_product_id" placeholder="Product Name"
                                        name="product_id">

                                    <input type="text" class="form-control form-control-lg"
                                        id="product_id" placeholder="Product Name"
                                        name="product_id">

                                    

                                    <label class="form-label" for="product_id">Product Name</label>
                                </span>
                            </div>
                            


                            <div class="col-6">
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- .row end -->

    </div>
</div>
<!-- end form section -->
@endsection