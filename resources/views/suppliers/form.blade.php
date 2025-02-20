<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="short_code" value="{{ $supplier->short_code ?? '' }}" label="Short Code" placeholder="Enter Short Code"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="supplier_name" value="{{ $supplier->supplier_name ?? '' }}" label="Supplier Name" placeholder="Enter Supplier Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="supplier_ref" value="{{ $supplier->supplier_ref ?? '' }}" label="Supplier Ref" placeholder="Enter Supplier Ref"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input type="number" name="telephone" value="{{ $supplier->telephone ?? '' }}" label="Telephone" placeholder="Enter Telephone"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input type="email" name="email" value="{{ $supplier->email ?? '' }}" label="Email" placeholder="Enter Email"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="address_line_1" value="{{ $supplier->address_line_1 ?? '' }}" label="Address Line 1" placeholder="Enter Address Line 1"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="address_line_2" value="{{ $supplier->address_line_2 ?? '' }}" label="Address Line 2" placeholder="Enter Address Line 2"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="department_id">Country</label>
            <select name="country_id" id="country_id" class="form-control{{ $errors->has('country_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ (isset($supplier->country_id) && $supplier->country_id == $country->id) ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="state_id">State</label>
            <select name="state_id" id="state_id" class="form-control{{ $errors->has('state_id') ? ' is-invalid' : '' }}">
                <option value="" disabled selected>Select state</option>
                @if(isset($states))
                    @foreach($states as $state)
                        <option value="{{ $state->id }}" {{ (isset($supplier->state_id) && $supplier->state_id == $state->id) ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="city" value="{{ $supplier->city ?? '' }}" label="City" placeholder="Enter City"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input type="number" name="postal_code" value="{{ $supplier->postal_code ?? '' }}" label="Postal Code" placeholder="Enter Postal Code"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="supplier-status" class="form-control">
                <option value="Active" {{ (isset($supplier) && $supplier->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($supplier) && $supplier->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

<x-include-plugins :plugins="['chosen', 'country']"></x-include-plugins>
@push('scripts')
<script>
    $(function(){
        $('#country_id').chosen({
            width: '100%',
            placeholder_text_multiple: 'Select Country'
        });
    })
</script>
@endpush
