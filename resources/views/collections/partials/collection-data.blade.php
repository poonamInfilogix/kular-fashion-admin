<input type="hidden" name="condition_type" value="include">
@if($type == 'tags')
    <div class="form-group" style="display: grid;">
        <label>Select Tag</label>
        <select class="form-control" id="multipleSelect" multiple name="tags[]">
            <option disabled>Select Tag</option>
            @foreach ($tags as $tag)
                <option value="{{$tag->id}}">{{ $tag->tag_name }}</option>
            @endforeach
        </select>
    </div>

@elseif($type == 'category')
    <label>Category</label>
    <div class="form-group" style="display: grid;">
        <select class="form-control" id="multipleSelect" multiple name="categories[]">
            <option disabled>Select Category</option>
            @foreach ($productTypes as $productType)
                <option value="{{$productType->id}}">{{ $productType->product_type_name }}</option>
            @endforeach
        </select>
    </div>

@elseif($type == 'price_list')
    <x-form-input type="number" name="price_name" label="Price List" placeholder="Enter Price List"/>

@elseif($type == 'price_range')
    <div data-role="main" class="ui-content">
      <div data-role="rangeslider">
        <input type="range" name="price_max" id="price-range" value="{{ $maxPrice }}" min="0" max="{{ $maxPrice }}">
      </div>
    </div>

@elseif($type == 'price_status')
    <label>Price Status</label>
    <div class="form-group" style="display: grid;">
        <select class="form-control" name="price_status">
            <option disabled>Select Price Status</option>
            <option >Reduce Item Only</option>
            <option >Full Price Item Only</option>
        </select>
    </div>

@elseif($type == 'publish_within')
    <label>Publish Within</label>
    <div class="form-group" style="display: grid;">
        <select class="form-control" name="publish_status">
            <option disabled>Select Publish</option>
            <option >Days</option>
            <option >Range</option>
        </select>
    </div>
@else

@endif