@extends('layouts.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-xl-3">
                                <img src="{{ asset($product->image) }}" alt=""
                                    class="img-fluid mx-auto d-block w-100 product-preview-image"
                                    onerror="this.onerror=null; this.src='{{ asset(setting('default_product_image')) }}';">
                            </div>

                            <div class="col-xl-9">
                                <div class="mt-4 mt-xl-3">
                                    <div class="row mb-1">
                                        <div class="col-sm-8">
                                            <h5 class="mb-sm-0">View Article</h5>
                                        </div>

                                        <div class="col-sm-4">
                                            <a href="{{ route('products.index') }}"><i class="bx bx-arrow-back"></i>
                                                Back to products</a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h6 class="mt-1 mb-2">Article Code:
                                                <strong>{{ $product->article_code }}</strong>
                                            </h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div>
                                                <a href="javascript: void(0);"
                                                    class="text-primary">{{ $product->brand->name }}</a>
                                                > {{ $product->productType->product_type_name }}
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <p class="text-muted mb-2">{{ $product->short_description }}</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <h6 class="mb-2">Manufacture Code: {{ $product->manufacture_code }}</h6>
                                        </div>
                                        <div class="col-sm-4"></div>
                                        <div class="col-sm-4">
                                            <h6>Price: <b>£{{ $product->mrp }}</b></h6>
                                        </div>
                                        <div class="col-sm-4">
                                            @if($product->in_date && $product->last_date && $product->in_date->eq($product->last_date))
                                                <h6 class="mb-2">In Date:
                                                    <strong>{{ $product->in_date->format('Y-m-d') }}</strong>
                                                </h6>
                                            @else
                                                    @if($product->in_date)
                                                        <h6 class="mb-2">In Date: 
                                                        <strong>{{ $product->in_date->format('Y-m-d') }}</strong>
                                                    </h6>
                                                    @endif
                                                </div>
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-4">
                                                    @if($product->last_date)
                                                        <h6 class="mb-2">Last In Date: 
                                                        <strong>{{ $product->last_date->format('Y-m-d') }}</strong>
                                                        </h6>
                                                    @endif
                                            @endif
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5 class="mb-3">Quantities & Sizes:</h5>

                            <div class="table-responsive">
                                <table class="table mb-0 table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="p-1">Size</th>
                                            @foreach ($product->sizes as $size)
                                                <th class="p-1">{{ $size->sizeDetail->size }}</th>
                                            @endforeach
                                        </tr>

                                        @foreach ($product->colors as $color)
                                            <tr>
                                                <th class="d-flex p-1">
                                                    <div class="me-1 d-color-code"
                                                        style="background: {{ $color->colorDetail->ui_color_code }}"></div>
                                                    <h6 class="m-0">{{ $color->colorDetail->color_name }}
                                                        ({{ $color->colorDetail->color_code }})</h6>
                                                </th>
                                                @foreach ($product->sizes as $size)
                                                    <td class="p-1"><strong>{{ $size->quantity($color->id) }}</strong> /
                                                        {{ $size->totalQuantity($color->id) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach


                                        @php
                                            $mrpValues = $product->sizes->pluck('mrp');
                                            $isDifferent = $mrpValues->unique()->count() > 1;
                                        @endphp

                                        @if($isDifferent)
                                            <tr>
                                                <th scope="row" class="p-1">MRP</th>
                                                @foreach ($product->sizes as $size)
                                                    <td class="p-1">£{{ $size->mrp }}</td>
                                                @endforeach
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection