<?php 
    $select2 = true;
    $datepicker = true;  
?>
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
                            <a href="{{ route('documents', [], false) }}" class="btn btn-default">Documents</a>
                        </div>
                        {!! Form::open(['action' => ['DocumentsController@update', $document->document_id], 'method' => 'POST', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data',]) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    {{ Form::label('title', 'Title*') }}
                                    {{ Form::text('title', $document->title, ['class' => 'form-control', 'placeholder' => 'Document Title', 'required' => true]) }}
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        {{ $errors->first('title') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    {{ Form::label('category', 'Category*') }}
                                    {{ Form::select('category', $categories, $document->category_id, ['placeholder' => 'Select Category', 'class' => 'form-control select2', 'required' => true,]) }}
                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                        {{ $errors->first('category') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('creation_date') ? ' has-error' : '' }}">
                                    {{ Form::label('creation_date', 'Creation Date*') }}
                                    {{ Form::text('creation_date', $document->creation_date->format('Y-m-d'), ['class' => 'form-control date', 'placeholder' => 'Document Creation Date', 'required' => true]) }}
                                    @if ($errors->has('creation_date'))
                                        <span class="help-block">
                                        {{ $errors->first('creation_date') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    {{ Form::label('description', 'Description*') }}
                                    {{ Form::textarea('description', $document->description, ['class' => 'form-control', 'placeholder' => 'Document Description or Details', 'required' => true, 'rows' => 4]) }}
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        {{ $errors->first('description') }}
                                        </span>
                                    @endif
                                </div>
                                @if(is_admin())
                                <div class="form-group{{ $errors->has('branch') ? ' has-error' : '' }}">
                                    {{ Form::label('branch', 'Branch') }}
                                    {{ Form::select('branch', $branches, $document->branch_id, ['placeholder' => 'Select Branch', 'class' => 'form-control select2', 'id' => 'branch',]) }}
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
                                @endif
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
        <script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
        <script>
            //Initialize Select2 Elements
            $('.select2').select2();
            // Start Date
            $('.date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                endDate: "+0d",
            });

            <?php if (is_admin()) : ?>
                // Populate departments dropdown
                function getDepartments(branch_id) {
                    $.ajax({
                        method: "GET",
                        url: '/branches/' + branch_id + '/get_departments',
                        success: function(data) {
                            var values = data;
                            var options = '<option value="">Select Department</option>';
                            for (var i = 0; i < values.length; i += 1) {
                                options += '<option value="' + values[i]['id'];
                                options += '" ';
                                // If the branch selected is equal to user's branch
                                // and the one of department ids matches the user's 
                                // department then selected attribute is set
                                if (
                                    branch_id === <?php 
                                        echo (int)$document->branch_id
                                    ?>
                                    && values[i]['id'] === <?php 
                                        echo (int)$document->department_id
                                    ?>
                                ) {
                                    options += 'selected="selected"';
                                }
                                options += '>' + values[i]['department'];
                                options += '</option>';
                            }
                            $('#department').html(options);
                        }
                    });
                }

                var current_branch = parseInt($('#branch').val(), 10);
                if (current_branch) { getDepartments(current_branch); }

                $('#branch').on('change', function(e) {
                    var branch_id = parseInt($(this).val(), 10);
                    if (branch_id) {
                        getDepartments(branch_id);
                    } else {
                        $('#department').html('<option value="">Select Branch First</option>');
                    }
                });
            <?php endif; ?>
        </script>
@stop