@extends('layouts.app')

@section('content')
<div class="admin user-index">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
    </div>
    @endif
    <div class="user-index__header page-header">
        <h4>Product List</h4>
        <a class="btn btn-success" href="{{route("admin.product.create")}}">+ Add</a>
    </div>
    <div class="user-index__list tableyjr">
        <table class="table border border-dark data-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
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
    $(() => {
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.product.index') }}",

          columns: [
              {data: 'product_code', name: 'code'},
              {data: 'product_name', name: 'name'},
              {data: 'product_formatted_price', name: 'price'},
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