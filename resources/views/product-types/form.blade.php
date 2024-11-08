<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="department_id">Department <span class="text-danger">*</span></label>
            <select name="department_id[]" id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" multiple>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" >
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="product_type_name" value="{{ $productType->product_type_name ?? '' }}" label="Product Type" placeholder="Enter Product Type"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="add-productType-image" class="form-control" accept="image/*">

            <div class="row d-block d-md-none">
                <div class="col-md-3 mt-2">
                    @if(isset($productType) && $productType->image)
                        <img src="{{ asset($productType->image) }}" id="preview-productType" class="img-preview img-fluid w-50">
                    @else
                        <img src="" id="preview-productType" class="img-fluid w-50;" name="image" hidden>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="product-type-status" class="form-control">
                <option value="Active" {{ (isset($productType) && $productType->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($productType) && $productType->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label form="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" rows=3>{{ old('description', $productType->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-sm-6 col-md-3"></div>

    <div class="col-sm-6 col-md-3 d-none d-md-block">
        @if(isset($productType) && $productType->image)
            <img src="{{ asset($productType->image) }}" id="preview-product-type" class="img-preview img-fluid w-50">
        @else
            <img src="" id="preview-product-type" class="img-fluid w-50;" name="image" hidden>
        @endif
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
<x-include-plugins :plugins="['chosen','image' ]"></x-include-plugins>
<script>
    $(function(){
        $('#department_id').chosen({
            width: '100%',
            placeholder_text_multiple: 'Select Department'
        });
    });
</script>    