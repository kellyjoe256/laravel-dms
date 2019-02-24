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
                @if (count($departments) > 0)
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Department Name</th>
                                <th>&nbsp;</th>
                            </tr>

                            @foreach ($departments as $department)
                            <tr>
                                <td>{{ $department->department_name }}</td>
                                <td>
                                    <a href="{{ route('departments.edit', [$department->department_id], false) }}" title="Edit Department" class="text-info u">Edit</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('departments.delete', [$department->department_id], false) }}" title="Delete Department" class="text-danger u">Delete</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('departments.branches', [$department->department_id], false) }}" title="View Branches" class="text-info u">View Branches</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('departments.add_branches', [$department->department_id], false) }}" title="Add Branches" class="text-info u">Add Branches</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $departments->appends($_GET)->links('includes/pagination') }}
                @else
                <div class="box-body">
                    <h3 class="no-content">No Departments available</h3>
                </div>
                @endif
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection