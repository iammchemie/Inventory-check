<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="images/icon/logo.png" class="img-fluid" alt="BPOM" style="max-width: 20%; margin-left: 35%" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                @auth
                    @if (Auth()->user()->RoleId == 1 || Auth()->user()->RoleId == 2)
                        <li class="{{ $title == 'Dashboard' ? 'active' : '' }}">
                            <a class="js-arrow" href="/">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                    @endif
                @endauth
                <li class="{{ $title == 'Inventaris Reagensia' ? 'active' : '' }}">
                    <a href="{{ route('reagensia') }}">
                        <i class="fas fa-flask"></i>Inventaris Reagensia</a>
                </li>
                @auth
                    @if (Auth()->user()->RoleId == 1)
                        <li class="{{ $title == 'User Management' ? 'active' : '' }}">
                            <a href="{{ route('usermanagement') }}">
                                <i class="fas fa-user"></i>User Management</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->
