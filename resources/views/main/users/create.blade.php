@php($select2 = true)
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
                            <a href="{{ route('users', [], false) }}" class="btn btn-default">Users</a>
                        </div>
                        
                        {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    {{ Form::label('username', 'Username*') }}
                                    {{ Form::text('username', '', ['class' => 'form-control', 'placeholder' => 'Username', 'required' => true]) }}
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        {{ $errors->first('username') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {{ Form::label('email', 'Email*') }}
                                    {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email', 'required' => true]) }}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
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
                                <div class="form-group{{ $errors->has('branch') ? ' has-error' : '' }}">
                                    {{ Form::label('branch', 'Branch') }}
                                    {{ Form::select('branch', $branches, null, ['placeholder' => 'Select Branch', 'class' => 'form-control select2', 'id' => 'branch',]) }}
                                    @if ($errors->has('branch'))
                                    <span class="help-block">
                                    {{ $errors->first('branch') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                                    {{ Form::label('department', 'Department') }}
                                    {{ Form::select('department', [], null, ['placeholder' => 'Select Branch First', 'class' => 'form-control select2', 'id' => 'department',]) }}
                                    @if ($errors->has('department'))
                                    <span class="help-block">
                                    {{ $errors->first('department') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('is_admin') ? ' has-error' : '' }}">
                                    <label class="checkbox-inline">
                                        {{ Form::checkbox('is_admin', 'yes') }} Admin 
                                    </label>
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
@section('scripts')
    @parent
    <script src="{{ asset('assets/vendor/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2();
        $('#branch').on('change', function(e) {
            var branch_id = parseInt($(this).val(), 10);
            if (branch_id) {
                $.ajax({
                    method: "GET",
                    url: '/branches/' + branch_id + '/get_departments',
                    success: function(data) {
                        var values = data;
                        var options = '';
                        for (var i = 0; i < values.length; i += 1) {
                            options += '<option value="' + values[i]['id'];
                            options += '">' + values[i]['department'];
                            options += '</option>';
                        }
                        $('#department').html(options);
                    }
                });
            } else {
                $('#department').html('<option value="">Select Branch First</option>');
            }
        });
    </script>
@stop