<div class="row mb-2">
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $category->name ?? '' }}" label="Category Name" placeholder="Enter Category Name"  required="true"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input type="file" name="image" label="Image"  id="imageInput" accept="image/*" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="categoryStatus" id="category-status" class="form-control">
                <option value="Active" {{ (isset($category) && $category->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($category) && $category->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label form="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" rows=3>{{ old('description', $category->description ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>