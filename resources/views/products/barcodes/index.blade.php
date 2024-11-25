@extends('layouts.app', ['isVueComponent' => true])

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @php
                $links = [
                    'productList'   => route('products.index'),
                    'printBarcode'  => route('download.barcodes'),
                ];
            @endphp
            <generate-product-barcodes :links="{{ json_encode($links) }}"></generate-product-barcodes>
        </div>
    </div>

    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>
@endsection
