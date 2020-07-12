@extends('layouts.app')

@section('content')
<div class="admin user-index">
    @if (session('status'))
    <div class="alert alert-{{ session('status') }}">
        {{ session('message') }}
    </div>
    @endif
    <div class="user-index__header page-header">
        <h4>User List</h4>
        <a class="btn btn-success" href="{{route("admin.user.create")}}">+ Add</a>
    </div>
    <div class="user-index__list tableyjr">
        <table class="table border border-dark data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
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
          ajax: "{{ route('admin.user.index') }}",

          columns: [
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      
    });

    // User delete
    function deleteUser(id){
        document.getElementById(`delete_form`).action = `/admin/user/${id}`;
        document.getElementById(`delete_form`).submit()
    }
</script>
@endsection