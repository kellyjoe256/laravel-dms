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
                            <a href="{{ route('documents.view_files', [$document->document_id], false) }}" class="btn btn-default">Document Files</a>
                        </div>
                        {!! Form::open(['action' => ['DocumentsController@storeFiles', $document->document_id], 'method' => 'POST', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data',]) !!}
                            <div class="box-body">
                                <div class="form-group{{ (check_array_values($errors->all(), 'files') || $errors->has('files')) ? ' has-error' : '' }}">
                                    {{ Form::label('files', 'Files*') }}
                                    {{ Form::file('files[]', ['required' => true, 'multiple' => true,]) }}
                                    <span class="help-block">Maximum size: 5MB</span>
                                    <?php 
                                        foreach ($errors->all() as $error) {
                                            if (stripos($error, 'files') === false) { continue; }

                                            if (strpos($error, 'failed to upload') !== false) {
                                                echo '<span class="help-block">One or more files exceeded the maximum size of 5MB</span>';
                                            } else {
                                                echo '<span class="help-block">'. $error . '</span>';
                                            }
                                        }  
                                    ?>
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