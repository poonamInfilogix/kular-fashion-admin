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

            function expandRow(row, rowData) {
                const nextRow = $(row).next('.expanded-row');
                if (!rowData || nextRow.length) { return; }
                
                const expandedRow = $(`<tr class="expanded-row" data-product-barcode-quantity="${rowData.id}"><td colspan="6"></td></tr>`);
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
                                ${rowData.quantities.map(quantity => {
                                    if (color.id === quantity.product_color_id) {
                                        const disabled = quantity.total_quantity === 0 ? 'disabled' : '';

                                        return `<td class="py-1">
                                            <div class="row px-2">
                                                <div class="${quantity.total_quantity > 0 ? 'col-8' : '12'} p-0">
                                                    <input type="number" name="product[${rowData.id}][${quantity.id}]" id="${quantity.id}" class="form-control py-1 barcode-quantity" min="0" value="${quantity.quantity}" ${disabled} oninput="validateMaxQuantity(this, ${quantity.total_quantity})">
                                                </div>
                                                ${quantity.total_quantity > 0 ?
                                                    `<div class="col-4 p-0">
                                                        <button class="btn btn-outline-secondary btn-sm double-barcode">2x</button>
                                                    </div>`
                                                : ``}
                                            </div>
                                        </td>`; 
                                    }
                                    return '';
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

                    $(e.target).toggleClass('btn-outline-secondary btn-secondary');
                    console.log('originalQuantity',originalQuantity)
                    console.log('quantityId',quantityId)
                });
            })
        </script>
    @endpush
@endsection
