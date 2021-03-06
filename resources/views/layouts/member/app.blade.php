<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>@yield('title') </title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    @stack('css')
</head>
<body>
    @include('layouts.member.partial.header')
    @include('layouts.member.partial.sidebar')
    @yield('content') 
    @include('layouts.member.partial.footer')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- partial -->
    <script  src="{{ asset('js/script.js') }}"></script>
    <script  src="{{ asset('js/myjs.js') }}"></script>
    @stack('script')
</body>
</html>