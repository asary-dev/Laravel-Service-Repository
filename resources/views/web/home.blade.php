@extends('layouts.app')

@section('content')
<div class="home">
    <div class="row justify-content-center">
        @foreach ($products as $item)
        <div class="item-container col-sm-6 col-12 ">
            <div class="item border border-secondary">
                <div class="item__info">
                    <img src="{{$item->product_image}}" class="item__image" />
                    <h5 class="item__title my-2">{{$item->product_code}} - {{$item->product_name}}</h5>
                    <div class="item__price">{{$item->product_formatted_price}}</div>
                </div>
                <div class="item__footer">
                    <a href="/product/{{$item->id}}"
                        class="mt-auto h-100 btn btn-primary text-center w-100 d-block">Purchase</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
