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
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                @if (count($branches) > 0)
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Branch Name</th>
                                <th>&nbsp;</th>
                            </tr>

                            @foreach ($branches as $branch)
                            <tr>
                                <td>{{ $branch->branch_name }}</td>
                                <td>
                                    <a href="{{ route('branches.edit', [$branch->branch_id], false) }}" title="Edit Branch" class="text-info u">Edit</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('branches.delete', [$branch->branch_id], false) }}" title="Delete Branch" class="text-danger u">Delete</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('branches.departments', [$branch->branch_id], false) }}" title="View Departments" class="text-info u">View Departments</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('branches.add_departments', [$branch->branch_id], false) }}" title="Add Departments" class="text-info u">Add Departments</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $branches->appends($_GET)->links('includes/pagination') }}
                @else
                <div class="box-body">
                    <h3 class="no-content">No Branches available</h3>
                </div>
                @endif
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection