@extends('layouts.app')

@section('content')
<div class="order-page">
    <div class="page-header mb-3 pb-0">
        <h4>Success!</h4>
        <a class="btn btn-link m-0 p-0" href="{{route("home")}}">
            {{ "Home" }}
        </a>
    </div>
    <div class="row mb-3 border-bottom boder-secondary">
        <div class="col-5 text-left">Order No.</div>
        <div class="col-7 text-right">{{$order->id}}</div>
    </div>
    <div class="row mb-3 border-bottom boder-secondary">
        <div class="col-5 text-left">Product Name</div>
        <div class="col-7 text-right">{{$order->product_detail->product_code}} - {{$order->product_detail->product_name}}</div>
    </div>
    <div class="row mb-3 border-bottom boder-secondary">
        <div class="col-5 text-left">Quantity</div>
        <div class="col-7 text-right">{{$order->quantity}}</div>
    </div>
    <div class="row mb-3 border-bottom boder-secondary">
        <div class="col-5 text-left">Total</div>
        <div class="col-7 text-right">{{$order->formatted_total}}</div>
    </div>
</div>
@endsection
