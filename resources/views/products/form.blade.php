<div class="row mb-2">
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="article_code" id="article_code" value="{{ $product->article_code ?? '' }}" label="Article Code" placeholder="Enter Article Code"  required="true" readonly/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="manufacture_code" value="{{ $product->manufacture_code ?? '' }}" label="Manufacture Code" placeholder="Enter Manufacture Code"  required="true"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="department_id">Department<span class="text-danger">*</span></label>
            <select name="department_id" id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected(isset($product->department_id) && $product->department_id == $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="productType">Product Type <span class="text-danger">*</span></label>
            <select name="product_type_id" id="product_type" class="productType form-control{{ $errors->has('product_type_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select Product Type</option>
                @if(isset($productTypes))
                    @foreach($productTypes as $productType)
                        <option value="{{ $productType->id }}" @selected(isset($product->product_type_id) && $product->product_type_id == $productType->id)>
                            {{ $productType->product_type_name }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('product_type_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="brand_id">Brand <span class="text-danger">*</span></label>
            <select name="brand_id" id="brand_id" class="form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(isset($product->brand_id) && $product->brand_id == $brand->id)>
                        {{ $brand->brand_name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="status" class="form-label">Season<span class="text-danger">*</span></label>
            <select name="season" id="season" class="form-control{{ $errors->has('season') ? ' is-invalid' : '' }}">
                <option value="Summer" @selected(isset($product) && $product->season === 'Summer')>Summer</option>
                <option value="Winter" @selected(isset($product) && $product->season === 'Winter')>Winter</option>
                <option value="Autumn" @selected(isset($product) && $product->season === 'Autumn')>Autumn</option>
                <option value="Spring" @selected(isset($product) && $product->season === 'Spring')>Spring</option>
            </select>
            @error('season')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="supplier_ref" value="{{ $product->supplier_ref ?? '' }}" label="Supplier Ref" placeholder="Enter Supplier Ref"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="supplier_price" type="number" step="0.01" value="{{ $product->supplier_price ?? '' }}" label="Supplier Price" placeholder="Enter Supplier Price"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="mrp" type="number" step="0.01" value="{{ $product->mrp ?? '' }}" label="MRP" placeholder="Enter Mrp" required="true"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="tax_id">Tax</label>
            <select name="tax_id" id="tax_id" class="form-control{{ $errors->has('tax_id') ? ' is-invalid' : '' }}">
                <option value="" disabled>Select Tax</option>
                @foreach($taxes as $tax)
                    <option value="{{ $tax->id }}" @selected(isset($product->tax_id) && $product->tax_id == $tax->id)
                        @selected(!isset($product->tax_id) && $tax->is_default == 1)>{{ $tax->tax }}%
                    </option>
                @endforeach
            </select>
            @error('tax_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="size_scale_id">Size Scale</label>
            <select name="size_scale_id" id="size_scale_id" class="form-control{{ $errors->has('size_scale_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select size scale</option>
                @foreach($sizeScales as $sizeScale)
                    <option value="{{ $sizeScale->id }}" @selected(isset($product->size_scale_id) && $product->size_scale_id == $sizeScale->id)>
                        {{ $sizeScale->size_scale }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="tag_id">Tag</label>
            <select name="tag_id[]" id="tag_id" class="form-control{{ $errors->has('tag_id') ? ' is-invalid' : '' }}" multiple>
                <option value="" disabled {{ old('tag_id') || (isset($product) && !count($product->tag_id)) ? 'selected' : '' }}>Select tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        @if((old('tag_id') && in_array($tag->id, old('tag_id'))) || (isset($product) && in_array($tag->id, $product->tag_id)))  selected 
                        @endif>
                        {{ $tag->tag_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="add-product-image" class="form-control">

            <div class="col-md-6 mt-2">
                @if(isset($product) && $product->image)
                    <img src="{{ asset($product->image) }}" id="preview-product" class="img-preview img-fluid w-100">
                @else
                    <img src="" id="preview-product" class="img-fluid w-100;" name="image" hidden>
                @endif
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="in_date" class="date-picker"  value="{{ $product->in_date ?? now()->format('Y-m-d') }}"  label="In Date" placeholder="Enter In Date"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="last_date" class="date-picker" value="{{ $product->last_date ?? now()->format('Y-m-d') }}" label="Last Date" placeholder="Enter Last Date"/>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active" @selected(isset($product) && $product->status === 'Active')>Active</option>
                <option value="Inactive" @selected(isset($product) && $product->status === 'Inactive')>Inactive</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label form="short_description" class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" placeholder="Enter Short Description" rows=3>{{ old('short_description', $product->short_description ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

<x-include-plugins :plugins="['chosen', 'image','datePicker' ]"></x-include-plugins>
<script>
    $(function(){
        $('#brand_id').chosen({
            width: '100%',
            placeholder_text_multiple: 'Select Brand'
        });

        $('#department_id').chosen({
            width: '100%',
        });

        $('.productType').chosen({
            width: '100%',
            placeholder_text_multiple: 'Select Product Type'
        });

        $('#tag_id').chosen({
            width: '100%',
            placeholder_text_multiple: 'Select Tag'
        });

        $('#size_scale_id').chosen({
            width: '100%',
            placeholder_text_multiple: 'Select Size Scale'
        });
    })

    $(document).ready(function() {
        let lastCode = parseInt("{{ $latestNewCode ?? '300000' }}"); // Start from 300000
        let articleCode = lastCode + 1; // Increment the code
        $('#article_code').val(String(articleCode).padStart(6, '0')); // Format to 6 digits

        @if(isset($product) && $product->article_code)
            $('#article_code').val("{{ $product->article_code }}"); // Use existing article code if in edit mode
        @endif

        $('#department_id').change(function() {
            const departmentId = $(this).val();
            const productTypeSelect = $('#product_type');

            productTypeSelect.html('<option value="" disabled selected>Select Product Type</option>');
            productTypeSelect.chosen("destroy"); // Destroy the previous instance to avoid issues

            if (departmentId) {
                $.ajax({
                    url: `/get-product-type/${departmentId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data && data.length > 0) {
                            data.forEach(function(item) {
                                if (item.product_types) {
                                    const option = new Option(item.product_types.product_type_name, item.product_type_id);
                                    productTypeSelect.append(option);
                                }
                            });
                        } else {
                            // If no product types, append a default 'Not Found' option
                            //const noOption = 'Not Found Product Types';
                            //productTypeSelect.append(noOption);
                        }

                        // Initialize Chosen plugin for better UI on the select dropdown
                        productTypeSelect.chosen({
                            width: '100%',
                            placeholder_text_multiple: 'Select Product Type'
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching product types:', error);
                    }
                });
            } else {
                productTypeSelect.chosen("destroy").html('<option value="" disabled selected>Select Product Type</option>');
                productTypeSelect.chosen({
                    width: '100%',
                    placeholder_text_multiple: 'Select Product Type'
                });
            }
        });
    });
    // Get product type on page load
    $(document).ready(function(){
        var departmentId = $('#department_id').val();
        const productTypeSelect = $('#product_type');

        productTypeSelect.html('<option value="" disabled selected>Select Product Type</option>');
        productTypeSelect.chosen("destroy"); // Destroy the previous instance to avoid issues

        if (departmentId) {
            $.ajax({
                url: `/get-product-type/${departmentId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data && data.length > 0) {
                        data.forEach(function(item) {
                            if (item.product_types) {
                                const option = new Option(item.product_types.product_type_name, item.product_type_id);
                                productTypeSelect.append(option);
                            }
                        });
                    } 
                    productTypeSelect.chosen({
                        width: '100%',
                        placeholder_text_multiple: 'Select Product Type'
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching product types:', error);
                }
            });
        } else {
            productTypeSelect.chosen("destroy").html('<option value="" disabled selected>Select Product Type</option>');
            productTypeSelect.chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Product Type'
            });
        }
    });
</script>

