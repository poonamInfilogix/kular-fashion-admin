<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Dashboard</li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="bx bx-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @canany(['view departments', 'view product_types', 'view brands', 'view colors', 'view size_scales', 'view products', 'view print_barcodes', 'view tags', 'create products'])
                    <li class="menu-title" key="t-menu">Catalog</li>
                    @canany(['view departments', 'view product_types', 'view brands', 'view colors', 'view size_scales', 'view products'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-box"></i>
                            <span>Manage Products</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view departments')
                                <li><a href="{{ route('departments.index')}}">Departments</a></li>
                            @endcan
                            @can('view product_types')
                                <li><a href="{{ route('product-types.index')}}">Product Types</a></li>
                            @endcan
                            @can('view brands')
                                <li><a href="{{ route('brands.index') }}">Brands</a></li>
                            @endcan
                            @can('view colors')
                                <li><a href="{{ route('colors.index') }}">Colors</a></li>
                            @endcan
                            @can('view size_scales')
                                <li><a href="{{ route('size-scales.index') }}">Size Scales</a></li>
                            @endcan
                            @can('view products')
                                <li><a href="{{ route('products.index') }}">Products</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany

                    @can('create products')
                    <li>
                        <a href="{{ route('products.create') }}" class="waves-effect">
                            <i class="bx bx-cube"></i>
                            <span>Add new product</span>
                        </a>
                    </li>
                    @endcan
                    @can('view print_barcodes')
                    <li>
                        <a href="{{ route('products.print-barcodes') }}" class="waves-effect">
                            <i class="bx bx-printer"></i>
                            <span>Print Barcodes</span>
                        </a>
                    </li>
                    @endcan
                    @can('view tags')
                    <li>
                        <a href="{{ route('tags.index') }}" class="waves-effect">
                            <i class="bx bx-extension"></i>
                            <span>Manage Tags</span>
                        </a>
                    </li>
                    @endcan
                @endcanany

                @canany(['view branches','view inventory_transfer'])
                    <li class="menu-title">Stores and Inventory</li>
                    @can('view branches')
                        <li>
                            <a href="{{ route('branches.index') }}" class="waves-effect">
                                <i class="bx bx-store-alt"></i>
                                <span>Manage Branches</span>
                            </a>
                        </li>
                    @endcan
                    @can('view inventory_transfer')
                        <li>
                            <a href="{{ route('inventory-transfer.index') }}" class="waves-effect">
                                <i class="fas fa-exchange-alt"></i>
                                <span>Inventory Transfer</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['view users','view customers', 'view suppliers'])
                    <li class="menu-title">Users</li>
                    @can('view customers')
                        <li>
                            <a href="#" class="waves-effect">
                                <i class="bx bx-user"></i>
                                <span>Manage Customers</span>
                            </a>
                        </li>
                    @endcan
                    @can('view suppliers')
                        <li>
                            <a href="{{ route('suppliers.index') }}" class="waves-effect">
                                <i class="bx bx-user-circle"></i>
                                <span>Manage Suppliers</span>
                            </a>
                        </li>
                    @endcan
                    @can('view users')
                        <li>
                            <a href="{{ route('users.index') }}" class="waves-effect">
                                <i class="bx bx-group"></i>
                                <span>Manage Users</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['view settings','view roles & permissions', 'view price_reasons', 'view tax', 'view role'])
                    <li class="menu-title">Settings</li>
                    @canany(['view roles & permissions', 'view role'])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="fas fa-users-cog"></i>
                            <span>Roles & Permissions</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view role')
                            <li><a href="{{ route('roles-and-permissions.role-list') }}">Manage Roles</a></li>
                            @endcan
                            @can('view roles & permissions')
                            <li><a href="{{ route('roles-and-permissions.index') }}">Manage Permissions</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                    @can('view price_reasons')
                    <li>
                        <a href="{{ route('change-price-reasons.index') }}" class="waves-effect">
                            <i class="bx bx-stats"></i>
                            <span>Change Price Reasons</span>
                        </a>
                    </li>
                    @endcan
                    @canany(['view settings', 'view tax' ])
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view settings')
                            <li><a href="{{ route('settings.index')}}">Default Images</a></li>
                            @endcan
                            @can('view tax')
                                <li><a href="{{ route('tax-settings.index')}}">Tax Settings</a></li>
                            @endcan
                            @can('view settings')
                            <li><a href="{{ route('general-settings.index')}}">General Settings</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcanany
                @endcanany
            </ul>
        </div>
    </div>
</div>