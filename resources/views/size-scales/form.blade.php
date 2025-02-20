<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $sizeScale->name ?? '' }}" label="Size Scale" placeholder="Enter Size Scale"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
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

