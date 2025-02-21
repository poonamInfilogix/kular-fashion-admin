@extends('layouts.app', ['isVueComponent' => true])

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            @php
                $links = [
                    'productList'   => route('products.index'),
                    'printBarcode'  => route('download.barcodes'),
                ];
            @endphp

            <generate-product-barcodes :links="{{ json_encode($links) }}" :default-products-to-be-printed="{{ $defaultProductsToBePrinted }}"></generate-product-barcodes>
        </div>
    </div>

    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>

    @push('scripts')
        <script>
            function validateMaxQuantity(input, maxQuantity) {
                if (parseInt(input.value) > maxQuantity) {
                    input.value = maxQuantity;
                }
            }

            function expandRow(row, rowData, shoudlShould = true) {
                const nextRow = $(row).next('.expanded-row');
                if (!rowData || nextRow.length) { return; }
                
                console.log('::::',rowData.colors)

                const expandedRow = $(`<tr class="expanded-row" data-product-barcode-quantity="${rowData.id}"><td colspan="8" class="py-0"></td></tr>`);
                const detailsHtml = `
                <div class="row">
                    <table class="table mt-2">
                        <tr>
                            <th class="py-1">Size</th>
                            ${rowData.sizes.map((size, index) => `
                                <th class="py-1" data-index="${index}" data-size-id="${size.size_id}">
                                    ${size.size_detail.size}
                                </th>
                            `).join('')}
                        </tr>

                        ${rowData.colors.filter(color => {
                            return rowData.quantities.some(quantity => quantity.product_color_id === color.id && quantity.total_quantity > 0);
                        }).map((color, index) => `
                            <tr>
                                <th class="py-1">                            
                                    <div class="me-2 d-color-code" 
                                        data-index="${index}" 
                                        style="background-color: ${color.color_detail.ui_color_code};"
                                        data-color-id="${color.color_detail.id}">
                                    </div>
                                </th>
                                ${rowData.sizes.map(size => {
                                    const quantity = rowData.quantities.find(q => 
                                        parseInt(q.product_size_id) === parseInt(size.size_id) &&
                                        parseInt(q.product_color_id) === parseInt(color.id)
                                    );

                                    if (!quantity) {
                                        return `<td class="py-1">
                                            <div class="row px-2">
                                                <div class="col-8 p-0">
                                                    <input type="number" 
                                                        name="product[${rowData.id}][${size.size_id}]" 
                                                        id="${size.size_id}" 
                                                        class="form-control py-1 barcode-quantity" 
                                                        min="0" 
                                                        value="0" 
                                                        disabled>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <button class="btn btn-outline-secondary btn-sm double-barcode btn2x" disabled>2x</button>
                                                </div>
                                            </div>
                                        </td>`;
                                    }
                                    const disabled = quantity.total_quantity === 0 ? 'disabled' : '';
                                    return `<td class="py-1">
                                        <div class="row px-2">
                                            <div class="${quantity.total_quantity > 0 ? 'col-8' : '12'} p-0">
                                                <input type="number" 
                                                    name="product[${rowData.id}][${quantity.id}]" 
                                                    id="${quantity.id}" 
                                                    class="form-control py-1 barcode-quantity" 
                                                    min="0" 
                                                    value="${quantity.total_quantity - quantity.original_printed_barcodes}" 
                                                    ${disabled} 
                                                    oninput="validateMaxQuantity(this, ${quantity.total_quantity})">
                                            </div>
                                            ${quantity.total_quantity > 0 ?
                                                `<div class="col-4 p-0">
                                                    <button class="btn btn-outline-secondary btn-sm double-barcode btn2x" name="product[${rowData.id}][${quantity.id}]">2x</button>
                                                </div>`
                                            : ``}
                                        </div>
                                    </td>`;
                                }).join('')}
                            </tr>
                        `).join('')}
                    </table>
                </div>
                `;

                expandedRow.find('td').html(detailsHtml);
                row.after(expandedRow);
            }

            $(function(){
                $('#product-table').on('click', '.double-barcode', (e) => {
                    const barcodeQuantityInput = $(e.target).parent().parent().find('.barcode-quantity');
                    let originalQuantity = barcodeQuantityInput.val();
                    let quantityId = barcodeQuantityInput.attr('id');
                    let inpName = barcodeQuantityInput.attr('name');

                    $(e.target).toggleClass('btn-outline-secondary btn-secondary');

                    $('[name="'+inpName+'"]').attr('data-double', function(_, value) {
                        return value === "true" ? "false" : "true"; 
                    });
                });
            });
        </script>
    @endpush
@endsection
