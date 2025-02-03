<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box">
                <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/small-logo.png') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" class="bg-white" height="50">
                    </span>
                </a>

                <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/images/small-logo.png') }}" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="" class="bg-white" height="50">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>
        @if(request()->routeIs('products.create') || request()->routeIs('products.edit') || request()->routeIs('products.show'))
            <div class="d-flex w-100 justify-content-between align-items-center">
                <!-- Conditional Title -->
                <h4 class="mb-0 font-size-16">
                    @if(request()->routeIs('products.create'))
                        Create a new product
                    @elseif(request()->routeIs('products.edit'))
                        Edit product {{ $product->article_code }}
                    @elseif(request()->routeIs('products.show'))
                        View Article
                    @endif
                </h4>

                <!-- Button -->
                <div class="page-title-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="bx bx-arrow-back"></i> Back to products
                    </a>
                </div>
            </div>
        @elseif(request()->routeIs('products.index'))
            <!-- Display title for product listing -->
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h4 class="mb-0 font-size-16">Products</h4>
            </div>
            <div class="page-title-right d-flex align-items-center gap-2">
                {{-- <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="d-inline">
                    @csrf
                    <input type="file" name="file" id="fileInput" accept=".csv" required style="display: none;" onchange="document.getElementById('importForm').submit();">
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('fileInput').click();">
                        <i class="fas fa-file-import"></i> Import Products
                    </button>
                </form>

                <a href="{{ route('products.export') }}" class="btn btn-primary">
                    <i class="bx bx-download"></i> Download Product Configuration File
                </a> --}}
                @if(Auth::user()->can('create products'))
                <a href="{{ route('products.create') }}" id="add-product-link" class="btn btn-primary">
                    <i class="bx bx-plus fs-16"></i> Add New Product
                </a>
                @endif
            </div>
        @elseif(request()->routeIs('products.create.step-2'))
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h4 class="mb-0 font-size-16">Step 2</h4>
            </div>

            <div class="page-title-right">
                <a href="{{ route('products.create.step-1') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Step 1</a>
            </div>
        @elseif(request()->routeIs('products.create.step-3'))
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h4 class="mb-0 font-size-16">Step 3</h4>
            </div>

            <div class="page-title-right">
                <a href="{{ route('products.create.step-2') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Step 2</a>
            </div>
        @elseif(request()->routeIs('products.edit.step-2'))
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h4 class="mb-0 font-size-16">Edit variations for article {{ $product->article_code }} </h4>
            </div>
            <div class="page-title-right">
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Step 1</a>
            </div>
        @endif

            <div class="d-flex">
                <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="bx bx-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/user.jpg') }}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                </div>
            </div>
        </div>
    </div>
</header>