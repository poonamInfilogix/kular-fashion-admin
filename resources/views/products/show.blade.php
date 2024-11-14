@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Products</h4>

                        <div class="page-title-right">
                            <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i>
                                Back to products</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <img src="{{ asset($product->image) }}" alt=""
                                        class="img-fluid mx-auto d-block w-100"
                                        onerror="this.onerror=null; this.src='{{ asset(setting('default_product_image')) }}';">
                                </div>

                                <div class="col-xl-8">
                                    <div class="mt-4 mt-xl-3">
                                        <div>
                                            <a href="javascript: void(0);" class="text-primary">{{ $product->brand->brand_name }}</a>
                                            > {{ $product->productType->product_type_name }}
                                        </div>

                                        <h4 class="mt-1 mb-2">Article Code: {{ $product->article_code }}</h4>
                                        <h6 class="mb-2">Manufacture Code: {{ $product->manufacture_code }}</h6>
                                        <h6 class="mb-2">Supplier Price: {{ $product->supplier_price }}</h6>
                                        <h6 class="mb-2">In Date: {{ $product->in_date }}</h6>
                                        <h6 class="mb-3">Price: <b>£{{ $product->mrp }}</b></h6>
                                        <p class="text-muted mb-4">{{ $product->short_description }}</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="mt-4">
                                <h5 class="mb-3">Quantities & Sizes:</h5>

                                <div class="table-responsive">
                                    <table class="table mb-0 table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Size</th>
                                                @foreach ($product->sizes as $size)
                                                <th>{{ $size->sizeDetail->size }}</th>
                                                @endforeach
                                            </tr>

                                            @foreach ($product->colors as $color)
                                            <tr>
                                                <th class="d-flex">
                                                    <div class="me-1" style="height: 1.5rem; width: 1.5rem; background: {{ $color->colorDetail->ui_color_code }}"></div>
                                                    <h6 class="m-0">{{ $color->colorDetail->color_name }} ({{ $color->colorDetail->color_code }})</h6>
                                                </th>
                                                @foreach ($product->sizes as $size)
                                                    <td>{{ $size->quantity($color->id) }}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach

                                            <tr>
                                                <th scope="row">MRP</th>
                                                @foreach ($product->sizes as $size)
                                                <td>£{{ $size->mrp }}</td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end Specifications -->

                        </div>
                    </div>
                    <!-- end card -->
                </div>
            </div>
        </div>
    </div>
@endsection
