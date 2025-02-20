<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $sizeScale->name ?? '' }}" label="Size Scale" placeholder="Enter Size Scale"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="is_default" class="form-label">Default</label>
            <select name="is_default" id="is_default" class="form-control">
                <option value="0" @selected($sizeScale->is_default ?? '0' === '0')>No</option>
                <option value="1" @selected($sizeScale->is_default ?? '' === '1')>Yes</option>
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="size-scale-status" class="form-label">Status</label>
            <select name="status" id="size-scale-status" class="form-control">
                <option value="Active" @selected(($sizeScale->status ?? '') === 'Active')>Active</option>
                <option value="Inactive" @selected(($sizeScale->status ?? '') === 'Inactive')>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

