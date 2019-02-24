@extends('layouts/base')
@section('title') {{ $title }} @endsection
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
            <div class="row">
                <div class="col-md-10">
                    <!-- Box primary-->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <a href="{{ route('branches', [], false) }}" class="btn btn-default">Branches</a>
                        </div>

                        @if (count($departments))
                        {!! Form::open(['action' => ['BranchesController@storeDepartments', $branch->branch_id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('departments') ? ' has-error' : '' }}">
                                    <p><strong>Departments</strong></p>
                                    @foreach ($departments as $department)
                                        <label class="checkbox-inline">
                                            {{ Form::checkbox('departments[]', $department->department_id, in_array($department->department_id, $branch_departments)) }} 
                                            {{ $department->department_name }}
                                        </label>
                                    @endforeach
                                    @if ($errors->has('departments'))
                                        <span class="help-block">
                                            {{ $errors->first('departments') }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-danger">* <em>required</em></span>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                {{ Form::submit($title, 
                                    ['class' => 'btn btn-primary']) 
                                }}
                            </div>
                        {!! Form::close() !!}
                        @else
                        <div class="box-body">
                            <h3 class="no-content">No Departments available for adding.</h3>
                        </div> 
                        @endif
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
