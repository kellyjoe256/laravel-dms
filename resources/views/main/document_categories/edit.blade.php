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
                            <a href="{{ route('doc_categories', [], false) }}" class="btn btn-default">Document Categories</a>
                        </div>
                        
                        {!! Form::open(['action' => ['DocumentCategoriesController@update', $category->category_id], 'method' => 'POST', 'autocomplete' => 'off']) !!}
                            <div class="box-body">
                                <div class="form-group{{ $errors->has('category_name') ? ' has-error' : '' }}">
                                    {{ Form::label('category_name', 'Category Name*') }}
                                    {{ Form::text('category_name', $category->category_name, ['class' => 'form-control', 'placeholder' => 'Category Name', 'required' => true]) }}
                                    @if ($errors->has('category_name'))
                                        <span class="help-block">
                                        {{ $errors->first('category_name') }}
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
