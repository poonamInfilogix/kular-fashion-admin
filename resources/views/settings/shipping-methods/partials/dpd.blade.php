<form action="{{ route('shipping-methods.update', 'dpd') }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="method" value="dpd">
    
    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="dpd_api_endpoint" value="{{ setting('dpd_api_endpoint') }}"
                label="Api Base Endpoint" placeholder="Enter DPD Api Endpoint" required="true" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="dpd_api_token" value="{{ decryptData(setting('dpd_api_token')) }}"
                label="Api Token" placeholder="Enter DPD Api Token" required="true" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <label for="dpd_status">Status</label>
            <select name="dpd_status" id="dpd_status" class="form-control">
                <option value="1" @selected(old('dpd_status', setting('dpd_status'))==1)>Active</option>
                <option value="0" @selected(old('dpd_status', setting('dpd_status'))==0)>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>