@extends('layouts/base')
@section('title'){{ $title }}@endsection
@section('content')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Dashboard
                    <small>General Statistics</small></h1>
                @include('includes/breadcrumbs')
            </section>
            <!-- Main content -->
            <section class="content">
                @include('includes/flash')
                <div class="row">
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>{{ $total_number_of_documents }}</h3>
                                <p>
                                    @if ($total_number_of_documents == 1)
                                        Document
                                    @else
                                        Documents
                                    @endif
                                </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-archive"></i>
                            </div>
                            <a href="{{ route('documents', [], false) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>{{ $total_number_of_users }}</h3>
                                <p>
                                    @if ($total_number_of_users == 1)
                                        User
                                    @else
                                        Users
                                    @endif
                                </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('users', [], false) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{ $total_number_of_branches }}</h3>
                                <p>
                                    @if ($total_number_of_branches == 1)
                                        Branch
                                    @else
                                        Branches
                                    @endif
                                </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-home"></i>
                            </div>
                            <a href="{{ route('branches', [], false) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                            <h3>{{ $total_number_of_departments }}</h3>
                                <p>
                                    @if ($total_number_of_departments == 1)
                                        Department
                                    @else
                                        Departments
                                    @endif
                                </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-home"></i>
                            </div>
                            <a href="{{ route('departments', [], false) }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
@endsection