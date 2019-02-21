
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
            <li>
                <a href="/logout">
                    <i class="fa fa-sign-out"></i>
                    <span>Sign Out</span>
                </a>
            </li> 
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
