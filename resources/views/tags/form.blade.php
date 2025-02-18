<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $tag->name ?? '' }}" label="Tag Name" placeholder="Enter Tag Name" required="true" />
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active"  @selected(isset($tag) && $tag->status === 'Active')>Active</option>
                <option value="Inactive"  @selected(isset($tag) && $tag->status === 'Inactive')>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
