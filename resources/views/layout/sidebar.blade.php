<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/dashboard">
            {{-- <span class="align-middle">AdminKit</span> --}}
            <img src="{{ asset('adminKit/img/brand/logo-uplift-market-white.png') }}" alt=""
                style="width: 200px">
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
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Product</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('in*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/in">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">In</span>
                </a>
            </li>
            <li class="sidebar-item {{ Request::is('out*') ? 'active' : '' }}">
                <a class="sidebar-link" href="/out">
                    <i class="align-middle" data-feather="layers"></i> <span class="align-middle">Out</span>
                </a>
            </li>
        </ul>
    </div>
</nav>