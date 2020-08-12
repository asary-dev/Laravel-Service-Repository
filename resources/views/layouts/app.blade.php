<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="main-wrapper">
        @if (Request::segment(1) == "admin")
        <ul class="menubar">
            <li class="menubar__link {{Request::segment(2) == "product" ? "active" : null}} "><a
                    href="{{route('admin.product.index')}}">Product</a></li>
            <li class="menubar__link {{Request::segment(2) == "order" ? "active" : null}} "><a
                    href="{{route('admin.order.index')}}">Orders</a></li>
            <li class="menubar__link {{Request::segment(2) == "user" ? "active" : null}} "><a
                    href="{{route('admin.user.index')}}">Users</a></li>
        </ul>
        @endif
        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <div class="link-between">
        @if (Request::segment(1) != "admin")
        <a href="/admin"> Admin Page </a>
        @else
        <a href="/"> Storefront </a>
        @endif
    </div>
</body>

</html>