<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Admin Panel</title>
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.png">
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
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>
<body class="theme-blue">

    <div class="overlay"></div>

    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="bars"></a>
                <a class="navbar-brand" href="/admin">{{ config('app.name') }} - Admin Panel</a>
            </div>
        </div>
    </nav>

    <section>
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                @if (Auth::check())
                    <div class="image">
                        <img src="{{asset('adminbsb/images/user.png')}}" width="48" height="48" alt="User" />
                    </div>
                    <div class="info-container">
                        <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
                        <div class="email">{{ Auth::user()->email }}</div>
                        <div class="btn-group user-helper-dropdown">
                            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{ url('/admin/profile') }}"><i class="material-icons">person</i>Профайл</a></li>
                                <li role="seperator" class="divider"></li>
                                <li><a href="{{ url('/logout') }}" class="button-logout"><i class="material-icons">input</i>Выйти</a></li>
                            </ul>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                @endif
            </div>
            <!-- #User Info -->
            <!-- Menu -->
                @include('admin.admin-menu')
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; {{ date('Y') }} <a href="http://emotionsgroup.kz" target="_blank">Emotions Group</a>
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(Session::has('message'))
                <div class="alert bg-blue alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        {!! implode('', $errors->all('<li>:message</li>')) !!}
                    </ul>
                </div>
            @endif

            @yield('admin_content')

        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="{{ asset('adminbsb/js/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('adminbsb/js/jquery-ui.min.js') }}"></script>
    <!-- CKEditor -->
    <script src="{{ asset('adminbsb/ckeditor/ckeditor.js') }}"></script>
    <!-- Bootstrap Core Js -->
    <script src="{{ asset('adminbsb/bootstrap/js/bootstrap.js') }}"></script>
    <!-- Select Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- Bootstrap Colorpicker Js -->
    <script src="{{ asset('adminbsb/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
    <!-- Jquery Spinner Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-spinner/js/jquery.spinner.js') }}"></script>
    <!-- noUISlider Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/nouislider/nouislider.js') }}"></script>
    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/node-waves/waves.js' )}}"></script>
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('adminbsb/js/admin.js') }}"></script>
    <script src="{{ mix('js/admin.js') }}"></script>

</body>
</html>
