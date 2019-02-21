@extends('layouts/plain')
@section('title') Page Not Found @endsection
@section('content')
    <div class="wrapper" style="height: auto;">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 625px; margin-left: 0">
            <div class="container">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <h1>404</h1>
                </div>
                <!-- Main content -->
                <div class="content">
                    <div class="error-page">
                        <h2 class="headline text-yellow"> 404</h2>
                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                            <p>
                                We could not find the page you were looking for. Meanwhile, you may <a href="{{ route('index', [], false) }}">return to dashboard</a>.
                            </p>
                        </div>
                        <!-- /.error-content -->
                    </div>
                    <!-- /.error-page -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection
