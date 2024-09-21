<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/dashboard">
            {{-- <span class="align-middle">AdminKit</span> --}}
            <img src="{{ asset('adminKit/img/brand/features1.png') }}" alt=""
                style="width: 50px">
            <h3 style="color:white; font-size:30px; font-weight: bold; margin: 0px;">STOCK</h3>
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
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Produk</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('type*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/type">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Tipe Produk</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('incoming*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/incoming">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Produk Masuk</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('outgoing*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/outgoing">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Produk Keluar</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('stock*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/stock">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Balance Stok</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('report*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/report">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Report</span>
                </a>
            </li>
        </ul>
    </div>
</nav>