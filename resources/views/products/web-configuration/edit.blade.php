@extends('layouts.app')

@section('title', 'Edit Web Configuration')
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
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
                                <div class="dropzone" id="product-dropzone">
                                    <div class="fallback">
                                        {{-- <input name="product_image" type="file" multiple="multiple"> --}}
                                        <x-form-input name="product_image" type="file" multiple="multiple" />
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
                                                <button type="button" class="btn btn-danger delete-image mt-4"
                                                    data-id="{{ $image->id }}">
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
                                        <textarea name="product_desc" id="product_desc" class="editor" rows="2">{{ $data['description'] ?? '' }}</textarea>
                                    </div>
                                </div>

                                <!-- Product Specification -->
                                <div class="card">
                                    <div class="card-body" id="product-specification">
                                        <h4 class="card-title">Product Specification</h4>
                                        <div class="row" id="specification-container">
                                            @if (isset($product->webSpecification) && count($product->webSpecification) > 0)

                                                @foreach ($product->webSpecification as $specificationIndex => $specification)
                                                    <div class="col-md-6 specification-item mb-3" id="spec-0">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <x-form-input
                                                                    name="specifications[{{ $specificationIndex }}][key]"
                                                                    value="{{ $specification->key }}" label="Key"
                                                                    placeholder="Key" class="form-control"
                                                                    required="true" />
                                                            </div>

                                                            <div class="col-md-5">
                                                                <x-form-input
                                                                    name="specifications[{{ $specificationIndex }}][value]"
                                                                    value="{{ $specification->value }}" label="Value"
                                                                    placeholder="Value" class="form-control"
                                                                    required="true" />
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
                                        <button id="add-specification" class="btn btn-primary mt-3">Add
                                            Specification</button>
                                    </div>
                                </div>

                                <!-- SEO -->
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">SEO</h4>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="mb-3">
                                                    <x-form-input name="meta_title" label="Meta title"
                                                        value="{{ $data['meta_title'] ?? '' }}" placeholder="Meta title"
                                                        required="true" />
                                                </div>
                                                <div class="mb-3">
                                                    <x-form-input name="meta_keywords" label="Meta Keywords"
                                                        value="{{ $data['meta_keywords'] ?? '' }}"
                                                        placeholder="Meta Keywords" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="meta_description">Meta Description</label>

                                                    <textarea name="meta_description" class="form-control" id="meta_description" rows="5"
                                                        placeholder="Meta Description">{{ $data['meta_description'] ?? '' }}
                                    
                                                    </textarea>
                                                </div>
                                            </div>

                                            <!-- Form Buttons -->
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                                    Changes</button>
                                                <button type="button"
                                                    class="btn btn-secondary waves-effect waves-light">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                    </form>
                </div>
            </div>
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
                paramName: "file",
                maxFilesize: 10,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "Drop files here or click to upload.",
                dictRemoveFile: "Remove",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                init: function() {
                    this.on("success", function(file, response) {
                        console.log(response);
                    });
                    this.on("error", function(file, response) {
                        console.log(response);
                    });
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
                                <div class="col-md-6">
                                    <x-form-input name="specifications[${specCount}][value]" label="Value" placeholder="Value" class="form-control" required="true" />
                                </div>
                                <div class="col-md-1">
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


            //Delete Product Image

            $(document).on('click', '.delete-image', function() {
                let imageId = $(this).data('id');
                let imageContainer = $(this).closest('.image-container');

                swal({
                    title: "Are you sure?",
                    text: `You really want to  this?`,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "DELETE",
                            dataType: "json",
                            url: "{{ route('product.destroy.image', '') }}/" + imageId,
                            data: {

                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        type: "success",
                                        showConfirmButton: false
                                    })

                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating status:', error);
                            }
                        });
                    } else {
                        toggleButton.prop('checked', !toggleButton.prop('checked'));
                    }
                });

            });
        </script>
    @endpush
@endsection
