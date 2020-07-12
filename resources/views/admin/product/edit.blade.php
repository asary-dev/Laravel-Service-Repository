@extends('layouts.app')

@section('content')
<div class="admin">
    <div class="user-create">
        @if (session('status'))
        <div class="alert alert-{{ session('status') }}">
            {{ session('message') }}
        </div>
        @endif
        <div class="user-create__header page-header">
            <h4>Edit product : {{$product->product_name}}</h4>
            <a class="btn btn-secondary" href="{{route("admin.product.index")}}">
                < Back</a> </div> <form method="POST" action="{{ route('admin.product.update',$product->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method("put")
                    <div class="my-3">
                        <img src="{{$product->product_image}}" class="form-image my-3" />
                        <div class="form-group">
                            <label for="image">Choose Image</label>
                            <input id="image" class=" @error('product_image') is-invalid @enderror" type="file"
                                name="product_image">

                            @error('product_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="my-3">
                        <label for="product_code" class="text-md-right">{{ __('Code') }}</label>
                        <input id="product_code" type="text"
                            class="form-control @error('product_code') is-invalid @enderror" name="product_code"
                            autocomplete="product_code" autofocus
                            value="{{ old('product_code') ?? $product->product_code}}">

                        @error('product_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="my-3">

                        <label for="product_name" class="text-md-right">{{ __('Name') }}</label>
                        <input id="product_name" type="text"
                            class="form-control @error('product_name') is-invalid @enderror" name="product_name"
                            autocomplete="product_name" autofocus
                            value="{{ old('product_name') ?? $product->product_name}}">

                        @error('product_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="my-3">
                        <label for="product_price" class="text-md-right">Price</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                            </div>
                            <input id="product_price" type="text"
                                class="form-control @error('product_price') is-invalid @enderror" name="product_price"
                                autocomplete="product_price" autofocus
                                value="{{old('product_price') ??  $product->product_price}}">
                        </div>

                        @error('product_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="my-3">
                        <input type="submit" class="btn btn-primary d-block w-100" value="Update">
                    </div>
                    <form>


        </div>
    </div>
    @endsection