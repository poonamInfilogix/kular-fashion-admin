<div class="row mb-2">
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $category->name ?? '' }}" label="Category Name" placeholder="Enter Category Name"  required="true"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="category_image" id="add-category-image" class="form-control">
            @if(isset($category) && $category->image)
                <img src="{{ asset($category->image) }}" id="preview-category" class="img-preview" style="width:50px;">
            @else
                <img src="" id="preview-category" style="width:50px;" name="image" hidden>
            @endif
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
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(previewId).prop('hidden', false).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#add-category-image').change(function() {
        previewImage(this, '#preview-category');
    });
    </script>