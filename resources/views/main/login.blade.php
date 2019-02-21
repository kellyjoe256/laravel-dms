@extends('layouts/plain')
@section('title') {{ $title }} @endsection
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <b>D</b>MS
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @include('includes/flash')
            {!! Form::open(['action' => 'SessionsController@login', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
                    {{ Form::text('username', '', ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true, 'autofocus' => true,]) }}
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('username'))
                        <span class="help-block">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::password('password', [ 'class' => 'form-control', 'placeholder' => 'Password', 'required' => true,]) }}
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8">&nbsp;</div>
                    <!-- /.col -->
                    <div class="col-xs-4">{{ Form::submit('Sign In', ['class' => 'btn btn-primary btn-block btn-flat']) }}</div>
                    <!-- /.col -->
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection
