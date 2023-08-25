<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal/otp-code.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/datatables/dataTables.bootstrap5.min.css') }}">

</head>
<body class="bg-body-tertiary">
@include('reader.app.navbar')
@include('reader.app.alert')
@yield('content')
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.easing.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/color-modes.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/modal/modal.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/modal/otp-code.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/modal/auth.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>


<script type="text/babel" src="{{ asset('js/algolia/algolia-search.jsx') }}"></script>
</body>
</html>

