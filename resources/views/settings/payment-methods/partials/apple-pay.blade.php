<form action="{{ route('payment-methods.update', 'apple_pay') }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="method" value="dpd">

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="apple_pay_merchant_identifier" value="{{ setting('apple_pay_merchant_identifier') }}"
                label="Merchant Identifier" placeholder="Merchant Identifier" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="apple_pay_merchant_name" value="{{ setting('apple_pay_merchant_name') }}"
                label="Merchant Name" placeholder="Merchant Name" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="apple_pay_merchant_id" value="{{ setting('apple_pay_merchant_id') }}"
                label="Merchant ID" placeholder="Merchant ID" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input type="file" name="apple_pay_merchant_certificate" label="Merchant Certificate"
                required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input type="file" name="apple_pay_merchant_private_key" label="Merchant Private Key"
                required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <x-form-input name="apple_pay_certificate_password" value="{{ setting('apple_pay_certificate_password') }}"
                label="Certificate Password" placeholder="Certificate Password" required="true" />
        </div>

        <div class="col-md-6 mb-2">
            <label for="apple_pay_environment">Environment</label>
            <select name="apple_pay_environment" id="apple_pay_environment" class="form-control">
                <option value="sandbox" @selected(old('apple_pay_environment', setting('apple_pay_environment')) === 'sandbox')>Sandbox</option>
                <option value="production" @selected(old('apple_pay_environment', setting('apple_pay_environment')) === 'production')>Production</option>
            </select>
        </div>
        
        <div class="col-md-6 mb-2">
            <label for="apple_pay_status">Status</label>
            <select name="apple_pay_status" id="apple_pay_status" class="form-control">
                <option value="1" @selected(old('apple_pay_status', setting('apple_pay_status')) === '1')>Active</option>
                <option value="0" @selected(old('apple_pay_status', setting('apple_pay_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
