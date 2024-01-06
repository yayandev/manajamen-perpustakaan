<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (auth()->user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Data master</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('users') }}">
                            <i class="bi bi-circle"></i><span>Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('perpustakaan') }}">
                            <i class="bi bi-circle"></i><span>Perpustakaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kategori') }}">
                            <i class="bi bi-circle"></i><span>Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('buku') }}">
                            <i class="bi bi-circle"></i><span>Buku</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        <!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('userprofile') }}">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</aside>
