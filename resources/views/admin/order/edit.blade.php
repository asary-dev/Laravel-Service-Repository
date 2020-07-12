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
            <h4>Edit Order</h4>
            <a class="btn btn-secondary" href="{{route("admin.order.index")}}">
                {{ "< Back" }}
            </a>
        </div>
        <form method="POST" action="{{ route('admin.order.store') }}">
            @csrf

            <div class="my-3">
                <label for="quantity" class="text-md-right">Product</label>
                <select required class="product_id form-control" name="product_id"></select>
                <input type="hidden" id="price" />
                @error('product_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="my-3">
                <label for="quantity" class="text-md-right">Quantity</label>
                <div class="input-group">
                    <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror"
                        name="quantity" value="{{ old('quantity') ?? $order->quantity}}" autocomplete="quantity"
                        autofocus>

                    <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon1">PCS</span>
                    </div>
                </div>

                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="my-3">
                <label for="total" class="text-md-right">Total</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">RP.</span>
                    </div>
                    <input id="total" readonly type="number" class="form-control @error('total') is-invalid @enderror"
                        name="total" value="{{ old('total') ?? $order->total}}" autocomplete="total" autofocus>
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
                    name="customer_name" value="{{ old('customer_name') ?? $order->customer_name}}"
                    autocomplete="customer_name" autofocus>

                @error('customer_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="my-3">
                <label for="customer_phone" class="text-md-right">Phone</label>
                <input id="customer_phone" type="text"
                    class="form-control @error('customer_phone') is-invalid @enderror" name="customer_phone"
                    value="{{ old('customer_phone') ?? $order->customer_phone}} " autocomplete="customer_phone"
                    autofocus>

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
                    autocomplete="customer_address" rows="5"
                    autofocus> {{ old('customer_address') ?? $order->customer_address}}</textarea>

                @error('customer_address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="my-3">
                <button type="submit" class="btn btn-primary d-block w-100">
                    Submit
                </button>
            </div>
            <form>

    </div>
</div>
<script>
    // fetch data for product select
    $('.product_id').select2({
        placeholder: 'Select product',
        ajax: {
            url: '/admin/order/select_products',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: `${item.product_code} - ${item.product_name} - ${item.product_formatted_price}`,
                            id: item.id,
                            price:item.product_price
                        }
                    })
                };
            },
            cache: true
        },
        minimumResultsForSearch: -1,
    });

    // Update the prices
    $('.product_id').on('select2:select', function (e) {
        var data = e.params.data;
        document.getElementById("price").value = data.price
        updateTotal(parseInt($("#quantity")[0].value));
    });

    $('#quantity').on('input',e=>updateTotal(e.target.value))

    function updateTotal(quantity){
        var itemPrice = parseInt($("#price")[0].value)
        console.log(itemPrice,quantity)
        document.getElementById("total").value = itemPrice*quantity
    }   
</script>
@endsection