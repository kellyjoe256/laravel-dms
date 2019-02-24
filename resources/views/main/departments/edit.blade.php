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
                            <a href="{{ route('departments', [], false) }}" class="btn btn-default">Departments</a>
                        </div>
                        
                        {!! Form::open(['action' => ['DepartmentsController@update', $department->department_id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">
                                    {{ Form::label('department_name', 'Department Name*') }}
                                    {{ Form::text('department_name', $department->department_name, ['class' => 'form-control', 'placeholder' => 'Department Name', 'required' => true]) }}
                                    @if ($errors->has('department_name'))
                                        <span class="help-block">
                                        {{ $errors->first('department_name') }}
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
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
