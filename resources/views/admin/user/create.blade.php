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
            <h4>Create a new User</h4>
            <a class="btn btn-secondary" href="{{route("admin.user.index")}}">< Back</a>
        </div>
        <form method="POST" action="{{ route('admin.user.store') }}">
            @csrf
            <div class="my-3"> 
                <label for="name" class="text-md-right">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
            
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="my-3"> 
                <label for="email" class="text-md-right">E-mail</label>
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
            
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            
            <div class="my-3"> 
                <label for="password" class="text-md-right">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" autofocus>
            
                @error('password')
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
@endsection
