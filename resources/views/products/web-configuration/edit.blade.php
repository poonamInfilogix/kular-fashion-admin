@extends('layouts.app')

@section('title', 'Edit web configuration for artcle: '.$product->article_code)
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 mb-2 fs-5">
                    <strong>Product Name:</strong> {{ $product->name }}
                </div>
                <div class="col-md-4 mb-2 fs-5">
                    <strong>Brand Name:</strong> {{ $product->brand->name }}
                </div>
                <div class="col-md-3 mb-2 fs-5">
                    <strong>Product Type:</strong> {{ $product->productType->product_type_name }}
                </div>
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <form action="{{ route('products.update.web-configuration', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card">
                            <div class="card-body">
                                <!-- Product Images -->
                                <h4 class="card-title mb-3">Product Images</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <select name="color" id="color" class="form-control">
                                            <option value="">Select Color</option>

                                            @foreach ($product->colors as $color)
                                                <option value="{{ $color->id }}"> {{ $color->colorDetail->color_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="dropzone" id="product-dropzone">
                                    <div class="fallback">
                                        <x-form-input name="images[]" id="productImages" type="file" multiple="multiple" />
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                        </div>
                                        <h4>Drop files here or click to upload.</h4>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        @foreach ($product->webImage as $image)
                                            <div class="col-sm-3">
                                                <img src="{{ asset($image->path) }}" alt="Product Images"
                                                    class="img-thumbnail" width="100px" height="100px">
                                                <button type="button" class="btn btn-danger delete-btn mt-4"
                                                data-source="image" data-endpoint="{{ route('product.destroy.image', $image->id)}}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Product Description</h4>
                                <textarea name="product_desc" id="product_desc" class="editor" rows="2">{{ $product->webInfo->description ?? '' }}</textarea>
                            </div>
                        </div>

                        <!-- Product Specification -->
                        <div class="card">
                            <div class="card-body" id="product-specification">
                                <h4 class="card-title">Product Specifications</h4>
                                <div class="row" id="specification-container">
                                    @if (isset($product->webSpecification) && count($product->webSpecification) > 0)
                                        @foreach ($product->webSpecification as $specificationIndex => $specification)
                                            <div class="col-md-6 specification-item mb-3" id="spec-0">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <x-form-input name="specifications[{{ $specificationIndex }}][key]"
                                                            value="{{ $specification->key }}" label="Key"
                                                            placeholder="Key" class="form-control" required="true" />
                                                    </div>

                                                    <div class="col-md-5">
                                                        <x-form-input
                                                            name="specifications[{{ $specificationIndex }}][value]"
                                                            value="{{ $specification->value }}" label="Value"
                                                            placeholder="Value" class="form-control" required="true" />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-danger delete-specification mt-4"
                                                            data-spec-id="spec-0"><i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button id="add-specification" class="btn btn-secondary mt-3">Add Specification</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Status & Visibility</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                       <select name="visibilty" id="visibilty" class="form-control">
                                        <option value="0" @selected($product->webInfo->status ?? '' === '0')>Inactive</option>
                                        <option value="1" @selected($product->webInfo->status ?? '' === '1')>Active</option>
                                        <option value="2" @selected($product->webInfo->status ?? '' === '2')>Hide When Out Of Stock</option>
                                       </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">SEO</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <x-form-input name="meta_title" label="Meta title" required="true"
                                                value="{{ $product->webInfo->meta_title ?? '' }}"
                                                placeholder="Meta title" />
                                        </div>
                                        <div class="mb-3">
                                            <x-form-input name="meta_keywords" label="Meta Keywords"
                                                value="{{ $product->webInfo->meta_keywords ?? '' }}"
                                                placeholder="Meta Keywords" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description" rows="5"
                                                placeholder="Meta Description">{{ $product->webInfo->meta_description ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins :plugins="['contentEditor', 'dropzone']"></x-include-plugins>
    @push('scripts')
        <script>
            // Initialize Dropzone
            const dropzone = new Dropzone("#product-dropzone", {
                url: "{{ route('product.uploadImages', $product->id) }}",
                paramName: "image",
                maxFilesize: 10,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "Drop files here or click to upload.",
                dictRemoveFile: "Remove",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                init: function() {
                    this.on("success", function(file, response) {
                        file.previewElement.setAttribute("data-id", response.id);
                    });
                    this.on('removedfile', function(file) {
                        const imageId = file.previewElement.getAttribute("data-id");

                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('product.destroy.image', '') }}/" + imageId,
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                        });
                    })
                }
            });

            // Dynamic Specification Fields
            $(document).ready(function() {
                let specCount = $('.specification-item').length;

                // Add Specification
                $('#add-specification').click(function(event) {
                    event.preventDefault();
                    specCount++;
                    const newDiv = `
                        <div class="col-md-6 specification-item mb-3" id="spec-${specCount}">
                            <div class="row">
                                <div class="col-md-5">
                                    <x-form-input name="specifications[${specCount}][key]" type="text" label="Key" placeholder="Key" class="form-control" required="true" />
                                </div>
                                <div class="col-md-5">
                                    <x-form-input name="specifications[${specCount}][value]" label="Value" placeholder="Value" class="form-control" required="true" />
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger delete-specification mt-4" data-spec-id="spec-${specCount}"><i class="fas fa-trash-alt"></i> </button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#specification-container').append(newDiv);
                });

                // Delete Specification
                $(document).on('click', '.delete-specification', function() {
                    const specId = $(this).data('spec-id');
                    $(`#${specId}`).remove();
                });
            });
        </script>
    @endpush
@endsection
