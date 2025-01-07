<div class="row mb-2">
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $branch->name ?? '' }}" label="Branch Name" placeholder="Enter Branch Name"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="short_name" value="{{ $branch->short_name ?? ''}}" label="Branch Short Name" placeholder="Enter Short Name"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="email" value="{{ $branch->email ?? ''}}" label="Email" placeholder="Enter Email"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="contact" value="{{ $branch->contact ?? ''}}" label="Contact" placeholder="Enter Contact"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <x-form-input name="location" value="{{ $branch->location ?? ''}}" label="Location" placeholder="Enter Location"  required="true" />
        </div>
    </div>
    <div class="col-md-4">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Active" @isset($branch) @selected($branch->status == 'Active') @endisset>Active</option>
            <option value="Inactive" @isset($branch) @selected($branch->status == 'Inactive') @endisset>Inactive</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>Order Receipt Header</label>
        <textarea name="order_receipt_header" id="order_receipt_header" class="form-control" placeholder="Enter order receipt header">{{ isset($branch) ? $branch->order_receipt_header : $defaultHeader }}</textarea>
    </div>

    <div class="col-md-4">
        <label>Order Receipt Footer</label>
        <textarea name="order_receipt_footer" id="order_receipt_footer" class="form-control" placeholder="Enter order receipt Footer">{{ isset($branch) ? $branch->order_receipt_footer : $defaultFooter }}</textarea>
    </div>
</div>
<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>