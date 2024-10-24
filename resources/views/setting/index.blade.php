@extends('layouts.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Default Images Settings</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <x-error-message :message="$errors->first('message')" />
                <x-success-message :message="session('success')" />

                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Category Image</label>
                                        <input type="file" name="category_image" id="add-category-image" class="form-control">
                                        @if (setting('category_image'))
                                            <img src="{{ asset(setting('category_image')) }}" id="preview-category" class="img-preview" style="width:50px;">
                                        @else
                                            <img src="" id="preview-category" style="width:50px;" name="image" hidden>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Sub Category Image</label>
                                        <input type="file" name="subcategory_image" id="add-subcategory" class="form-control">
                                        @if (setting('subcategory_image'))
                                            <img src="{{ asset(setting('subcategory_image')) }}" id="preview-subcategory" class="img-preview" style="width:50px;">
                                        @else
                                            <img src="" id="preview-subcategory" style="width:50px;" name="image" hidden>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary w-md">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
<x-include-plugins :plugins="['imagePreview']"></x-include-plugins>
@endsection