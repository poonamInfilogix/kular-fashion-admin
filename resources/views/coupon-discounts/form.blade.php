<div class="card">
    <div class="card-body">
        <h4 class="card-title">Basic Detail</h4>
        <div class="row">
            <div class="col-md-4 mb-2">
                <label for="type">Type<span class="text-danger">*</span></label>
                <select name="type" id="type" class="form-control">
                    <option value="" disabled selected>Select Coupon Type</option>
                    <option value="percentage" @selected(($coupon->type ?? '') === 'percentage')>Percentage</option>
                    <option value="fixed" @selected(($coupon->type ?? '') === 'fixed')>Fixed Price</option>
                    <option value="free_shipping" @selected(($coupon->type ?? '') === 'free_shipping')>Free Shipping</option>
                    <option value="buy_x_get_y" @selected(($coupon->type ?? '') === 'buy_x_get_y')>Buy X Get Y</option>
                    <option value="buy_x_for_y" @selected(($coupon->type ?? '') === 'buy_x_for_y')>Buy X for Y</option>
                </select>
            </div>

            <div class="col-md-4 mb-2">
                <div class="row">
                    <div class="col-md-8">
                        <x-form-input name="code" id="code" value="{{ $coupon->code ?? '' }}"
                            label="Coupon Code" required="true" placeholder="Coupon Code" />
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-secondary mt-4 generate_coupon">Generate</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="coupon-type-values d-none">
            <div class="row values-container">
                <div class="col-md-2 value-container percentage fixed">
                    <x-form-input name='value' type='number' label='Value' required="true" />
                </div>
                <div class="col-md-4 value-container free_shipping">
                    <label for="shipping_methods">Shipping Methods<span class="text-danger">*</span></label>
                    <select name="shipping_methods" id="shipping_methods" class="form-control" multiple>
                        <option value="" disabled>Select Shipping Methods</option>
                        <option value="royal_mail" @selected(($coupon->type ?? '') === 'royal_mail')>Royal Mail</option>
                        <option value="dpd" @selected(($coupon->type ?? '') === 'dpd')>DPD</option>
                        <option value="click_collect" @selected(($coupon->type ?? '') === 'click_collect')>Click & Collect</option>
                    </select>
                </div>
                <div class="col-md-4 value-container buy_x_get_y">
                    <div class="row">
                        <div class="col-md-6">
                            <x-form-input name='buy_x_quantity' value="2" type='number' label='Buy X'
                                required="true" />
                        </div>
                        <div class="col-md-6">
                            <x-form-input name='get_y_quantity' value="1" type='number' label='Get Y'
                                required="true" />
                        </div>
                    </div>
                </div>
                <div class="col-md-7 value-container buy_x_for_y">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="buy_x_products">Buy X Products<span class="text-danger">*</span></label>
                            <select name="buy_x_products[]" id="buy_x_products" class="form-control" multiple>
                                <option value="" disabled>Select Products</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->article_code }}
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <x-form-input name='buy_x_discount' value="" type='number' label='For'
                                required="true" />
                        </div>
                        <div class="col-md-3">
                            <label for="buy_x_discount_type">Discount Type<span class="text-danger">*</span></label>
                            <select name="buy_x_discount_type" id="buy_x_discount_type" class="form-control">
                                <option value="percentage" @selected(($coupon->buy_x_discount_type ?? '') === 'percentage')>Percentage</option>
                                <option value="fixed" @selected(($coupon->buy_x_discount_type ?? '') === 'fixed')>Fixed Price</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Minimum Requirements</h4>
        <div class="row">
            <div class="col-md-2">
                <x-form-input name='min_spend' type='number' label='Minimum Spend' />
            </div>
            <div class="col-md-2">
                <x-form-input name='max_spend' type='number' label='Maximum Spend' />
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Usage Limit</h4>
        <div class="row">
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="limitOrders">
                    <label class="form-check-label" for="limitOrders">
                        Limit number of times this discount can be used in total
                    </label>
                </div>        
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="limitCustomers">
                    <label class="form-check-label" for="limitCustomers">
                        Limit number of times this discount can be used per customer
                    </label>
                </div>        
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label for="limit_by_price">Limit By Price</label>
                <select name="limit_by_price" id="limit_by_price" class="form-control">
                    <option value="all_items">All items</option>
                    <option value="reduced_items">Reduced items only</option>
                    <option value="full_price_items">Full price items only</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="allowed_tags">Allowed Tags</label>
                <select name="allowed_tags[]" id="allowed_tags" class="form-control" multiple>
                    <option value="" disabled>Select Allowed Tags</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="disallowed_tags">Disallowed Tags</label>
                <select name="disallowed_tags[]" id="disallowed_tags" class="form-control" multiple>
                    <option value="" disabled>Select Disallowed Tags</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Status & Description</h4>
        <div class="row">
            <div class="col-md-3 mb-2">
                <label for="coupon-status">Status</label>
                <select name="status" id="coupon-status" class="form-control">
                    <option value="1" @selected(($coupon->status ?? 1) == 1)>Active</option>
                    <option value="0" @selected(($coupon->status ?? 1) == 0)>Inactive</option>
                    <option value="2" @selected(($coupon->status ?? 1) == 2)>Expired</option>
                </select>
            </div>
            <div class="col-md-6 mb-2">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="2">{{ $coupon->description ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary w-md">Submit</button>

<x-include-plugins :plugins="['select2', 'image', 'imagePreview', 'datePicker', 'contentEditor']"></x-include-plugins>

<script>
    $(function() {
        $('#type, #shipping_methods, #buy_x_products, #buy_x_discount_type, #limit_by_price, #allowed_tags, #disallowed_tags')
            .select2({
                width: '100%',
            });

        $('#type').change(function() {
            let couponType = $(this).val();
            if (couponType) {
                $('.coupon-type-values').removeClass('d-none');
            }

            let requiredInput = '<span class="text-danger">*</span>';

            if (couponType === 'percentage') {
                $('[for="value"]').html(`Value${requiredInput} (in %)`);
                validateDiscountValue();
            } else if (couponType === 'fixed') {
                $('[for="value"]').html(`Value${requiredInput} (in amount)`);
            }

            $('.values-container .value-container').addClass('d-none');
            $(`.values-container .${couponType}`).removeClass('d-none');
        });

        function validateDiscountValue() {
            let couponType = $('#type').val();
            let value = $('#value').val();

            if (couponType === 'percentage' && value > 100) {
                $('#value').val(100);
            }
        }

        $('#value').on('input', function() {
            validateDiscountValue();
        });

        function validateBuyItemDiscount() {
            if ($('#buy_x_discount_type').val() === 'percentage') {
                var discountValue = $('#buy_x_discount').val();
                if (discountValue > 100) {
                    $('#buy_x_discount').val(100); // Set the value to 100 if it exceeds 100
                }
            }
        }

        $('#buy_x_discount_type').change(function() {
            validateBuyItemDiscount();
        });

        $('#buy_x_discount').on('input', function() {
            validateBuyItemDiscount();
        });

        $('.generate_coupon').click(function() {
            let length = 10;
            const characters =
                'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // Allowed characters
            let couponCode = '';

            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * characters.length);
                couponCode += characters.charAt(randomIndex);
            }

            $('#coupon_code').val(couponCode);
        });
    });
</script>
