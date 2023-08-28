<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                @can('dashboard_access')
                    <li>
                        <a href="{{ route('backsite.dashboard.index') }}" class="waves-effect">
                            <i class="bx bx-grid-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('customer_access')
                    <li>
                        <a href="{{ route('backsite.customer.index') }}" class="waves-effect">
                            <i class="bx bx-user"></i>
                            <span>Pelanggan</span>
                        </a>
                    </li>
                @endcan
                @can('service_access')
                    <li>
                        <a href="{{ route('backsite.service.index') }}" class="waves-effect">
                            <i class="bx bx-log-in"></i>
                            <span>Servis</span>
                        </a>
                    </li>
                @endcan
                @can('service_detail_access')
                    <li>
                        <a href="{{ route('backsite.service-detail.index') }}" class="waves-effect">
                            <i class="bx bx-check"></i>
                            <span>Bisa Diambil</span>
                        </a>
                    </li>
                @endcan
                @can('transaction_access')
                    <li>
                        <a href="{{ route('backsite.transaction.index') }}" class="waves-effect">
                            <i class="bx bx-log-out"></i>
                            <span>Servis Keluar</span>
                        </a>
                    </li>
                @endcan
                @can('report_access')
                    <li>
                        <a class="has-arrow waves-effect">
                            <i class="bx bx-bar-chart-square"></i>
                            <span>Laporan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('report_service_access')
                                <li><a href="{{ route('backsite.report-transaction.index') }}">Servis</a></li>
                            @endcan
                            @can('report_employee_access')
                                <li><a href="{{ route('backsite.report-employees.index') }}">Teknisi</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                @can('manage_access')
                    <li class="menu-title">Pengaturan</li>

                    <li>
                        <a class="has-arrow waves-effect">
                            <i class="bx bx-slider-alt"></i>
                            @if(auth()->user()->detail_user->type_user_id == 2)
                                <span>Kelola Pegawai</span>
                            @else
                                <span>Kelola Akses</span>
                            @endif
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('permission_access')
                                <li><a href="{{ route('backsite.permission.index') }}">Permission</a></li>
                            @endcan
                            @can('role_access')
                                <li><a href="{{ route('backsite.role.index') }}">Role</a></li>
                            @endcan
                            @can('type_user_access')
                                <li><a href="{{ route('backsite.type_user.index') }}">Type User</a></li>
                            @endcan
                            @can('user_access')
                                <li><a href="{{ route('backsite.user.index') }}">User</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
