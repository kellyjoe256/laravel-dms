@extends('layouts/base')
@section('title') {{ $title }} @endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{ $title }} for <em>{{ $user->username }}</em></h1>
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
                            <a href="{{ route('users', [], false) }}" class="btn btn-default">Users</a>
                        </div>
                        
                        {!! Form::open(['action' => ['UsersController@storePassword', $user->user_id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    {{ Form::label('password', 'Password*') }}
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => true]) }}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    {{ Form::label('password_confirmation', 'Confirm Password*') }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password', 'required' => true]) }}
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        {{ $errors->first('password_confirmation') }}
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
