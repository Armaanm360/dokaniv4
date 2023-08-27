@extends('home')
@section('content')
<div class="barcode" style="margin-left: 15%;margin-top: 3%;margin-bottom: 37%;">
    <p class="name">{{$product->product_name}}</p>
    <p class="price">Price: {{$product->product_retail_price}}</p>
    {!! DNS1D::getBarcodeHTML($product->product_entry_id, "C128",1.4,22) !!}
    <p class="pid">{{$product->product_entry_id}}</p>
</div>
@endsection