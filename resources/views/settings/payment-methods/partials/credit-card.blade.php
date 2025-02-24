<form action="{{ route('payment-methods.update', 'credit_card') }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="method" value="credit_card">

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="credit_card_publishable_key" value="{{ decryptData(setting('credit_card_publishable_key')) }}"
                label="Publishable Key" placeholder="Publishable Key" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="credit_card_secret_key" value="{{ decryptData(setting('credit_card_secret_key')) }}"
                label="Secret Key" placeholder="Secret Key" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <label for="credit_card_environment">Environment</label>
            <select name="credit_card_environment" id="credit_card_environment" class="form-control">
                <option value="sandbox" @selected(old('credit_card_environment', setting('credit_card_environment')) === 'sandbox')>Sandbox</option>
                <option value="production" @selected(old('credit_card_environment', setting('credit_card_environment')) === 'production')>Production</option>
            </select>
        </div>

        <div class="col-md-6 mb-2">
            <label for="credit_card_status">Status</label>
            <select name="credit_card_status" id="credit_card_status" class="form-control">
                <option value="1" @selected(old('credit_card_status', setting('credit_card_status')) === '1')>Active</option>
                <option value="0" @selected(old('credit_card_status', setting('credit_card_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
