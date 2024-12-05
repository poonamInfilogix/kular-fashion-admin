<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="reason" value="{{ old('name', $changePriceReason->name ?? '') }}" label="Reason" placeholder="Enter Reason" required="true" />
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Save</button>
    </div>
</div>
