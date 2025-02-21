@extends('layouts.app')

@section('title', 'View Article')
@section('header-button')
    <a href="{{ route('products.edit.web-configuration', $product->id) }}" class="btn btn-primary"><i class="bx bx-landscape"></i> Product Web Configuration</a>
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
@endsection

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
                                                    > {{ $product->productType->name }}
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <p class="text-muted mb-2">{{ $product->short_description }}</p>
                                            </div>
                                            <div class="col-sm-4">
                                                <h6 class="mb-2">Manufacture Code: {{ $product->manufacture_code }}</h6>
                                            </div>
                                            <div class="col-sm-4">
                                                <h6>Price: <b>£{{ $product->mrp }}</b></h6>
                                            </div>
                                            @if ($product->in_date)
                                                <div class="col-sm-4">
                                                    <h6>In Date: <b>{{ $product->in_date->format('d-m-Y') }}</b></h6>
                                                </div>
                                            @endif
                                            @if ($product->last_date && $product->in_date != $product->last_date)
                                                <div class="col-sm-4">
                                                    <h6>Last In Date: <b>{{ $product->last_date->format('d-m-Y') }}</b>
                                                    </h6>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">

                            
                                <div class="d-flex justify-content-between">
                                    <h5>{{ $branches->first()->name }} Inventory</h5>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#inventoryModal">View inventory in all stores</button>
                                </div>
                                <div class="table-responsive mt-2">
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
                                                            style="background: {{ $color->colorDetail->ui_color_code }}">
                                                        </div>
                                                        <h6 class="m-0">{{ $color->colorDetail->name }}
                                                            ({{ $color->colorDetail->code }})</h6>
                                                    </th>
                                                    @foreach ($product->sizes as $size)
                                                        <td class="p-1">
                                                            <strong>{{ $size->quantity($color->id) }}</strong> /
                                                            {{ $size->totalQuantity($color->id) }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach

                                            @php
                                                $mrpValues = $product->sizes->pluck('mrp');
                                                $isDifferent = $mrpValues->unique()->count() > 1;
                                            @endphp

                                            @if ($isDifferent)
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


    <div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inventoryModalLabel">All Stores Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-0">
                        <div class="d-flex justify-content-between">
                            <h6><strong>{{ $branches->first()->name }}</strong></h6>
                        </div>
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
                                                <h6 class="m-0">{{ $color->colorDetail->name }}
                                                    ({{ $color->colorDetail->code }})</h6>
                                            </th>
                                            @foreach ($product->sizes as $size)
                                                <td class="p-1"><strong>{{ $size->quantity($color->id) }}</strong> /
                                                    {{ $size->totalQuantity($color->id) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @foreach ($branches->skip(1) as $branch)
                        <div class="d-flex justify-content-between mt-3">
                            <h6><strong>{{ $branch->name }}</strong></h6>
                        </div>
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
                                                <h6 class="m-0">{{ $color->colorDetail->name }}
                                                    ({{ $color->colorDetail->code }})
                                                </h6>
                                            </th>
                                            @foreach ($product->sizes as $size)
                                                <td class="p-1">
                                                    <strong>{{ $size->inventoryAvailableQuantity($color->color_id, $branch->id) }}</strong>
                                                    /
                                                    {{ $size->inventoryTotalQuantity($color->color_id, $branch->id) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
