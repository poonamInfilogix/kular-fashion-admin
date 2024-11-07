<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="brand_name" value="{{ $brand->brand_name ?? '' }}" label="Brand Name" placeholder="Enter Brand Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="brand-status" class="form-control">
                <option value="Active" {{ (isset($brand) && $brand->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($brand) && $brand->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="brand_image" id="add-brand-image" class="form-control" accept="image/*">

            <div class="row d-block d-md-none">
                <div class="col-md-3 mt-2">
                    @if(isset($brand) && $brand->image)
                        <img src="{{ asset($brand->image) }}" id="preview-brand" class="img-preview img-fluid w-50">
                    @else
                        <img src="" id="preview-brand" class="img-fluid w-50;" name="image" hidden>
                    @endif
                </div>
            </div>
        </div>
    </div>
   
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label form="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" rows=3>{{ old('description', $brand->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-sm-6 col-md-4"></div>
    <div class="col-md-4 d-none d-md-block">
        @if(isset($brand) && $brand->image)
            <img src="{{ asset($brand->image) }}" id="previewBrand" class="img-preview img-fluid w-50">
        @else
            <img src="" id="previewBrand" class="img-fluid w-50" name="image" hidden>
        @endif
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
<x-include-plugins :plugins="['image' ]"></x-include-plugins>