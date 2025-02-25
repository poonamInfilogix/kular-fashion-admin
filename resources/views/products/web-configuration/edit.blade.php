@extends('layouts.app')

@section('title', 'Edit web configuration for artcle: ' . $product->article_code)
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-error-message :message="$errors->first('message')" />
            <x-success-message :message="session('success')" />

            <div class="row">
                <div class="col-md-4 mb-2 fs-5">
                    <strong>Brand Name:</strong> {{ $product->brand->name }}
                </div>
                <div class="col-md-3 mb-2 fs-5">
                    <strong>Product Type:</strong> {{ $product->productType->name }}
                </div>
                <div class="col-12">
                    <form action="{{ route('products.update.web-configuration', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('products.web-configuration.form')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins :plugins="['contentEditor', 'dropzone', 'datePicker', 'select2']"></x-include-plugins>

    @push('scripts')
        @include('products.web-configuration.script')
    @endpush
@endsection
