<form action="{{ route('payment-methods.update', 'klarna') }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="method" value="klarna">

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="klarna_merchant_id" value="{{ decryptData(setting('klarna_merchant_id')) }}"
                label="Merchant ID" placeholder="Merchant ID" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="klarna_api_username" value="{{ setting('klarna_api_username') }}"
                label="API Username" placeholder="API Username" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="klarna_api_password" value="{{ decryptData(setting('klarna_api_password')) }}"
                label="API Password" placeholder="API Password" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="klarna_client_id" value="{{ decryptData(setting('klarna_client_id')) }}"
                label="Client ID" placeholder="Client ID" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="klarna_api_key" value="{{ decryptData(setting('klarna_api_key')) }}"
                label="API Key" placeholder="API Key" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <label for="klarna_environment">Environment</label>
            <select name="klarna_environment" id="klarna_environment" class="form-control">
                <option value="sandbox" @selected(old('klarna_environment', setting('klarna_environment')) === 'sandbox')>Sandbox</option>
                <option value="production" @selected(old('klarna_environment', setting('klarna_environment')) === 'production')>Production</option>
            </select>
        </div>
        
        <div class="col-md-6 mb-2">
            <label for="klarna_status">Status</label>
            <select name="klarna_status" id="klarna_status" class="form-control">
                <option value="1" @selected(old('klarna_status', setting('klarna_status')) === '1')>Active</option>
                <option value="0" @selected(old('klarna_status', setting('klarna_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
