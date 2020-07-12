@extends('layouts.app')

@section('content')
<div class="product-page">
    <form method="POST" action="{{ route('product.purchase',$product->id) }}">
        @csrf
        <div class="page-header mb-0 pb-0">
            <h4>Order Information</h4>
            <a class="btn btn-link m-0 p-0" href="{{route("home")}}">
                {{ "< Back" }}
            </a>
        </div>
        <h5>{{$product->product_name}}</h5>
        <h6>{{$product->product_formatted_price}}</h6>
        <h6>Qty
            <span class="my-3">
                <input id="quantity" type="number"
                    class=" form-control @error('quantity') is-invalid @enderror qty-input " name="quantity"
                    value="{{ old('quantity') }}" autocomplete="quantity" autofocus>

                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </span> Pcs
        </h6>

        <input hidden type="text" name="price" id="price" value="{{$product->product_price}}" />
        <input hidden type="text" name="product_id" id="product_id" value="{{$product->id}}" />

        <div class="my-3">
            <label for="total" class="text-md-right">Total</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">RP.</span>
                </div>
                <input id="total" readonly type="number" class="form-control @error('total') is-invalid @enderror"
                    name="total" value="{{ old('total') }}" autocomplete="total" autofocus>
            </div>

            @error('total')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-3">
            <label for="customer_name" class="text-md-right">Name</label>
            <input id="customer_name" type="text" class="form-control @error('customer_name') is-invalid @enderror"
                name="customer_name" value="{{ old('customer_name') }}" autocomplete="customer_name" autofocus>

            @error('customer_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-3">
            <label for="customer_phone" class="text-md-right">Phone</label>
            <input id="customer_phone" type="text" class="form-control @error('customer_phone') is-invalid @enderror"
                name="customer_phone" value="{{ old('customer_phone') }}" autocomplete="customer_phone" autofocus>

            @error('customer_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-3">
            <label for="customer_address" class="text-md-right">Address</label>
            <textarea id="customer_address" type="text"
                class="form-control @error('customer_address') is-invalid @enderror" name="customer_address"
                value="{{ old('customer_address') }}" autocomplete="customer_address" rows="5" autofocus></textarea>

            @error('customer_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-3">
            <button type="submit" class="btn btn-primary d-block w-100">
                Purchase
            </button>
        </div>
    </form>
</div>
<script>
    // $('.product_id').on('select2:select', function (e) {
    //     var data = e.params.data;
    //     document.getElementById("price").value = data.price
    //     updateTotal(parseInt($("#quantity")[0].value));
    // });

    $('#quantity').on('input',e=>updateTotal(e.target.value))

    function updateTotal(quantity){
        var itemPrice = parseInt($("#price")[0].value)
        console.log(itemPrice,quantity)
        document.getElementById("total").value = itemPrice*quantity
    }
</script>
@endsection