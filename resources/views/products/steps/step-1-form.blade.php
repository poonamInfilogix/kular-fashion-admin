<div class="row mb-2">
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="article_code" id="article_code" value="{{ $product->article_code ?? '' }}" label="Article Code" placeholder="Enter Article Code"  required="true" readonly="{{ $isEditing ?? false }}"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="manufacture_code" value="{{ $product->manufacture_code ?? request()->get('mfg_code') }}" label="Manufacture Code" placeholder="Enter Manufacture Code"  required="true" readonly="{{$isEditing ?? false}}" />
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="department_id">Department<span class="text-danger">*</span></label>
            <select name="department_id" id="department_id" @disabled($isEditing ?? false) @class(['form-control', 'is-invalid' => $errors->has('department_id')])>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @selected(($product->department_id ?? '') == $department->id)>
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
            <select name="product_type_id" id="product_type" @disabled($isEditing ?? false) @class(["productType form-control", 'is-invalid' => $errors->has('product_type_id')])>
                <option value="" disabled>Select Product Type</option>
                @if(isset($productTypes))
                    @foreach($productTypes as $productType)
                        <option value="{{ $productType->id }}" @selected(old('product_type_id', $product->product_type_id ?? '') == $productType->id)>
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
            <select name="brand_id" id="brand_id" @disabled($isEditing ?? false) class="form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" data-margin="{{ $brand->margin }}" @selected(old('brand_id', $product->brand_id ?? '') == $brand->id)>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            @error('brand_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <input type="hidden" id="brand_margin" value="{{ $product->brand->margin ?? 50 }}">
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="supplier_ref" value="{{ $product->supplier_ref ?? '' }}" readonly="{{ $isEditing ?? false }}" label="Supplier Ref" placeholder="Enter Supplier Ref"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="mrp" type="number" step="0.01" value="{{ $product->mrp ?? '' }}" label="MRP" placeholder="Enter MRP" required="true"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="tag_id">Tag</label>
            <select name="tag_id[]" id="tag_id" @disabled($isEditing ?? false) class="form-control{{ $errors->has('tag_id') ? ' is-invalid' : '' }}" multiple>
                <option value="" disabled>Select tag</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" @selected(old('tag_id') && in_array($tag->id, old('tag_id')))>
                        {{ $tag->tag_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="supplier_price" type="number" step="0.01" value="{{ $product->supplier_price ?? '' }}" label="Supplier Price" placeholder="Enter Supplier Price" required="true"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="size_scale_id">Size Scale<span class="text-danger">*</span></label>
            <select name="size_scale_id" @disabled($isEditing ?? false) id="size_scale_id" @class(["form-control", "is-invalid" => $errors->has('size_scale_id')])>
                <option value="" disabled selected>Select size scale</option>
                @foreach($sizeScales as $sizeScale)
                    <option value="{{ $sizeScale->id }}" @selected(old('size_scale_id', $product->size_scale_id ?? '') == $sizeScale->id)>
                        {{ $sizeScale->size_scale }} 

                        @if(isset($sizeScale->sizes))
                            ({{$sizeScale->sizes->first()->size}} - {{$sizeScale->sizes->last()->size}})
                        @endif
                    </option>
                @endforeach
            </select>
            @error('size_scale_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="short_description" value="{{ $product->short_description ?? '' }}" label="Short Description" placeholder="Enter Short Description"  required="true"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="add-product-image" class="form-control" accept="image/*">

            <div class="col-md-12 mt-2">
                @if(isset($product->image_path) || isset($product->image))
                    <img src="{{ asset($product->image_path ?? $product->image) }}" id="preview-product" class="img-preview img-fluid w-100" onerror="this.onerror=null; this.src='{{ asset(setting('default_product_image')) }}';">
                @else
                    <img src="{{ asset(setting('default_product_image')) }}" id="preview-product" class="img-fluid w-100;" name="image">
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="status" class="form-label">Season</label>
            <select name="season" id="season" @disabled($isEditing ?? false) @class(["form-control", "is-invalid" => $errors->has('season')])>
                <option value="Summer" @selected(($product->season ?? setting('default_season')) === 'Summer')>Summer</option>
                <option value="Winter" @selected(($product->season ?? setting('default_season')) === 'Winter')>Winter</option>
                <option value="Autumn" @selected(($product->season ?? setting('default_season')) === 'Autumn')>Autumn</option>
                <option value="Spring" @selected(($product->season ?? setting('default_season')) === 'Spring')>Spring</option>
            </select>
            @error('season')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="tax_id">Tax</label>
            <select name="tax_id" id="tax_id" @class(["form-control", "is-invalid" => $errors->has('tax_id')])>
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
            <x-form-input name="in_date" class="date-picker" disabled="{{ $isEditing ?? false }}" value="{{ $product->in_date ?? now()->format('Y-m-d') }}"  label="In Date" placeholder="Enter In Date"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="last_date" class="date-picker" disabled="{{ $isEditing ?? false }}" value="{{ $product->last_date ?? now()->format('Y-m-d') }}" label="Last Date" placeholder="Enter Last Date"/>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active" @selected(($product->status ?? '') === 'Active')>Active</option>
                <option value="Inactive" @selected(($product->status ?? '') === 'Inactive')>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Coninue</button>
    </div>
</div>

<x-include-plugins :plugins="['chosen', 'image','datePicker']"></x-include-plugins>
@push('scripts')
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
            placeholder_text_multiple: 'Select Tag'
        });
        
    })

    function refreshProductTypeDropdown(departmentId){
            const productTypeSelect = $('#product_type');

            productTypeSelect.html('<option value="" disabled selected>Select Product Type</option>');
            productTypeSelect.chosen("destroy");

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

                        // After appending options, ensure the previously selected option is set
                        const selectedProductTypeId = "{{ old('product_type_id', $product->product_type_id ?? '') }}";
                        if (selectedProductTypeId) {
                            productTypeSelect.val(selectedProductTypeId);
                        }

                        productTypeSelect.chosen({
                            width: '100%',
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
                });
            }
        }


    $(document).ready(function() {
        @if(empty($product->article_code))
            let lastCode = parseInt("{{ $latestNewCode ?? '300000' }}"); // Start from 300000
            let articleCode = lastCode + 1; // Increment the code
            $('#article_code').val(String(articleCode).padStart(6, '0'));
        @endif

        $('#department_id').change(function() {
            const departmentId = $(this).val();
            refreshProductTypeDropdown(departmentId);
        });

        function updateSupplierPrice() {
            var margin = parseFloat($('#brand_margin').val());
            console.log(margin);
            var mrp = parseFloat($('#mrp').val());

            if (!isNaN(mrp) && margin >= 0) {
                var supplierPrice = mrp * (1 - margin / 100);
                $('#supplier_price').val(supplierPrice.toFixed(2));
            } else {
                $('#supplier_price').val('');
            }
        }

        $('#brand_id').change(function() {
            var selectedBrand = $(this).find('option:selected');
            var margin = selectedBrand.data('margin');

            $('#brand_margin').val(margin);
            updateSupplierPrice();
        });

        $('#mrp').on('input', function() {
            updateSupplierPrice(); // Recalculate supplier price when MRP is changed
        });

        if ($('#brand_id').val()) {
            updateSupplierPrice();
        }
    });

    // Get product type on page load
    $(document).ready(function(){
        var departmentId = $('#department_id').val();
        refreshProductTypeDropdown(departmentId);
    });
</script>
@endpush