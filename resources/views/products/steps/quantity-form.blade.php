<table class="table">
    <thead>
        <tr id="sizeHeader">
            <th>Size</th>
            @foreach ($sizes as $size)
                <th data-size-id="{{ $size->id }}">{{ $size->size ?? $size->sizeDetail->size }}</th>
            @endforeach

            @isset($product)
                <th class="text-center" style="width: 60px">Qty</th>
            @endisset

            <th @class(['actionColumn', 'd-none' => count($savedColors) <= 1])>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            if (isset($savingProduct->variantData)) {
                $quantityData = $savingProduct->variantData['quantity'];
            }
        @endphp

        @foreach ($savedColors as $color)
            @if ($color)
                @php
                    $total_in = 0;
                @endphp

                <tr data-id="rm-{{ $color['id'] }}">
                    <th>
                        <div class="me-1 d-color-code" style="background: {{ $color['ui_color_code'] }}"></div>
                        {{ $color['color_name'] }} ({{ $color['color_code'] }})
                    </th>
                    @foreach ($sizes as $key => $size)
                        @php
                            $quantity = 0;
                            if (isset($product) ? $product->colors->where('color_id', $color['id'])->first() : null) {
                                $savedProductColorId = $product->colors->where('color_id', $color['id'])->first()->id;
                                $quantity = $size->totalQuantity($savedProductColorId);
                                $total_in += $quantity;
                            }
                        @endphp

                        <td>
                            <input type="number" min="0" name="quantity[{{ $color['id'] }}][{{ $size->id }}]"
                                value="{{ isset($quantityData) && is_array($quantityData) && isset($quantityData[$color['id']]) ? (int) $quantityData[$color['id']] : 0 }}"
                                class="form-control">
                            @isset($product)
                                <h6 class="mt-1 mb-0">Total in: <b>{{ $quantity }}</b></h6>
                            @endisset
                        </td>
                    @endforeach

                    @isset($product)
                        <td class="fs-5 text-center">{{ $total_in }}</td>
                    @endisset
                    
                    <td @class(['actionColumn', 'd-none' => count($savedColors) <= 1])>
                        <div class="d-flex gap-2">
                            @isset($product)
                                <a href="{{ route('products.remove-variant', $color['id'] . '?productId=' . $product->id) }}"
                                    class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @else
                                <a href="{{ route('products.remove-variant', $color['id']) }}" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            @endisset

                            <button type="button" class="btn btn-secondary copy-quantity-btn"
                                data-color-id="{{ $color['id'] }}">
                                <i class="mdi mdi-content-copy fs-6"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
        <tr>
            <th>MRP</th>
            @foreach ($sizes as $size)
                <td><input type="number" name="mrp[{{ $size->id }}]" min="0" value="{{ $savingProduct->mrp ?? $size->mrp }}" class="form-control"></td>
            @endforeach
        </tr>

    </tbody>
</table>
