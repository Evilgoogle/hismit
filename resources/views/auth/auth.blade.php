<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="{{ asset('adminbsb/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/css/materialize.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/css/material-icon.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/jquery-spinner/css/bootstrap-spinner.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/nouislider/nouislider.min.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet">
    <link href="{{ asset('adminbsb/css/all-themes.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body class="login-page">

    @yield('auth_content')

    <!-- Jquery Core Js -->
    <script src="{{ asset('adminbsb/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('adminbsb/js/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{ asset('adminbsb/bootstrap/js/bootstrap.js') }}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/node-waves/waves.js' )}}"></script>

    <script src="{{ asset('adminbsb/js/admin.js') }}"></script>

    <script src="{{ asset('js/admin.js') }}"></script>

</body>
</html>