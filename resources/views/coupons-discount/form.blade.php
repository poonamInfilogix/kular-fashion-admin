<div class="row">
    <div class="col-md-4 mb-2">
        <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
        <select name="type" id="type" class="form-control">
            <option value="" disabled>Select Coupon Type</option>
            <option value="Percentage" @selected(($coupon->type ?? '') === 'Percentage')>Percentage</option>
            <option value="Fixed Price" @selected(($coupon->type ?? '') === 'Fixed Price')>Fixed Price
            </option>
            <option value="Free Shipping" @selected(($coupon->type ?? '') === 'Free Shipping')>Free Shipping
            </option>
            <option value="Buy X Get Y" @selected(($coupon->type ?? '') === 'Buy X Get Y')>Buy X Get Y
            </option>
            <option value="Buy X for Y" @selected(($coupon->type ?? '') === 'Buy X for Y')>Buy X for Y
            </option>
        </select>
    </div>
    {{-- <div class="col-md-2" id="add_type">
        <x-form-input name="type_value" type="number" id="type_value" label="Percentage %" placeholder="Enter Value"
            value="{{ $coupon->value ?? '' }}" />
    </div> --}}


    <div class="col-md-1 mb-3" id="add_type">
        <x-form-input name="type_value" type="number" id="type_value" 
            label="percentage" placeholder="Amount"
            value="{{ $coupon->value ?? '' }}" />
    </div>

    <div class="col-md-1 mb-2" id="extra_field_container" style="display: none;">
        <x-form-input name="type_value2" type="number" id="type_value2" 
            label="Y" placeholder="Y"
            value="{{ $coupon->y_value ?? '' }}" />
    </div>
    <div class="col-md-4">
        <label form="limit" class="form-label">Limit Usage<span class="text-danger">*</span></label>
        <select name="usage_limit" id="limit" class="form-control">
            <option value="" disabled>Select Limit</option>
            <option value="Total Uses" @selected(($coupon->usage_limit ?? '') === 'total')>Total Uses</option>
            <option value="Per Person" @selected(($coupon->usage_limit ?? '') === 'per_person')>Per Person</option>
            <option value="Per Order" @selected(($coupon->usage_limit ?? '') === 'per_order')>Per Order</option>
        </select>
    </div>
    <div class="col-md-2" id="add_limit_val">
        <x-form-input name="limit_val" id="limit_val" type="number" label="Value" placeholder="Enter Value"
            value="{{ isset($coupon) ? $coupon->used_count : '' }}" />
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-2">
        <div class="row">
            <div class="col-md-8">
                <x-form-input name="coupon_code" id="coupon_code" value="{{ $coupon->code ?? '' }}" label="Coupon Code"
                    required="true" placeholder="Coupon Code" />
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-secondary mt-4 generate_coupon">Generate</button>
            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-2">
        <x-form-input name="min_purchase_amount" value="{{ $coupon->min_amount ?? '' }}" type="number"
            label="Minimum Purchase Amount" placeholder="Minimum Purchase Amount" />
    </div>

    <div class="col-sm-4 mb-2">
        <x-form-input name="min_items_count" value="{{ $coupon->min_items_count ?? '' }}" type="number"
            label="Minimum Quantity" placeholder="Minimum Quantity" />
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-2">
        <x-form-input name="starts_at" value="{{ isset($coupon) ? date('d-m-Y', strtotime($coupon->starts_at)) : '' }}"
            class="date-picker" label="Start Date" placeholder="Selece Start Date" />
    </div>
    <div class="col-md-3 mb-2">
        <x-form-input id="expires_at" name="expire_at" value="{{ isset($coupon) ? date('d-m-Y', strtotime($coupon->expires_at)) : '' }}"
            class="date-picker" label="Expire Date" placeholder="Selece Expire Date" />
    </div>
    {{-- <div class="col-md-3 mb-2">
        <x-form-input type="file" name="banner_path" id="banner_path" class="form-control" label="Image"
            accept="image/*" onchange="previewImage(event, 'banner')" />
    </div> --}}

    <div class="col-md-3 mb-2">
        <x-form-input type="file" name="banner_path" id="banner_path" class="form-control" label="Image"
            accept="image/*" onchange="previewImage(event, 'banner')" />
        <img id="preview-banner" src="" style="display: none; max-width: 100%; margin-top: 10px;" />
    </div>
    
    <div class="col-md-3 mb-2">
        <label for="coupon-status" class="form-label">Status</label>
        <select name="status" id="coupon-status" class="form-control">
            <option value="1" @selected(($coupon->is_active ?? 1) == 1)>Active</option>
            <option value="0" @selected(($coupon->is_active ?? 1) == 0)>Inactive</option>
        </select>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-6 mb-2">
        <label for="coupon_desc" class="form-label">Description</label>
        <textarea name="coupon_desc" id="coupon_desc" class="form-control" rows="2">{{ $coupon->description ?? '' }}</textarea>
    </div>
    <div class="col-md-3">
        @if (isset($coupon) && $coupon->banner_path)
            <img src="{{ asset($coupon->banner_path) }}" id="preview-banner" class="img-preview img-fluid">
        @else
            <img src="" id="preview-banner" class="img-preview img-fluid w-150" hidden>
        @endif
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

<x-include-plugins :plugins="['image', 'imagePreview', 'datePicker', 'contentEditor']"></x-include-plugins>

<script>
    $(document).ready(function() {
        $('.generate_coupon').click(function() {
            generateCouponCode();
        });

        function generateCouponCode() {
            let length = 10;
            const characters =
                'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // Allowed characters
            let couponCode = '';

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                couponCode += characters.charAt(randomIndex);
            }

            $('#coupon_code').val(couponCode); // Use jQuery to set the input value
        }
    });

    $(document).ready(function(){
    $('#type').on('change', function(){
        var selectedType = $(this).val();
        var newLabel = '%';
        var newPlaceholder = 'Percentage';
        
        // Hide extra field container by default
        $('#extra_field_container').hide();
        
        // Conditions to update the primary field and extra field if needed
        if(selectedType === 'Percentage'){
            newLabel = 'Percentage';
            newPlaceholder = 'Percentage';
            $('#add_type').show();
        } else if(selectedType === 'Fixed Price'){
            newLabel = 'Amount';
            newPlaceholder = 'Amount';
            $('#add_type').show();
        } else if(selectedType === 'Free Shipping'){
            $('#add_type').hide();
        } else if(selectedType === 'Buy X Get Y' || selectedType === 'Buy X for Y'){
            newLabel = 'X';
            newPlaceholder = 'X'; 
            // $('#type_value')
            // $('#type_value2')
            $('#add_type').show();
            $('#extra_field_container').show(); // Show the extra Y value field
        } else {
            $('#add_type').show();
        }
        
        // Update the label and placeholder of the primary field if it is visible
        if ($('#add_type').is(':visible')) {
            $('label[for="type_value"]').text(newLabel);
            $('#type_value').attr('placeholder', newPlaceholder);
        }
    });

    // (Optional) Trigger change on page load to set the correct display if editing an existing coupon
    $('#type').trigger('change');
});



</script>
