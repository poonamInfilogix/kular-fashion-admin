<div class="row mb-2">

    
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="from_date" class="date-picker" label="From Dates" required="true" placeholder="Selece From Date"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="to_date" class="date-picker" label="To Dates" required="true"  placeholder="Selece End Date"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
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
            <label form="limit" class="form-label">Limit Usage</label>
            <select name="limit" id="limit" class="form-control">
                <option value="" >Select Limit</option>
                <option value="total">Limit number of times discount can be used in total</option>
                <option value="per_person">Times can be used per person</option>
                <option value="per_order">Number of times can be used per order</option>
            </select>
        </div>
    </div>
    

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
<x-include-plugins :plugins="['image' ]"></x-include-plugins>
<x-include-plugins :plugins="['datePicker' ]"></x-include-plugins>
