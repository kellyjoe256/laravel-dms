
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li {!! set_active(route('index', [], false)) !!}>
                <a href="{{ route('index', [], false) }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="{!! set_multilevel_active(['documents', 'document_categories']) !!}treeview">
                <a href="#">
                    <i class="fa fa-file-archive-o"></i><span> Documents</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{!! set_multilevel_active(['documents',]) !!}treeview">
                        <a href="#">
                            <i class="fa fa-circle-o"></i> All Documents
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {!! set_active('documents', 'edit,delete, view_files') !!}>
                                <a href="{{ route('documents', [], false) }}">
                                    <i class="fa fa-circle-o"></i> Manage Documents
                                </a>
                            </li>
                            <li {!! set_active('documents/add') !!}>
                                <a href="{{ route('documents.add', [], false) }}">
                                    <i class="fa fa-circle-o"></i> Add Document
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if (is_admin())
                    <li class="{!! set_multilevel_active(['document_categories',]) !!}treeview"> 
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Document Categories
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li {!! set_active('document_categories', 'edit, delete') !!}>
                                <a href="{{ route('doc_categories', [], false) }}">
                                    <i class="fa fa-circle-o"></i> Manage Categories
                                </a>
                            </li>
                            <li {!! set_active('document_categories/add') !!}>
                                <a href="{{ route('doc_categories.add', [], false) }}">
                                    <i class="fa fa-circle-o"></i> 
                                    Add Category
                                </a>
                            </li>
                        </ul>
                    </li> 
                    @endif
                    
                </ul>
            </li>

            @if (is_admin())
            <li class="{!! set_multilevel_active(['branches']) !!}treeview">
                <a href="#">
                    <i class="fa fa-home"></i><span> Branches</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li {!! set_active('branches', 'edit,delete,view_departments,add_departments') !!}>
                        <a href="{{ route('branches', [], false) }}">
                            <i class="fa fa-circle-o"></i> Manage Branches
                        </a>
                    </li>
                    <li {!! set_active('branches/add') !!}>
                        <a href="{{ route('branches.add', [], false) }}">
                            <i class="fa fa-circle-o"></i> Add Branch
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if (is_admin())
            <li class="{!! set_multilevel_active(['departments']) !!}treeview">
                <a href="#">
                    <i class="fa fa-hospital-o"></i><span> Departments</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li {!! set_active('departments', 'edit,delete,view_branches,add_branches') !!}>
                        <a href="{{ route('departments', [], false) }}">
                            <i class="fa fa-circle-o"></i> Manage Departments
                        </a>
                    </li>
                    <li {!! set_active('departments/add') !!}>
                        <a href="{{ route('departments.add', [], false) }}">
                            <i class="fa fa-circle-o"></i> Add Department
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if (is_admin())
            <li class="{!! set_multilevel_active(['users']) !!}treeview">
                <a href="#">
                    <i class="fa fa-user-plus"></i><span> Users</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li {!! set_active('users', 'edit,delete,change_password') !!}>
                        <a href="{{ route('users', [], false) }}">
                            <i class="fa fa-circle-o"></i> Manage Users
                        </a>
                    </li>
                    <li {!! set_active('users/add') !!}>
                        <a href="{{ route('users.add', [], false) }}">
                            <i class="fa fa-circle-o"></i> Add User
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <li>
                <a href="{{ route('logout', [], false) }}">
                    <i class="fa fa-sign-out"></i>
                    <span>Sign Out</span>
                </a>
            </li> 
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
