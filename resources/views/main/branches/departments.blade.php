@extends('layouts/base')
@section('title'){{ $title }}@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{ $title }}</h1>
            @include('includes/breadcrumbs')
        </section>
        <!-- Main content -->
        <section class="content">
            @include('includes/flash')
            <!-- Box primary-->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a href="{{ route('branches', [], false) }}" class="btn btn-default">Branches</a>
                </div>
                <div class="box-body">
                    @if (count($departments) > 0)
                        <ul class="list-inline">
                            @foreach ($departments as $department)
                                <li>&raquo; {{ $department }}</li> 
                            @endforeach
                        </ul>
                    @else
                        <h3 class="no-content">No Departments available for the {{ $branch->branch_name }} Branch</h3>
                    @endif
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection