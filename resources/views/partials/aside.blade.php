<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bolder ms-2 text-capitalize">Speed Cashier</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @can('dashboard')    
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('/') ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        @endcan

        <!-- Users -->
        @can('index_user', 'create_user', 'edit_user', 'delete_user')
            <li class="menu-item {{ Request::is('user/*') ? 'active' : '' }} {{ Request::is('user') ? 'active' : '' }}">
                <a href="/user" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-user'></i>
                    <div data-i18n="Analytics">Users</div>
                </a>
            </li>
        @endcan

        {{-- kota --}}
        <li class="menu-item {{ Request::is('kota') ? 'active' : '' }}">
            <a href="/kota" class="menu-link">
                <i class='menu-icon bx bx-buildings'></i>
                <div data-i18n="Analytics">Kota</div>
            </a>
        </li>

        {{-- meja --}}
        <li class="menu-item {{ Request::is('meja') ? 'active' : '' }}">
            <a href="/meja" class="menu-link">
                <i class='menu-icon bx bx-table'></i>
                <div data-i18n="Analytics">Meja</div>
            </a>
        </li>

        <!-- Category -->
        @can('index_kategori', 'create_kategori', 'edit_kategori', 'delete_kategori')
            <li
                class="menu-item {{ Request::is('kategori/*') ? 'active' : '' }} {{ Request::is('kategori') ? 'active' : '' }}">
                <a href="/kategori" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-category'></i>
                    <div data-i18n="Analytics">Categories</div>
                </a>
            </li>
        @endcan

        <!-- Menus -->
        @can('index_menu', 'create_menu', 'edit_menu', 'delete_menu')
            <li class="menu-item {{ Request::is('menu/*') ? 'active' : '' }} {{ Request::is('menu') ? 'active' : '' }}">
                <a href="/menu" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-food-menu'></i>
                    <div data-i18n="Analytics">Menus</div>
                </a>
            </li>
        @endcan

        @can('index_transaksi', 'create_transaksi', 'edit_transaksi', 'delete_transaksi')
            <li class="menu-item {{ Request::is('transaksi/*') ? 'active' : '' }} {{ Request::is('transaksi') ? 'active' : '' }}">
                <a href="/transaksi" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-credit-card-front'></i>
                    <div data-i18n="Analytics">Transaction</div>
                </a>
            </li>
        @endcan
    </ul>
</aside>
