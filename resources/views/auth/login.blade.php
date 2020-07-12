@extends('layouts.app')

@section('content')
<div class="login-page mx-1">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h1>Login Admin Panel</h1>
        <div class="my-3">
            <label for="email" class="text-md-right">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-3">
            <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password">


            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="my-3">
            <button type="submit" class="btn btn-primary d-block w-100">
                {{ __('Login') }}
            </button>
        </div>
    </form>
</div>
@endsection