@extends('layouts.app')

@section('title', 'Create a Purchase Order')
@section('header-button')
    <a href="{{ route('purchase-orders.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to purchase orders</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('purchase-orders.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <x-form-input name="order_no" value="" label="Order No" placeholder="Enter Order No" required="true"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <x-form-input name="supplier_order_no" value="" label="Supplier Order No" placeholder="Supplier Order No" required="true"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="mb-3">
                                            <x-form-input name="supplier_order_date" value="" label="Supplier Order Date" placeholder="Supplier Order Date" required="true"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <x-form-input name="delivery_date" value="" label="Delivery Date" placeholder="Delivery Date" required="true"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="mb-3">
                                            <label for="supplier_id">Supplier Name <span class="text-danger">*</span></label>
                                            <select name="supplier_id" id="supplier_id" class="form-control{{ $errors->has('supplier_id') ? ' is-invalid' : '' }}">
                                                <option value="" disabled selected>Select Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">
                                                        {{ $supplier->supplier_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="product-fields-container">
                                    <div class="product-field-group mb-3 border p-3">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="product_code">Product Code <span class="text-danger">*</span></label>
                                                    <input type="text" name="product_code[]" class="form-control" placeholder="Enter Product Code" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="mb-3">
                                                    <label for="short_description">Short Description <span class="text-danger">*</span></label>
                                                    <input type="text" name="short_description[]" class="form-control" placeholder="Enter Short Description" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="supplier_color_code">Supplier Color Code<span class="text-danger">*</span></label>
                                                    <input type="text" name="supplier_color_code[]" class="form-control" placeholder="Enter Supplier Color Code" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <div class="mb-3">
                                                        <label for="color">Select Color <span class="text-danger">*</span></label>
                                                        <select name="colors[]" id="color" @class(["form-control", "is-invalid" =>  $errors->has('colors')])>
                                                            <option value="" disabled selected>Select Color</option> 
                                                            @foreach($colors as $color)
                                                                <option value="{{ $color->id }}"> {{ $color->color_name }} ({{ $color->color_code }})</option>
                                                            @endforeach
                                                        </select>
                                                        @error('colors')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="product_type">Product_Type<span class="text-danger">*</span></label>
                                                    <select name="product_type[]" id="product_type" @class(["form-control", "is-invalid" =>  $errors->has('product_type')])>
                                                        <option value="" disabled selected>Select Product Type</option> 
                                                        @foreach($productTypes as $productType)
                                                            <option value="{{ $productType->id }}">{{ $productType->product_type_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('product_type')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="size_scale_id">Size Scale<span class="text-danger">*</span></label>
                                                    <select name="size_scale_id" id="size_scale_id"  class="form-control size-scale-dropdown">
                                                        <option value="" disabled selected>Select size scale</option>
                                                        @foreach ($sizeScales as $sizeScale)
                                                            <option value="{{ $sizeScale->id }}" @selected(old('size_scale_id', $product->size_scale_id ?? '') == $sizeScale->id)>
                                                                {{ $sizeScale->size_scale }}
                                        
                                                                @if (isset($sizeScale->sizes))
                                                                    ({{ $sizeScale->sizes->first()->size }} - {{ $sizeScale->sizes->last()->size }})
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('size_scale_id')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="min_size_id">Min Size<span class="text-danger">*</span></label>
                                                    <select name="min_size_id[]" class="form-control min-size-dropdown">
                                                        <option value="" disabled selected>Select Min Size</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="max_size_id">Max Size<span class="text-danger">*</span></label>
                                                    <select name="max_size_id[]" class="form-control max-size-dropdown">
                                                        <option value="" disabled selected>Select Max Size</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="delivery_date">Delivery Date<span class="text-danger">*</span></label>
                                                    <input type="date" name="delivery_date[]" class="form-control" placeholder="Enter Delivery Date" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-2">
                                                <div class="mb-3">
                                                    <label for="unit_price">Price <span class="text-danger">*</span></label>
                                                    <input type="number" name="unit_price[]" class="form-control" placeholder="Enter Unit Price" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-product-field">Remove</button>
                                    </div>
                                </div>
                                <button type="button" id="add-product-field" class="btn btn-primary">Add New Product</button>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-include-plugins :plugins="['chosen', 'datePicker']"></x-include-plugins>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(function(){
            $('#product_type').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Product Type'
            });
            $('#size_scale_id').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Size Scale'
            });
            $('#color').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Color'
            });
        });
        $(document).ready(function() {
            $("form").validate({
                rules: {
                    "order_no": {
                        required: true,
                    },
                    "supplier_order_no": {
                        required: true,
                    },
                    "supplier_order_date": {
                        required: true,
                        date: true
                    },
                    "delivery_date": {
                        required: true,
                        date: true
                    },
                    "supplier_id": {
                        required: true,
                    },
                    "product_code[]": {
                        required: true,
                    },
                    "short_description[]": {
                        required: true,
                    },
                    "supplier_color_code[]": {
                        required: true,
                    },
                    "colors[]": {
                        required: true,
                    },
                    "product_type[]": {
                        required: true,
                    },
                    "size_scale_id[]": {
                        required: true,
                    },
                    "min_size_id[]": {
                        required: true,
                    },
                    "max_size_id[]": {
                        required: true,
                    },
                    "quantity[]": {
                        required: true,
                        number: true,
                        min: 1
                    },
                    "unit_price[]": {
                        required: true,
                        number: true,
                        min: 0.01
                    }
                },
                messages: {
                    "order_no": {
                        required: "Please enter the order number.",
                    },
                    "supplier_order_no": {
                        required: "Please enter the supplier order number.",
                    },
                    "supplier_order_date": {
                        required: "Please enter the supplier order date.",
                        date: "Please enter a valid date."
                    },
                    "delivery_date": {
                        required: "Please enter the delivery date.",
                        date: "Please enter a valid date."
                    },
                    "supplier_id": {
                        required: "Please select a supplier.",
                    },
                    "product_code[]": {
                        required: "Please enter the product code.",
                    },
                    "short_description[]": {
                        required: "Please enter the short description.",
                    },
                    "supplier_color_code[]": {
                        required: "Please enter the supplier color code.",
                    },
                    "colors[]": {
                        required: "Please select a color.",
                    },
                    "product_type[]": {
                        required: "Please select a product type.",
                    },
                    "size_scale_id[]": {
                        required: "Please select a size scale.",
                    },
                    "min_size_id[]": {
                        required: "Please select a minimum size.",
                    },
                    "max_size_id[]": {
                        required: "Please select a maximum size.",
                    },
                    "quantity[]": {
                        required: "Please enter the quantity.",
                        number: "Please enter a valid number.",
                        min: "Quantity must be at least 1."
                    },
                    "unit_price[]": {
                        required: "Please enter the unit price.",
                        number: "Please enter a valid number.",
                        min: "Price must be at least 0.01."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "colors[]" || element.attr("name") == "product_type[]" || element.attr("name") == "size_scale_id[]" || element.attr("name") == "min_size_id[]" || element.attr("name") == "max_size_id[]") {
                        error.insertAfter(element.next('.chosen-container'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $('#add-product-field').click(function() {
                var newField = `
                    <div class="product-field-group mb-3 border p-3">
                        <div class="row">
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="product_code">Product Code <span class="text-danger">*</span></label>
                                    <input type="text" name="product_code[]" class="form-control" placeholder="Enter Product Code" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-3">
                                    <label for="short_description">Short Description <span class="text-danger">*</span></label>
                                    <input type="text" name="short_description[]" class="form-control" placeholder="Enter Short Description" required>
                                </div>
                            </div>
                             <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="supplier_color_code">Supplier Color Code<span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_color_code[]" class="form-control" placeholder="Enter Supplier Color Code" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="color">Select Color <span class="text-danger">*</span></label>
                                        <select name="colors[]" id="color" class="form-control color-dropdown">
                                            <option value="" disabled selected>Select Color</option> 
                                            @foreach($colors as $color)
                                                <option value="{{ $color->id }}"> {{ $color->color_name }} ({{ $color->color_code }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="color">Product_Type<span class="text-danger">*</span></label>
                                    <select name="product_type[]" id="product_type" class="form-control product-type-dropdown">
                                        <option value="" disabled selected>Select Product Type</option> 
                                        @foreach($productTypes as $productType)
                                            <option value="{{ $productType->id }}">{{ $productType->product_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="size_scale_id">Size Scale<span class="text-danger">*</span></label>
                                    <select name="size_scale_id[]" id="size_scale_id" class="form-control size-scale-dropdown">
                                        <option value="" disabled selected>Select Size Scale</option>
                                        @foreach ($sizeScales as $sizeScale)
                                            <option value="{{ $sizeScale->id }}">
                                                {{ $sizeScale->size_scale }}
                                                @if (isset($sizeScale->sizes))
                                                    ({{ $sizeScale->sizes->first()->size }} - {{ $sizeScale->sizes->last()->size }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="min_size_id">Min Size<span class="text-danger">*</span></label>
                                    <select name="min_size_id[]" class="form-control min-size-dropdown">
                                        <option value="" disabled selected>Select Min Size</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="max_size_id">Max Size<span class="text-danger">*</span></label>
                                    <select name="max_size_id[]" class="form-control max-size-dropdown">
                                        <option value="" disabled selected>Select Max Size</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required>
                                </div>
                            </div>
                             <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="delivery_date">Delivery Date<span class="text-danger">*</span></label>
                                    <input type="date" name="delivery_date[]" class="form-control" placeholder="Enter Delivery Date" required>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2">
                                <div class="mb-3">
                                    <label for="unit_price">Price <span class="text-danger">*</span></label>
                                    <input type="number" name="unit_price[]" class="form-control" placeholder="Enter Unit Price" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger remove-product-field">Remove</button>
                    </div>
                `;
                $('#product-fields-container').append(newField);

                $('.color-dropdown').chosen({
                    width: '100%',
                    placeholder_text_multiple: 'Select Color'
                });

                $('.product-type-dropdown').chosen({
                    width: '100%',
                    placeholder_text_multiple: 'Select Product Type'
                });

                $('.size-scale-dropdown').chosen({
                    width: '100%',
                    placeholder_text_multiple: 'Select Size Scale'
                });
            });

            $(document).on('click', '.remove-product-field', function() {
                $(this).closest('.product-field-group').remove();
            });
        });

        $(document).on('change', '.size-scale-dropdown', function() {
            var selectedSizeScaleId = $(this).val();
            var parent = $(this).closest('.product-field-group');

            $.ajax({
                url: '/get-size-range',
                method: 'GET',
                data: { size_scale_id: selectedSizeScaleId },
                success: function(response) {
                    var minSizeDropdown = parent.find('.min-size-dropdown');
                    var maxSizeDropdown = parent.find('.max-size-dropdown');

                    minSizeDropdown.empty();
                    maxSizeDropdown.empty();

                    minSizeDropdown.append('<option value="" disabled selected>Select Min Size</option>');
                    maxSizeDropdown.append('<option value="" disabled selected>Select Max Size</option>');

                    $.each(response.min_size_options, function(id, size) {
                        minSizeDropdown.append('<option value="' + id + '">' + size + '</option>');
                    });

                    $.each(response.max_size_options, function(id, size) {
                        maxSizeDropdown.append('<option value="' + id + '">' + size + '</option>');
                    });

                    minSizeDropdown.trigger('chosen:updated');
                    maxSizeDropdown.trigger('chosen:updated');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching size range:', error);
                }
            });
        });
    </script>
@endsection