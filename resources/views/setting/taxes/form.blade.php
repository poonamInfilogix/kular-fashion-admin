<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input type="number" name="tax" value="{{ old('tax', $tax->tax ?? '') }}" label="Tax (in %)" placeholder="Enter Tax" required="true" />
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="tax_status" class="form-label">Status</label>
            <input type="checkbox" id="tax_status" name="status" class="form-check-input" value="1" @checked(old('status', $tax->status ?? 0) == 1) onclick="statusClick(this);" />
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="default" class="form-label">Default</label>
            <input type="checkbox" id="default" name="default" class="form-check-input" value="1" @checked(old('default', $tax->is_default ?? 0) == 1) onclick="defaultClick(this);" />
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

<script>
    function statusClick(e) {
        e.value = e.checked ? 1 : 0;
        $('#tax_status').val(e.value);
    }

    function defaultClick(e) {
        e.value = e.checked ? 1 : 0;
        $('#default').val(e.value);
    }
</script>
