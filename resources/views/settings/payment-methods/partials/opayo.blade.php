<form action="{{ route('payment-methods.update', 'opayo') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="opayo_vendor_name" value="{{ setting('opayo_vendor_name') }}"
                label="Vendor Name" placeholder="Enter Royal Mail Api Endpoint" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="opayo_api_key" value="{{ decryptData(setting('opayo_api_key')) }}"
                label="Api Key" placeholder="Enter Royal Mail Api Key" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="opayo_encryption_key" value="{{ decryptData(setting('opayo_encryption_key')) }}"
                label="Encryption Key" placeholder="Enter Royal Mail Api Key" required="true" />
        </div>
    
        <div class="col-md-6 mb-2">
            <label for="opayo_environment">Environment</label>
            <select name="opayo_environment" id="opayo_environment" class="form-control">
                <option value="sandbox" @selected(old('opayo_environment', setting('opayo_environment')) === 'sandbox')>Sandbox</option>
                <option value="production" @selected(old('opayo_environment', setting('opayo_environment')) === 'production')>Production</option>
            </select>
        </div>
        
        <div class="col-md-6 mb-2">
            <label for="opayo_status">Status</label>
            <select name="opayo_status" id="opayo_status" class="form-control">
                <option value="1" @selected(old('opayo_status', setting('opayo_status')) === '1')>Active</option>
                <option value="0" @selected(old('opayo_status', setting('opayo_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
