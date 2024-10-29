<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="size" value="{{ $size->size ?? '' }}" label="Size" placeholder="Enter Size"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="new_code" value="{{ $size->new_code ?? '' }}" label="New Code" placeholder="Enter New Code"  required="true" readonly/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="old_code" value="{{ $size->old_code ?? '' }}" label="Old Code" placeholder="Enter Old Code" required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
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
<script>
    $(document).ready(function() {
        let lastCode = parseInt("{{ $latestNewCode ?? '0' }}"); // Get latest new code from backend
        let newCode = lastCode + 1; // Increment the code
        $('#new_code').val(String(newCode).padStart(3, '0')); // Format to 3 digits

        @if(isset($size) && $size->new_code)
            $('#new_code').val("{{ $size->new_code }}"); // Use existing new code if in edit mode
        @endif
    });
</script>

