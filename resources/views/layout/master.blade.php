<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.head')
    <link rel="stylesheet" href="{{ asset('build/assets/css/style.css') }}">
</head>

<body>

        @include('layout.header')

    <div class="d-flex">
        @include('layout.sidebar')

        <div class="container-fluid p-4 main-content">
            @yield('content')
        </div>
    </div>

    @include('layout.footer')

    @include('layout.scripts')

</body>
</html>
