<form action="{{ route('payment-methods.update', 'gift_voucher') }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="method" value="gift_voucher">

    <div class="row">
        <div class="col-md-6 mb-2">
            <label for="gift_voucher_status">Status</label>
            <select name="gift_voucher_status" id="gift_voucher_status" class="form-control">
                <option value="1" @selected(old('gift_voucher_status', setting('gift_voucher_status')) === '1')>Active</option>
                <option value="0" @selected(old('gift_voucher_status', setting('gift_voucher_status')) === '0')>Inactive</option>
            </select>
        </div>
    </div>

    <button class="btn btn-primary mt-1">Save</button>
</form>
