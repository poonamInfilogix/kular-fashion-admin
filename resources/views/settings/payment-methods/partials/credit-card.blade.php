<form action="{{ route('payment-methods.update', 'credit_card') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="stripe_publishable_key" value="{{ decryptData(setting('stripe_publishable_key')) }}"
                label="Publishable Key" placeholder="Publishable Key" required="true" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="stripe_secret_key" value="{{ decryptData(setting('stripe_secret_key')) }}"
                label="Secret Key" placeholder="Secret Key" required="true" />
        </div>
    </div>

    <div class="col-md-6 mb-2">
        <label for="stripe_environment">Environment</label>
        <select name="stripe_environment" id="stripe_environment" class="form-control">
            <option value="sandbox" @selected(old('stripe_environment', setting('stripe_environment')) === 'sandbox')>Sandbox</option>
            <option value="production" @selected(old('stripe_environment', setting('stripe_environment')) === 'production')>Production</option>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <label for="stripe_status">Status</label>
            <select name="stripe_status" id="stripe_status" class="form-control">
                <option value="1" @selected(old('stripe_status', setting('stripe_status')) === '1')>Active</option>
                <option value="0" @selected(old('stripe_status', setting('stripe_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
