<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('backsite.dashboard.index') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('backsite.customer.index') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('backsite.service.index') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Servis</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('backsite.service-detail.index') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Bisa Diambil</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('backsite.transaction.index') }}" class="waves-effect">
                        <i class="bx bx-chat"></i>
                        <span>Servis Selesai</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="index.html">Servis</a></li>
                        <li><a href="dashboard-saas.html">Teknisi</a></li>
                    </ul>
                </li>

                <li class="menu-title">Pengaturan</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span>Kelola Akses</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('backsite.permission.index') }}">Permission</a></li>
                        <li><a href="{{ route('backsite.role.index') }}">Role</a></li>
                        <li><a href="{{ route('backsite.type_user.index') }}">Type User</a></li>
                        <li><a href="{{ route('backsite.user.index') }}">User</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->