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
                @if (count($users) > 0)
                <div class="box-body table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Admin</th>
                                <th>Active</th>
                                <th>Last Active</th>
                                <th>Date Created</th>
                                <th>&nbsp;</th>
                            </tr>

                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! $user->branch_name ? $user->branch_name : '&nbsp;' !!}</td>
                                <td>{!! $user->department_name ? $user->department_name : '&nbsp;' !!}</td>
                                <td>{{ $user->is_admin ? 'Yes' : 'No' }}</td>
                                <td>{{ $user->active ? 'Yes' : 'No' }}</td>
                                <td><small>{!! $user->last_login ? $user->last_login->format('D j<\s\u\p>S</\s\u\p> M, Y @ g:i:s A') : '&nbsp;' !!}</small></td>
                                <td><small>{!! $user->created_at->format('D j<\s\u\p>S</\s\u\p> M, Y') !!}</small></td>
                                <td>
                                    <a href="{{ route('users.edit', [$user->user_id], false) }}" title="Edit User" class="text-info u">Edit</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('users.delete', [$user->user_id], false) }}" title="Delete User" class="text-danger u">Delete</a>
                                    {!! Html::nbsp(3) !!}
                                    <a href="{{ route('users.change_password', [$user->user_id], false) }}" title="Change User Password" class="text-info u">Change Password</a>
                                    {!! Html::nbsp(3) !!}
                                    @if ($user->active)
                                        <a href="{{ route('users.deactivate', [$user->user_id], false) }}" title="Deactivate Account" class="text-info u">Deactivate</a>
                                    @else
                                        <a href="{{ route('users.activate', [$user->user_id], false) }}" title="Activate Account" class="text-info u">Activate</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->appends($_GET)->links('includes/pagination') }}
                @else
                <div class="box-body">
                    <h3 class="no-content">No Users available</h3>
                </div>
                @endif
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection