<!DOCTYPE html>
<html lang="en">
    <head>

        @section('head')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title')</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/Ionicons/css/ionicons.min.css') }}">

        @if (isset($select2))
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}">
        @endif

        @if (isset($datepicker))
        <!-- Datepicker -->
        <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        @endif

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('assets/css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('assets/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        @show

    </head>
    <body class="{{ isset($body_class) ? $body_class : 'hold-transition skin-blue sidebar-mini' }}">
        <!-- Site wrapper -->
        <div class="wrapper">
            @include('layouts/header')
            <!-- =============================================== -->
            @include('layouts/nav')
            <!-- =============================================== -->
            @yield('content')
            @include('layouts/footer')
        </div>
        <!-- ./wrapper -->

        @section('scripts')
        <!-- jQuery 3 -->
        <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- SlimScroll -->
        <script src="{{ asset('assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('assets/vendor/fastclick/lib/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('.sidebar-menu').tree()
            })
        </script>
        @show

    </body>
</html>
