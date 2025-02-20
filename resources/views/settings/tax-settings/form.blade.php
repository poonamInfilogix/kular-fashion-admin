<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input type="number" name="tax" value="{{ old('tax', $tax->tax ?? '') }}" label="Tax (in %)" placeholder="Enter Tax" required="true" />
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="default" class="form-label">Default</label>
            <select name="default" id="default" class="form-control">
                <option value="" disabled selected>Select Default</option>
                <option value="0" @selected($tax->is_default ?? 0 === 0)>No</option>
                <option value="1" @selected($tax->is_default ?? '' === 1)>Yes</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="1" @selected($tax->status ?? '1' === 1)>Active</option>
                <option value="0" @selected($tax->status ?? '' === 0)>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
