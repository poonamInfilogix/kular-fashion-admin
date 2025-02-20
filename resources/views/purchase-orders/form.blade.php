<div class="row mb-2">
    <div class="col-sm-6 col-md-2 mb-3">
        <x-form-input name="supplier_order_no" value="" label="Supplier Order No" placeholder="Supplier Order No"
            required="true" />
    </div>
    <div class="col-sm-6 col-md-2 mb-3">
        <x-form-input name="supplier_order_date" class="date-picker" value="" label="Supplier Order Date"
            placeholder="Supplier Order Date" required="true" />
    </div>
    <div class="col-sm-6 col-md-2 mb-3">
        <x-form-input name="delivery_date" class="date-picker" label="Delivery Date" placeholder="Delivery Date"
            required="true" />
    </div>

    <div class="col-sm-6 col-md-2 mb-3">
        <label for="supplier">Supplier Name <span class="text-danger">*</span></label>
        <select name="supplier" id="supplier" @class(['form-control', 'is-invalid' => $errors->has('supplier')])>
            <option value="" disabled selected>Select Supplier</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
            @endforeach
        </select>
        @error('supplier')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

<div id="product-fields-container">
    <div class="product-field-group mb-3 border p-3" data-product-index="0">
        <div class="row">
            <div class="col-sm-6 col-md-2 mb-3">
                <x-form-input name="products[0][product_code]" label="Product Code" placeholder="Enter Product Code"
                    required />
            </div>
            <div class="col-sm-6 col-md-2 mb-3">
                <label for="product_type">Product Type<span class="text-danger">*</span></label>
                <select name="products[0][product_type]" @class([
                    'form-control',
                    'is-invalid' => $errors->has('products.0.product_type'),
                ])>
                    <option value="" disabled selected>Select Product Type</option>
                    @foreach ($productTypes as $productType)
                        <option value="{{ $productType->id }}">
                            {{ $productType->name }}</option>
                    @endforeach
                </select>

                @error('products.0.product_type')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-6 col-md-2 mb-3">
                <label for="size_scale">Size Scale<span class="text-danger">*</span></label>
                <select name="products[0][name]" id="size_scale" @class([
                    'form-control size-scale-dropdown',
                    'is-invalid' => $errors->has('products.0.name'),
                ])>
                    <option value="" disabled selected>Select size scale</option>
                    @foreach ($sizeScales as $sizeScale)
                        <option value="{{ $sizeScale->id }}" @selected(old('size_scale_id', $product->size_scale_id ?? '') == $sizeScale->id)>
                            {{ $sizeScale->name }}

                            @if (isset($sizeScale->sizes))
                                ({{ $sizeScale->sizes->first()->size }} -
                                {{ $sizeScale->sizes->last()->size }})
                            @endif
                        </option>
                    @endforeach
                </select>

                @error('products.0.name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-sm-6 col-md-2 mb-3">
                <label for="min_size_id">Min Size<span class="text-danger">*</span></label>
                <select name="products[0][min_size]" @class([
                    'form-control min-size-dropdown',
                    'is-invalid' => $errors->has('products.0.min_size'),
                ])>
                    <option value="" disabled selected>Select Min Size</option>
                </select>

                @error('products.0.min_size')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-6 col-md-2 mb-3">
                <label for="max_size_id">Max Size<span class="text-danger">*</span></label>
                <select name="products[0][max_size]" @class([
                    'form-control max-size-dropdown',
                    'is-invalid' => $errors->has('products.0.max_size'),
                ])>
                    <option value="" disabled selected>Select Max Size</option>
                </select>

                @error('products.0.max_size')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-6 col-md-2">
                <x-form-input name="products[0][delivery_date]" label="Delivery Date" class="date-picker"
                    placeholder="Enter Delivery Date" required />
            </div>
            <div class="col-sm-6 col-md-2 mb-3">
                <x-form-input name="products[0][price]" label="Price" placeholder="Enter Price" required />
            </div>
            <div class="col-sm-6 col-md-3 mb-3">
                <x-form-input name="products[0][short_description]" label="Short Description"
                    placeholder="Enter Short Description" required />
            </div>
            <div class="col-sm-6 col-md-3 mt-4">
                <button type="button" class="btn btn-primary add-product-variant" disabled data-toggle="modal"
                    data-target="#variantModal"><i class="fas fa-plus"></i>
                    Variant</button>
                <button type="button" class="btn btn-secondary copy-product" disabled><i class="fas fa-copy"></i></button>
                <button type="button" class="btn btn-danger remove-product-field"><i
                        class="fas fa-trash-alt"></i></button>
            </div>
        </div>

        <div class="variants-container"></div>
    </div>
</div>
<button type="button" id="add-product-field" class="btn btn-primary">Add New Product</button>