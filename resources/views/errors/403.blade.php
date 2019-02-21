@extends('layouts/plain')
@section('title') Access Denied @endsection
@section('content')
    <div class="wrapper" style="height: auto;">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 625px; margin-left: 0">
            <div class="container">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <h1>403</h1>
                </div>
                <!-- Main content -->
                <div class="content">
                    <div class="error-page">
                        <h2 class="headline text-yellow"> 403</h2>
                        <div class="error-content">
                            <h3><i class="fa fa-warning text-yellow"></i> Oops! Access denied.</h3>
                            <p>
                                You don't have the neccessary permissions to access the given resource. Ask your administrator for permission to do so. Meanwhile you <a href="{{ route('index', [], false) }}">return to dashboard</a>.
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
