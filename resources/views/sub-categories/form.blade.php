<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="category_id">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (isset($subCategory->category_id) && $subCategory->category_id == $category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="sub_category_name" value="{{ $subCategory->sub_category_name ?? '' }}" label="Sub Category Name" placeholder="Enter Sub Category Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="sub_category_image" id="add-subCategory-image" class="form-control">

            <div class="row d-block d-md-none">
                <div class="col-md-3 mt-2">
                    @if(isset($subCategory) && $subCategory->image)
                        <img src="{{ asset($subCategory->image) }}" id="preview-subCategory" class="img-preview img-fluid w-50">
                    @else
                        <img src="" id="preview-subCategory" class="img-fluid w-50;" name="image" hidden>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="subCategoryStatus" id="category-status" class="form-control">
                <option value="Active" {{ (isset($subCategory) && $subCategory->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($subCategory) && $subCategory->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label form="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" rows=3>{{ old('description', $subCategory->description ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-sm-6 col-md-3"></div>

    <div class="col-sm-6 col-md-3 d-none d-md-block">
        @if(isset($subCategory) && $subCategory->image)
            <img src="{{ asset($subCategory->image) }}" id="preview-sub-category" class="img-preview img-fluid w-50">
        @else
            <img src="" id="preview-sub-category" class="img-fluid w-50;" name="image" hidden>
        @endif
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
<x-include-plugins :plugins="['image' ]"></x-include-plugins>