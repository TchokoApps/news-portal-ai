    @include('admin.layouts.navbar')

    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}">Stisla</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="{{ route('admin.dashboard') }}">St</a>
            </div>
            <ul class="sidebar-menu">
                <li class="dropdown">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"><span>Dashboard</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('admin.language.index') }}" class="nav-link"><span>Languages</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('admin.category.index') }}" class="nav-link"><span>Categories</span></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><span>News</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.news.index') }}">All News</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><span>Layout</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
                        <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
                        <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
                    </ul>
                </li>
            </ul>
        </aside>
    </div>
