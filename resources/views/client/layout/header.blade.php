<header class="main-header">
    <a href="{{ url('client/home') }}" class="logo">
        <span class="logo-mini">{{ auth()->user()->name }}</span>
        <span class="logo-lg"> <img src="{{ url('/assets/img/greefi.jpg') }}" height="25px"> {{ auth()->user()->transportName }}</span>
    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ url('/assets/img/avatar5.png') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->transportName }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ url('/assets/img/avatar5.png') }}" class="img-circle" alt="User Image">
                            <p>
                                {{ auth()->user()->transportName }}
                                <small>{{ auth()->user()->address }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('/client/logout') }}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ url('/client/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>