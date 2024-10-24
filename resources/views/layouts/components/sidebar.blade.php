<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Dashboard</li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="bx bx-home-alt"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title" key="t-menu">Catalog</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-box"></i>
                        <span key="t-ecommerce">Manage Products</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('categories.index')}}" key="t-products">Categories</a></li>
                        <li><a href="#" key="t-products">Subcategories</a></li>
                        <li><a href="#" key="t-products">Brands</a></li>
                        <li><a href="#" key="t-products">Products</a></li>
                    </ul>
                </li>
                <li >
                    <a href="#" class="waves-effect">
                        <i class="bx bx-user"></i>
                        <span key="t-user">Manage Customers</span>
                    </a>
                </li>
                <li class="menu-title" key="t-menu">Settings</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-box"></i>
                        <span key="t-ecommerce">Manage Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('categories.index')}}" key="t-products">Default Images</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>