<?php 
    $select2 = true;
    $datepicker = true;  
?>
@extends('layouts/base')
@section('title'){{ $title }}@endsection
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
            <!-- Box primary-->
            <div class="box box-primary">
                <div class="box-header with-border">
                    {!! Form::open(['id' => 'search_form', 'method' => 'GET', 'autocomplete' => 'off', 'class' => 'form-inline']) !!}
                        <div class="form-group">
                            {{ Form::text('title_desc', '', ['class' => 'form-control', 'placeholder' => 'Title or Description...',]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::text('start_date', '', ['class' => 'form-control date', 'placeholder' => 'Start Date...',]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::text('end_date', '', ['class' => 'form-control date', 'placeholder' => 'End Date...',]) }}
                        </div>
                        @if (is_admin())
                        <div class="form-group">
                            {{ Form::select('branch', $branches, null, ['placeholder' => 'Select Branch', 'class' => 'form-control select2', 'id' => 'branch',]) }}
                        </div>
                        <div class="form-group">
                            {{ Form::select('department', [], null, ['placeholder' => 'Select Branch First', 'class' => 'form-control select2', 'id' => 'department',]) }}
                        </div>
                        @endif
                        <div class="form-group submit">
                            {{ Form::submit('Search', 
                                ['class' => 'btn btn-primary']) 
                            }}
                        </div>
                    {!! Form::close() !!}
                </div>
                @if (count($documents) > 0)
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Creation Date</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Uploaded By</th>
                                <th>Stored On</th>
                                <th>&nbsp;</th>
                            </tr>

                            @foreach ($documents as $document)
                            <tr>
                                <td>{{ $document->title }}</td>
                                <td>{{ get_string_brief($document->description) }}</td>
                                <td>{{ $document->category_name }}</td>
                                <td><small>{!! $document->creation_date ? $document->creation_date->format('D j<\s\u\p>S</\s\u\p> M, Y') : '&nbsp;' !!}</small></td>
                                <td>{!! $document->branch_name ? $document->branch_name : '&nbsp;' !!}</td>
                                <td>{!! $document->department_name ? $document->department_name : '&nbsp;' !!}</td>
                                <td>{{ $document->username }}</td>
                                <td><small>{!! $document->created_at->format('D j<\s\u\p>S</\s\u\p> M, Y') !!}</small></td>
                                <td>
                                    <a href="{{ route('documents.edit', [$document->document_id], false) }}" title="Edit Document" class="text-info u">Edit</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('documents.delete', [$document->document_id], false) }}" title="Delete Document" class="text-danger u">Delete</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('documents.view_files', [$document->document_id], false) }}" title="View Document Files" class="text-info u">View Files</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $documents->appends($_GET)->links('includes/pagination') }}
                @else
                <div class="box-body">
                    <h3 class="no-content">No Documents available</h3>
                </div>
                @endif
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('scripts')
    @parent
        <?php if (is_admin()) : ?>
        <script src="{{ asset('assets/vendor/select2/dist/js/select2.full.min.js') }}"></script>
        <?php endif; ?>
        <script src="{{ asset('assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
        <script>
            $('.date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                endDate: "+0d",
            });

            <?php if (is_admin()) : ?>
                //Initialize Select2 Elements
                $('.select2').select2();
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
                                        echo isset($_GET['branch']) 
                                            ? (int)$_GET['branch'] : -1; 
                                    ?> && values[i]['id'] === <?php 
                                        echo isset($_GET['department']) 
                                            ? (int)$_GET['department'] : -1; 
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
                console.log(current_branch);
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
