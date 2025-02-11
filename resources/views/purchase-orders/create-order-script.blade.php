
@push('scripts')
   <script>
        function addNewProduct(index, productInfo = null, errors = []) {
            let productCodeValue = productInfo?.product_code || '';

            var newField = `
                <div class="product-field-group mb-3 border p-3" data-product-index="${index}">
                    <div class="row">
                        <div class="col-sm-6 col-md-2 mb-3">
                            <x-form-input name="products[${index}][product_code]" value="${productCodeValue}" label="Product Code" placeholder="Enter Product Code" required />
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <x-form-input name="products[${index}][supplier_color_code]" label="Supplier Color Code" placeholder="Enter Supplier Color Code" required />
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <label for="color">Select Color <span class="text-danger">*</span></label>
                            <select name="products[${index}][colors[]]" class="form-control">
                                <option value="" disabled selected>Select Color</option> 
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}"> {{ $color->color_name }} ({{ $color->color_code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <label for="product_type">Product Type<span class="text-danger">*</span></label>
                            <select name="products[${index}][product_type]" class="form-control">
                                <option value="" disabled selected>Select Product Type</option> 
                                @foreach ($productTypes as $productType)
                                    <option value="{{ $productType->id }}">{{ $productType->product_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <label for="size_scale">Size Scale<span class="text-danger">*</span></label>
                            <select name="products[${index}][size_scale]" id="size_scale" class="form-control size-scale-dropdown">
                                <option value="" disabled selected>Select size scale</option>
                                @foreach ($sizeScales as $sizeScale)
                                    <option value="{{ $sizeScale->id }}" @selected(old('size_scale_id', $product->size_scale_id ?? '') == $sizeScale->id)>
                                        {{ $sizeScale->size_scale }}
                                        
                                        @if (isset($sizeScale->sizes))
                                            ({{ $sizeScale->sizes->first()->size }} - {{ $sizeScale->sizes->last()->size }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 col-md-2 mb-3">
                            <label for="min_size_id">Min Size<span class="text-danger">*</span></label>
                            <select name="products[${index}][min_size]" class="form-control min-size-dropdown">
                                <option value="" disabled selected>Select Min Size</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <label for="max_size_id">Max Size<span class="text-danger">*</span></label>
                            <select name="products[${index}][max_size]" class="form-control max-size-dropdown">
                                <option value="" disabled selected>Select Max Size</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <x-form-input name="products[${index}][delivery_date]" label="Delivery Date" class="date-picker" placeholder="Enter Delivery Date" required />
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <x-form-input name="products[${index}][supplier_color_code]" label="Unit Price" placeholder="Enter Unit Price" required />
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <x-form-input name="products[${index}][short_description]" label="Short Description" placeholder="Enter Short Description" required />
                        </div>
                        <div class="col-sm-6 col-md-3 mt-4">
                            <button type="button" class="btn btn-primary add-product-variant"><i class="fas fa-plus"></i> Variant</button>
                            <button type="button" class="btn btn-secondary copy-product"><i class="fas fa-copy"></i></button>
                            <button type="button" class="btn btn-danger remove-product-field"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-product-field">Remove</button>
                </div>
            `;
            $('#product-fields-container').append(newField);
        }

        $(function() {
            $('#supplier').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Supplier'
            });

            $('[name="products[0][product_type]"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Product Type'
            });

            $('[name="products[0][size_scale]"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Size Scale'
            });
        });

        $(document).ready(function() {
            let oldProducts = @json(old('products', [])); 
            if(oldProducts.length > 1){
                let errors = @json($errors->messages());

                for(let i=1; i<oldProducts.length; i++){
                    addNewProduct(i, oldProducts[i], errors);
                }
            }

            $('#add-product-field').click(function() {
                let index = $('.product-field-group').length;
                addNewProduct(index);
            });

            $(document).on('click', '.remove-product-field', function() {
                $(this).closest('.product-field-group').remove();
            });
        });

        $(document).on('change', '.size-scale-dropdown', function() {
            var selectedSizeScaleId = $(this).val();
            var parent = $(this).closest('.product-field-group');

            $.ajax({
                url: '/get-size-range',
                method: 'GET',
                data: {
                    size_scale_id: selectedSizeScaleId
                },
                success: function(response) {
                    var minSizeDropdown = parent.find('.min-size-dropdown');
                    var maxSizeDropdown = parent.find('.max-size-dropdown');

                    minSizeDropdown.empty();
                    maxSizeDropdown.empty();

                    minSizeDropdown.append(
                        '<option value="" disabled selected>Select Min Size</option>');
                    maxSizeDropdown.append(
                        '<option value="" disabled selected>Select Max Size</option>');

                    $.each(response.min_size_options, function(id, size) {
                        minSizeDropdown.append('<option value="' + id + '">' + size +
                            '</option>');
                    });

                    $.each(response.max_size_options, function(id, size) {
                        maxSizeDropdown.append('<option value="' + id + '">' + size +
                            '</option>');
                    });

                    minSizeDropdown.trigger('chosen:updated');
                    maxSizeDropdown.trigger('chosen:updated');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching size range:', error);
                }
            });
        });
    </script>
@endpush
