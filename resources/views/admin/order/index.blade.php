@extends('layouts.app')

@section('content')
<div class="admin user-index">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
    </div>
    @endif
    <div class="user-index__header page-header">
        <h4>Order List</h4>
        <a class="btn btn-success" href="{{route("admin.order.create")}}">+ Add</a>
    </div>
    <div class="row mx-1 justify-content-between align-center">
        <input onchange=";triggerChange();" class="col-12 col-sm-6 form-control" type="date" id="from" />
        <input onchange=";triggerChange();" class="col-12 col-sm-6 form-control" type="date" id="to" />
    </div>

    <div class="user-index__list tableyjr">
        <table class="table border border-dark data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

{{-- For Deleting USer --}}
<form method="POST" id="delete_form" action="" class="d-none">
    @csrf
    @method("delete")
</form>

<script type="text/javascript">
    // initialize datatable
    var from ="" 
    var to = ""
    var table;

    function triggerChange(){
      from = document.getElementById("from").value;
      to = document.getElementById("to").value;
      
      table.ajax.url("{{ route('admin.order.index') }}" + `?from=${from}&to=${to}`).load()
    };

    $(() =>{
        console.log(document.getElementById("from").value)
        table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.order.index') }}" + `?from=${from}&to=${to}`,

            columns: [
                {data: 'id', name: 'pad_id'},
                {data: 'product_detail', name: 'product_detail'},
                {data: 'formatted_total', name: 'total'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });

    // User delete
    function deleteProduct(id){
        document.getElementById(`delete_form`).action = `/admin/product/${id}`;
        document.getElementById(`delete_form`).submit()
    }
</script>
@endsection