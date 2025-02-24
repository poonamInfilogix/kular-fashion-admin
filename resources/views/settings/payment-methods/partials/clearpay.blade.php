<form action="{{ route('payment-methods.update', 'clearpay') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="clearpay_merchant_id" value="{{ setting('clearpay_merchant_id') }}"
                label="Merchant ID" placeholder="Merchant ID" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="clearpay_api_key" value="{{ decryptData(setting('clearpay_api_key')) }}"
                label="Api Key" placeholder="Api Key" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="clearpay_secret_key" value="{{ decryptData(setting('clearpay_api_key')) }}"
                label="Secret Key" placeholder="Api Key" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <label for="clearpay_environment">Environment</label>
            <select name="clearpay_environment" id="clearpay_environment" class="form-control">
                <option value="sandbox" @selected(old('clearpay_environment', setting('clearpay_environment')) === 'sandbox')>Sandbox</option>
                <option value="production" @selected(old('clearpay_environment', setting('clearpay_environment')) === 'production')>Production</option>
            </select>
        </div>
        
        <div class="col-md-6 mb-2">
            <label for="clearpay_status">Status</label>
            <select name="clearpay_status" id="clearpay_status" class="form-control">
                <option value="1" @selected(old('clearpay_status', setting('clearpay_status')) === '1')>Active</option>
                <option value="0" @selected(old('clearpay_status', setting('clearpay_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
