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

                <li class="menu-title" key="t-menu">Catalog</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-box"></i>
                        <span>Manage Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('departments.index')}}">Departments</a></li>
                        <li><a href="{{ route('product-types.index')}}">Product Types</a></li>
                        <li><a href="{{ route('brands.index') }}">Brands</a></li>
                        <li><a href="{{ route('colors.index') }}">Colors</a></li>
                        <li><a href="{{ route('size-scales.index') }}">Size Scales</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('products.create') }}" class="waves-effect">
                        <i class="bx bx-cube"></i>
                        <span>Add new product</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.print-barcodes') }}" class="waves-effect">
                        <i class="bx bx-printer"></i>
                        <span>Print Barcodes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags.index') }}" class="waves-effect">
                        <i class="bx bx-extension"></i>
                        <span>Manage Tags</span>
                    </a>
                </li>
                <li class="menu-title">Stores and Inventory</li>
                <li>
                    <a href="{{ route('branches.index') }}" class="waves-effect">
                        <i class="bx bx-store-alt"></i>
                        <span>Manage Branches</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventory-transfer.index') }}" class="waves-effect">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Inventory Transfer</span>
                    </a>
                </li>

                <li class="menu-title">Users</li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Manage Customers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('suppliers.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span>Manage Suppliers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <i class="bx bx-group"></i>
                        <span>Manage Users</span>
                    </a>
                </li>


                <li class="menu-title">Settings</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users-cog"></i>
                        <span>Roles & Permissions</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('roles-and-permissions.role-list') }}">Manage Roles</a></li>
                        <li><a href="{{ route('roles-and-permissions.index') }}">Manage Permissions</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('change-price-reasons.index') }}" class="waves-effect">
                        <i class="bx bx-stats"></i>
                        <span>Change Price Reasons</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('settings.index')}}">Default Images</a></li>
                        <li><a href="{{ route('tax-settings.index')}}">Tax Settings</a></li>
                        <li><a href="{{ route('general-settings.index')}}">General Settings</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>