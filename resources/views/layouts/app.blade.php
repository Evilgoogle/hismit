<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.png"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>

    <?php
      if (isset($seo_new)) $seo = $seo_new;
    ?>
    <title>{{ isset($seo->title) ? ($seo->title) : config('app.name') }}</title>
    <meta name="description" content="{{ $seo->description ?? '' }}">
    <meta property="og:title" content="{{ isset($seo->title) ? $seo->title : config('app.name') }}">
    <meta property="og:description" content="{{ $seo->description ?? '' }}">
    <meta property="og:url" content="{{ url()->current() }}/" />
    <meta property="og:image" content="/images/logo.jpg">
    <meta property="og:image:url" content="{{ $seo->image ?? '' }}" />
    <meta property="og:image:width" content="{{ $seo->image_width ?? '' }}" />
    <meta property="og:image:height" content="{{ $seo->image_height ?? '' }}" />
    <meta property="og:image:type" content="{{ $seo->image_mime ?? '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />

    <link rel="canonical" href="{{ strtolower(url()->current()) }}/">
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
