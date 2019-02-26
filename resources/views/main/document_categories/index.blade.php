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
                    <h3 class="box-title">{{ $title }}</h3>
                </div>
                @if (count($categories) > 0)
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Category Name</th>
                                <th>&nbsp;</th>
                            </tr>

                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    <a href="{{ route('doc_categories.edit', [$category->category_id], false) }}" title="Edit Category" class="text-info u">Edit</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('doc_categories.delete', [$category->category_id], false) }}" title="Delete Category" class="text-danger u">Delete</a>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $categories->appends($_GET)->links('includes/pagination') }}
                @else
                <div class="box-body">
                    <h3 class="no-content">No Categories available</h3>
                </div>
                @endif
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection