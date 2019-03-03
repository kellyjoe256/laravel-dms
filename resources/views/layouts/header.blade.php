
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('index', [], false) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>D</b>MS</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>D</b>MS</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('assets/img/avatar5.png') }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ ucfirst(Auth::user()->username) }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{ asset('assets/img/avatar5.png') }}" class="img-circle" alt="User Image">
                                    <p>
                                        {{ ucfirst(Auth::user()->username) }}
                                        <small>Member since {{ ucfirst(Auth::user()->created_at->format('M. Y')) }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="{{ route('logout', [], false) }}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
