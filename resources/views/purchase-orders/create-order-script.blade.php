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
                            <label for="product_type_${index}">Product Type<span class="text-danger">*</span></label>
                            <select name="products[${index}][product_type]" class="form-control product-type-dropdown">
                                <option value="" disabled selected>Select Product Type</option> 
                                @foreach ($productTypes as $productType)
                                    <option value="{{ $productType->id }}">{{ $productType->product_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2 mb-3">
                            <label for="size_scale-${index}">Size Scale<span class="text-danger">*</span></label>
                            <select name="products[${index}][size_scale]" id="size_scale-${index}" class="form-control size-scale-dropdown">
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
                            <x-form-input name="products[${index}][supplier_color_code]" label="Price" placeholder="Enter Price" required />
                        </div>
                        <div class="col-sm-6 col-md-3 mb-3">
                            <x-form-input name="products[${index}][short_description]" label="Short Description" placeholder="Enter Short Description" required />
                        </div>
                        <div class="col-sm-6 col-md-3 mt-4">
                            <button type="button" class="btn btn-primary add-product-variant" disabled data-toggle="modal" data-target="#variantModal"><i class="fas fa-plus"></i> Variant</button>
                            <button type="button" class="btn btn-secondary copy-product" disabled><i class="fas fa-copy"></i></button>
                            <button type="button" class="btn btn-danger remove-product-field"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger remove-product-field">Remove</button>
                </div>
            `;
            $('#product-fields-container').append(newField);

            $('.product-type-dropdown').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Product Type'
            });

            $('.size-scale-dropdown').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Size Scale'
            });

            $('.size-scale-dropdown').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Size Scale'
            });

            $('.min-size-dropdown').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Min Size'
            });

            $('.max-size-dropdown').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Max Size'
            });
        }

        $(function() {
            $('#supplier').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Supplier'
            });

            $('#color').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Color'
            });

            $('[name="products[0][product_type]"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Product Type'
            });

            $('[name="products[0][min_size]"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Min Size'
            });

            $('[name="products[0][max_size]"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Max Size'
            });

            $('[name="products[0][size_scale]"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Size Scale'
            });
        });

        $(document).ready(function() {
            let oldProducts = @json(old('products', []));
            if (oldProducts.length > 1) {
                let errors = @json($errors->messages());

                for (let i = 1; i < oldProducts.length; i++) {
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

        function getSizes(productIndex) {
            let minSize = $(`[name="products[${productIndex}][min_size]"]`).val();
            let maxSize = $(`[name="products[${productIndex}][max_size]"]`).val();


            let sizeRange = [];
            for (let i = parseInt(minSize); i <= parseInt(maxSize); i++) {
                let sizeOption = $(`[name="products[${productIndex}][min_size]"] option[value="${i}"]`);
                let sizeLabel = sizeOption.html();
                let sizeId = sizeOption.val();

                sizeRange.push({
                    id: sizeId,
                    size: sizeLabel
                });
            }

            return sizeRange;
        }

        function updateProductDependButtonsAttr(productIndex) {
            let minSize = $(`[name="products[${productIndex}][min_size]"]`).val();
            let maxSize = $(`[name="products[${productIndex}][max_size]"]`).val();

            if (minSize && maxSize) {
                let sizesColumn = ``;

                getSizes(productIndex).forEach(function(sizeObj) {
                    sizesColumn += `<th>${sizeObj.size}</th>`;
                });

                $(`[data-product-index="${productIndex}"] .variants-container`).html(`<table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Size</th>
                            ${sizesColumn}
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>`);

                $(`[data-product-index="${productIndex}"] .add-product-variant`).removeAttr('disabled');
                $(`[data-product-index="${productIndex}"] .copy-product`).removeAttr('disabled');
            } else {
                $(`[data-product-index="${productIndex}"] .add-product-variant`).attr('disabled', 'disabled');
                $(`[data-product-index="${productIndex}"] .copy-product`).attr('disabled', 'disabled');
                $(`[data-product-index="${productIndex}"] .variants-container`).html(``);
            }
        }

        $(function() {
            $(document).on('change', '.min-size-dropdown', function() {
                let productIndex = $(this).parents('[data-product-index]').attr('data-product-index');
                updateProductDependButtonsAttr();

                var minSizeId = parseInt($(this).val());

                $(`[data-product-index="${productIndex}"] .max-size-dropdown`).prop('disabled', false)
                    .trigger('chosen:updated');
                $(`[data-product-index="${productIndex}"] .max-size-dropdown option`).show();

                $(`[data-product-index="${productIndex}"] .max-size-dropdown option`).each(function() {
                    var maxSizeId = parseInt($(this).val());

                    if (maxSizeId < minSizeId) {
                        $(this).hide();
                    }
                });

                $(`[data-product-index="${productIndex}"] .max-size-dropdown`).trigger('chosen:updated');
                var visibleOptions = $(
                    `[data-product-index="${productIndex}"] .max-size-dropdown  option:visible`);

                if (visibleOptions.length > 0) {
                    var lastVisibleOptionValue = visibleOptions.last().val();
                    $(`[data-product-index="${productIndex}"] .max-size-dropdown`).val(
                        lastVisibleOptionValue).trigger('chosen:updated');
                } else {
                    var lastOptionValue = $('#size_range_max option:last').val();
                    $(`[data-product-index="${productIndex}"] .max-size-dropdown`).val(lastOptionValue)
                        .trigger('chosen:updated');
                }
            });

            $(document).on('change', '.max-size-dropdown', function() {
                updateProductDependButtonsAttr($(this).parents('[data-product-index]').attr(
                    'data-product-index'));
            });

            $(document).on('click', '.add-product-variant', function() {
                $('#selected_product_index').val($(this).parents('[data-product-index]').attr(
                    'data-product-index'));
            });

            $(document).on('click', '.save-variant', function() {
                let productIndex = $('#selected_product_index').val();
                let supplierColorCode = $('#supplier_color_code').val();
                let supplierColorName = $('#supplier_color_name').val();
                let color = $('#color').val();

                let minSize = $(`[name="products[${productIndex}][min_size]"]`).val();
                let maxSize = $(`[name="products[${productIndex}][max_size]"]`).val();

                let quantityInputCell = ``;
                let variantIndex = $(`[data-product-index="${productIndex}"] .variants-container tbody tr`).length;

                getSizes(productIndex).forEach(function(sizeObj) {
                    quantityInputCell += `<td><input type="text" name="products[${productIndex}][variants][${variantIndex}][size][${sizeObj.id}]"></td>`;
                });

                $(`[data-product-index="${productIndex}"] .variants-container tbody`).append(`<tr>
                    <td>Red</td>
                    ${quantityInputCell}
                </tr>`);
            });
        })
    </script>
@endpush


<div class="modal fade" id="variantModal" tabindex="-1" role="dialog" aria-labelledby="variantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVariantModalLabel">Add New Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="selected_product_index">
                <div class="mb-3">
                    <x-form-input name="supplier_color_code" label="Supplier Color Code"
                        placeholder="Enter Supplier Color Code" required />
                </div>
                <div class="mb-3">
                    <x-form-input name="supplier_color_name" label="Supplier Color Name"
                        placeholder="Enter Supplier Color Name" required />
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Select Color <span class="text-danger">*</span></label>
                    <select id="color" name="color" class="form-control" required>
                        <option value="" disabled selected>Select Color</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}">{{ $color->color_name }}
                                ({{ $color->color_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-variant">Save</button>
            </div>
        </div>
    </div>
</div>
