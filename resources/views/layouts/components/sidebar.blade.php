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
                    <a href="{{ route('products.index') }}" class="waves-effect">
                        <i class="bx bx-cube"></i>
                        <span>View Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.create') }}" class="waves-effect">
                        <i class="bx bx-cube"></i>
                        <span>Add Product</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('products.print-barcodes') }}" class="waves-effect">
                        <i class="bx bx-printer"></i>
                        <span>Print Barcodes</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventory-transfer.index') }}" class="waves-effect">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Inventory Transfer</span>
                    </a>
                </li>

                <li class="menu-title" key="t-menu">Product Settings</li>
                <li>
                    <a href="{{ route('departments.index') }}" class="waves-effect">
                        <i class="bx bx-shield-alt"></i>
                        <span>Departments</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('product-types.index') }}" class="waves-effect">
                        <i class="bx bxs-data"></i>
                        <span>Product Types</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('brands.index') }}" class="waves-effect">
                        <i class="bx bxl-bootstrap"></i>
                        <span>Brands</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('colors.index') }}" class="waves-effect">
                        <i class="bx bxs-color-fill"></i>
                        <span>Colors</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('size-scales.index') }}" class="waves-effect">
                        <i class="bx bx-font-size"></i>
                        <span>Size Scales</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags.index') }}" class="waves-effect">
                        <i class="bx bx-purchase-tag"></i>
                        <span>Tags</span>
                    </a>
                </li>

                <li class="menu-title" key="t-menu">Admin Settings</li>
                <li>
                    <a href="{{ route('branches.index') }}" class="waves-effect">
                        <i class="bx bx-store-alt"></i>
                        <span>Branches</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="bx bx-group"></i>
                        <span>Customers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('suppliers.index') }}" class="waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span>Suppliers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles-and-permissions.role-list') }}" class="waves-effect">
                        <i class="bx bxs-user-check"></i>
                        <span>Roles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles-and-permissions.index') }}" class="waves-effect">
                        <i class="bx bxs-customize"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tax-settings.index') }}" class="waves-effect">
                        <i class="bx bx-pound"></i>
                        <span>Tax</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.index') }}" class="waves-effect">
                        <i class="bx bx-images"></i>
                        <span>Default Images</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('change-price-reasons.index') }}" class="waves-effect">
                        <i class="bx bx-stats"></i>
                        <span>Change Price Reasons</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('general-settings.index') }}" class="waves-effect">
                        <i class="fas fa-cog"></i>
                        <span>General</span>
                    </a>
                </li>
                <!-- New List End -->

            </ul>
        </div>
    </div>
</div>