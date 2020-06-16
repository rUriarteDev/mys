<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.head')
</head>

<body>
    @include('layout.partials.header')
    <br>
    @yield('content')
    @include('layout.partials.footer-scripts')
    @yield('after-scripts')
</body>

</html>