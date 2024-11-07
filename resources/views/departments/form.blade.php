<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $department->name ?? '' }}" label="Department Name" placeholder="Enter Department Name"  required="true"/>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="department-status" class="form-control">
                <option value="Active" {{ (isset($department) && $department->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($department) && $department->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" id="add-department-image" class="form-control" accept="image/*">

            <div class="row d-block d-md-none">
                <div class="col-md-3 mt-2">
                    @if(isset($department) && $department->image)
                        <img src="{{ asset($department->image) }}" id="preview-department" class="img-preview img-fluid w-50">
                    @else
                        <img src="" id="preview-department" class="img-fluid w-50;" name="image" hidden>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label form="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" placeholder="Enter Description" rows=3>{{ old('description', $department->description ?? '') }}</textarea>
        </div>
    </div>
    <div class="col-sm-6 col-md-4"></div>
    <div class="col-md-4 d-none d-md-block">
        @if(isset($department) && $department->image)
            <img src="{{ asset($department->image) }}" id="previewDepartment" class="img-preview img-fluid w-50">
        @else
            <img src="" id="previewDepartment" class="img-fluid w-50" name="image" hidden>
        @endif
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
<x-include-plugins :plugins="['image' ]"></x-include-plugins>