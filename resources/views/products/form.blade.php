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
            <label for="brand_id">Brand <span class="text-danger">*</span></label>
            <select name="brand_id" id="brand_id" class="form-control{{ $errors->has('brand_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select brand</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ (isset($product->brand_id) && $product->brand_id == $brand->id) ? 'selected' : '' }}>
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
            <label for="product_type_id">Product Type <span class="text-danger">*</span></label>
            <select name="product_type_id" id="product_type_id" class="form-control{{ $errors->has('product_type_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select Product Type</option>
                @foreach($productTypes as $productType)
                    <option value="{{ $productType->id }}" {{ (isset($product->product_type_id) && $product->product_type_id == $productType->id) ? 'selected' : '' }}>
                        {{ $productType->product_type_name }}
                    </option>
                @endforeach
            </select>
            @error('product_type_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="mrp" type="number" step="0.01" value="{{ $product->mrp ?? '' }}" label="Mrp" placeholder="Enter Mrp"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="supplier_price" type="number" step="0.01" value="{{ $product->supplier_price ?? '' }}" label="Supplier Price" placeholder="Enter Supplier Price"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="department_id">Department<span class="text-danger">*</span></label>
            <select name="department_id" id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select Product Type</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ (isset($product->department_id) && $product->department_id == $department->id) ? 'selected' : '' }}>
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
            <label for="status" class="form-label">Season</label>
            <select name="season" id="season" class="form-control">
                <option value="Summer" {{ (isset($product) && $product->season === 'Summer') ? 'selected' : '' }}>Summer</option>
                <option value="Winter" {{ (isset($product) && $product->season === 'Winter') ? 'selected' : '' }}>Winter</option>
                <option value="Autumn" {{ (isset($product) && $product->season === 'Autumn') ? 'selected' : '' }}>Autumn</option>
                <option value="Spring" {{ (isset($product) && $product->season === 'Spring') ? 'selected' : '' }}>Spring</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="supplier_ref" value="{{ $product->supplier_ref ?? '' }}" label="Supplier Ref" placeholder="Enter Supplier Ref"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="tax" value="{{ $product->tax_id ?? '' }}" label="Tax" placeholder="Enter Tax"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="in_date" class="date-picker" value="{{ $product->in_date ?? '' }}" label="In Date" placeholder="Enter In Date"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <x-form-input name="last_date" class="date-picker" value="{{ $product->last_date ?? '' }}" label="Last Date" placeholder="Enter Last Date"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label form="short_description" class="form-label">Short Description</label>
            <textarea name="short_description" class="form-control" placeholder="Enter Short Description" rows=3>{{ old('short_description', $product->short_description ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="add-product-image" class="form-control">

            <div class="col-md-3 mt-2">
                @if(isset($product) && $product->image)
                    <img src="{{ asset($product->image) }}" id="preview-product" class="img-preview img-fluid w-50">
                @else
                    <img src="" id="preview-product" class="img-fluid w-50;" name="image" hidden>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active" {{ (isset($sizeScale) && $sizeScale->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($sizeScale) && $sizeScale->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

<x-include-plugins :plugins="['image','datePicker' ]"></x-include-plugins>
<script>
    $(document).ready(function() {
        let lastCode = parseInt("{{ $latestNewCode ?? '300000' }}"); // Start from 300000
        let articleCode = lastCode + 1; // Increment the code
        $('#article_code').val(String(articleCode).padStart(6, '0')); // Format to 6 digits

        @if(isset($product) && $product->article_code)
            $('#article_code').val("{{ $product->article_code }}"); // Use existing article code if in edit mode
        @endif
    });
</script>

