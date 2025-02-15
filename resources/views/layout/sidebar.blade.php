<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/dashboard">
            <img src="{{ asset('adminKit/img/brand/logo.png') }}" alt=""
                style="width: 85px">
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item {{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/dashboard">
                    <i class="align-middle" data-feather="sliders"></i> <span
                        class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('product*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/product">
                    <i class="align-middle" data-feather="package"></i> <span class="align-middle">Produk</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('type*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/type">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Tipe Produk</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('incoming*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/incoming">
                    <i class="align-middle" data-feather="arrow-down-left"></i> <span class="align-middle">Produk Masuk</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('outgoing*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/outgoing">
                    <i class="align-middle" data-feather="arrow-up-right"></i> <span class="align-middle">Produk Keluar</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('stock*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/stock">
                    <i class="align-middle" data-feather="archive"></i> <span class="align-middle">Balance Stok</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('report*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/report">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Report</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('cash-flow*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/cash-flow">
                    <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Keuangan</span>
                </a>
            </li>
        </ul>
    </div>
</nav>