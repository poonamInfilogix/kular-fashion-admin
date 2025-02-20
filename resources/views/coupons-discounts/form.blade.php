<div class="row mb-2">

    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
            <select name="type" id="type" class="form-control">
                <option value="" >Select Coupon Type</option>
                <option value="percentage">Percentage</option>
                <option value="fixed_price">Fixed Price</option>
                <option value="free_shipping">Free Shipping</option>
                <option value="buy_x">Buy X</option>
                <option value="get_y">Get Y</option>
                <option value="buy_x_for_y">Buy X for Y</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <div class="row">
                <div class="col-md-8">
                    <x-form-input name="coupon_code" id="coupon_code"  label="Coupon" required="true"  placeholder="Generate Coupon Code"/>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-secondary mt-4 generate_coupon">Generate</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label form="limit" class="form-label">Limit Usage<span class="text-danger">*</span></label>
            <select name="limit" id="limit" class="form-control">
                <option value="" >Select Limit</option>
                <option value="total">Limit number of times discount can be used in total</option>
                <option value="per_person">Times can be used per person</option>
                <option value="per_order">Number of times can be used per order</option>
            </select>
        </div>
    </div>
 
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="from_date" class="date-picker" label="From Date"  placeholder="Selece From Date"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="expire_at" class="date-picker" label="Expire Date"   placeholder="Selece End Date"/>
        </div>
    </div>
    
   
    
    <div class="col-sm-6 col-md-2">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="brand-status" class="form-control">
                <option value="Active" {{ (isset($brand) && $brand->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($brand) && $brand->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>

</div>

<div class="row mb-2">

    <h4 class="mb-1">Minimum Requirements</h4>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="min_purchase_amount" type="number"  label="Minimum Purchase Amount" placeholder="Minimum Purchase Amount"/>
        </div>
    </div>

    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="min_quantity" type="number" label="Minimum Quantity" placeholder="Minimum Quantity"/>
        </div>
    </div>
  
    <div class="row mb-2">
        <div class="col-lg-6 mb-2">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
        </div>
    </div>

</div>

<x-include-plugins :plugins="['image' ]"></x-include-plugins>
<x-include-plugins :plugins="['datePicker' ]"></x-include-plugins>
<script>
  

    $('.generate_coupon').click(function(){
        generateCouponCode();
    });


    function generateCouponCode() {
        length = 10
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // Allowed characters
        let couponCode = '';

        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            couponCode += characters.charAt(randomIndex);  // Randomly select from the characters
        }

        const couponInput = document.getElementById('coupon_code');
            // const couponCode = couponCode;
            couponInput.value = couponCode;
    }
    </script>