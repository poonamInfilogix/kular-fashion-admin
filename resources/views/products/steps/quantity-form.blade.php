<table class="table">
    <thead>
        <tr id="sizeHeader">
            <th>Size</th>
            @foreach ($sizes as $size)
                <th data-size-id="{{ $size->id }}">{{ $size->size ?? $size->sizeDetail->size }}</th>
            @endforeach

            <th @class(['actionColumn', 'd-none' => count($savedColors) <= 1])>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            if (isset($savingProduct->variantData)) {
                $quantityData = $savingProduct->variantData->quantity;
            }
        @endphp
        @foreach ($savedColors as $color)
            <tr data-id="rm-{{ $color['id'] }}">
                <th>{{ $color['color_name'] }} ({{ $color['color_code'] }})</th>
                @foreach ($sizes as $key => $size)

                @php
                $quantity = 0;
                if(isset($product) ? $product->colors->where('color_id', $color['id'])->first() : null){
                    $savedProductColorId = $product->colors->where('color_id', $color['id'])->first()->id;
                    $quantity = $size->quantity($savedProductColorId);
                }
                @endphp

                    <td>
                        <input type="number" name="quantity[{{ $color['id'] }}][{{ $size->id }}]"
                            value="{{ isset($quantityData) ? $quantityData[$color['id']] : $quantity }}"
                            class="form-control">
                    </td>
                @endforeach

                <td @class(['actionColumn', 'd-none' => count($savedColors) <= 1])>
                    <a href="{{ route('products.remove-variant', $color['id']) }}" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        <tr>
            <th>MRP</th>
            @foreach ($sizes as $size)
                <td><input type="number" name="mrp[{{ $size->id }}]" value="{{ $savingProduct->mrp ?? $size->mrp }}"
                        class="form-control"></td>
            @endforeach
        </tr>

    </tbody>
</table>
