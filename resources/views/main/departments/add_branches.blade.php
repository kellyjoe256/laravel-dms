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

                        @if (count($branches))
                        {!! Form::open(['action' => ['DepartmentsController@storeBranches', $department->department_id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('branches') ? ' has-error' : '' }}">
                                    <p><strong>Branches</strong></p>
                                    @foreach ($branches as $branch)
                                        <label class="checkbox-inline">
                                            {{ Form::checkbox('branches[]', $branch->branch_id, in_array($branch->branch_id, $department_branches)) }} 
                                            {{ $branch->branch_name }}
                                        </label>
                                    @endforeach
                                    @if ($errors->has('branches'))
                                        <span class="help-block">
                                            {{ $errors->first('branches') }}
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
                            <h3 class="no-content">No Branches available for adding.</h3>
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
