@extends('layouts/base')
@section('title'){{ strip_tags($title) }}@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{!! $title !!}</h1>
            @include('includes/breadcrumbs')
        </section>
        <!-- Main content -->
        <section class="content">
            @include('includes/flash')
            <!-- Box primary-->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="clearfix">
                        <div class="pull-left">
                            <a href="{{ route('documents', [], false) }}" class="btn btn-default">Documents</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('documents.upload_files', [$document->document_id], false) }}" class="btn btn-primary">Add New Files</a>
                        </div>
                    </div>
                </div>
                @if (count($files) > 0)
                <div class="box-body table-responsive">
                    <p>{{ $document->description }}</p>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Filename</th>
                                <th>&nbsp;</th>
                            </tr>

                            @foreach ($files as $key => $value)
                            <tr>
                                <td><a href="{{ route('document_files.preview', [$key], false) }}" target="_blank" style="text-decoration: underline;" title="Preview File">{{ $value }}</a></td>
                                <td>
                                    <a href="{{ route('document_files.delete_file', [$key, 'document' => $document->document_id], false) }}" class="text-danger u" title="Delete File">Delete File</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="box-body">
                    <h3 class="no-content">No Files available</h3>
                </div>
                @endif
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
