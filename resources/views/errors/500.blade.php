@extends('layouts/plain')
@section('title') Error Occurred @endsection
@section('content')
    <div class="wrapper" style="height: auto;">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 625px; margin-left: 0">
            <div class="container">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <h1>500 Error Page</h1>
                </div>
                <!-- Main content -->
                <div class="content">
                    <div class="error-page">
                        <h2 class="headline text-red"> 500</h2>
                        <div class="error-content">
                            <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
                            <p>
                                We will work on fixing that right away.. Meanwhile, you may <a href="{{ route('index', [], false) }}">return to dashboard</a>.
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
