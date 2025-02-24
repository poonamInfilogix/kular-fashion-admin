<form action="{{ route('shipping-methods.update', 'royal_mail') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="royal_mail_api_endpoint" value="{{ setting('royal_mail_api_endpoint') }}"
                label="Api Base Endpoint" placeholder="Enter Royal Mail Api Endpoint" required="true" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <x-form-input name="royal_mail_api_key" value="{{ decryptData(setting('royal_mail_api_key')) }}"
                label="Api Key" placeholder="Enter Royal Mail Api Key" required="true" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-2">
            <label for="is_royal_mail_active">Status</label>
            <select name="royal_mail_status" id="royal_mail_status" class="form-control">
                <option value="1" @selected(old('royal_mail_status', setting('royal_mail_status')) === '1')>Active</option>
                <option value="0" @selected(old('royal_mail_status', setting('royal_mail_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
