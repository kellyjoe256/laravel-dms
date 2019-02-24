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
                        
                        {!! Form::open(['action' => 'BranchesController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('branch_name') ? ' has-error' : '' }}">
                                    {{ Form::label('branch_name', 'Branch Name*') }}
                                    {{ Form::text('branch_name', '', ['class' => 'form-control', 'placeholder' => 'Branch Name', 'required' => true]) }}
                                    @if ($errors->has('branch_name'))
                                        <span class="help-block">
                                            {{ $errors->first('branch_name') }}
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
