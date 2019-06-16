<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

    <?php
    if (isset($seo_new)) $seo = $seo_new;
    ?>
    <title>{{ isset($seo) && !empty($seo->title) ? $seo->title : config('app.name') }}</title>

    <meta name="apple-mobile-web-app-title" content="{{ $seo->title ?? config('app.name') }}">
    <meta name="description" content="{{ $seo->description ?? '' }}">
    <meta name="keywords" content="{{ $seo->keywords ?? '' }}">
    <meta name="author" content="Emotions Group">
    <meta name="robots" content="index, follow">

    <meta property="og:title" content="{{ $seo->title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $seo->description ?? '' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
</head>
<body>

@include('app.header')

<main>
    <div class="main">
        @yield('app_content')
    </div>
</main>

@include('app.footer')

{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXrKE5h-QaBB_NDgmMqTzEDaAj4NzM9Wk" type="text/javascript"></script>--}}
<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
