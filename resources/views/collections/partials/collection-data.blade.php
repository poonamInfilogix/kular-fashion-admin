@if ($type == 'tags')
    <div class="col-md-6 my-2">
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label>Select Tag</label>
                    <select class="form-control multipleSelect" id="tags" multiple name="tags[]">
                        <option disabled>Select Tag</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
@elseif($type == 'categories')
    <div class="col-md-6 my-2">
        <div class="row">
            <div class="col-md-10">
                <label>Category</label>
                <div class="form-group">
                    <select class="form-control multipleSelect" id="categories" multiple name="categories[]">
                        <option disabled>Select Category</option>
                        @foreach ($productTypes as $productType)
                            <option value="{{ $productType->id }}">{{ $productType->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
@elseif($type == 'price_list')
    <div class="col-md-6 my-2">
        <div class="row">
            <div class="col-md-10">
                <x-form-input type="number" name="price_name" label="Price List" placeholder="Enter Price List" />
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
@elseif($type == 'price_range')
    <div class="col-md-6 my-2">
        <div class="row">
            <div class="col-md-10">
                <div class="price-range-slider">
                    <p class="range-value">
                        <input type="text" name="price_range" id="amount" readonly>
                    </p>
                    <div id="slider-range" class="range-bar"></div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
    <script>
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: '{{ $maxPrice }}',
            values: [130, 250],
            slide: function(event, ui) {
                $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
            " - $" + $("#slider-range").slider("values", 1));
    </script>
    <style>
        .price-range-slider {
            width: 100%;
            float: left;
            padding: 10px 20px;

            .range-value {
                margin: 0;

                input {
                    width: 100%;
                    background: none;
                    color: #000;
                    font-size: 16px;
                    font-weight: initial;
                    box-shadow: none;
                    border: none;
                    margin: 20px 0 20px 0;
                }
            }

            .range-bar {
                border: none;
                background: #000;
                height: 3px;
                width: 96%;
                margin-left: 8px;

                .ui-slider-range {
                    background: #06b9c0;
                }

                .ui-slider-handle {
                    border: none;
                    border-radius: 25px;
                    background: #fff;
                    border: 2px solid #06b9c0;
                    height: 17px;
                    width: 17px;
                    top: -0.52em;
                    cursor: pointer;
                }

                .ui-slider-handle+span {
                    background: #06b9c0;
                }
            }
        }
    </style>
@elseif($type == 'price_status')
    <div class="col-md-6 my-2">
        <div class="row">
            <div class="col-md-10">
                <label>Price Status</label>
                <div class="form-group">
                    <select class="form-control" name="price_status">
                        <option disabled>Select Price Status</option>
                        <option>Reduce Item Only</option>
                        <option>Full Price Item Only</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
@elseif($type == 'publish_within')
    <div class="col-md-6 my-2">
        <div class="row">
            <div class="col-md-4">
                <label>Publish Within</label>
                <div class="form-group">
                    <select class="form-control" name="publish_status">
                        <option disabled>Select Publish</option>
                        <option>Days</option>
                        <option>Range</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <label>Enter Days</label>
                <div class="form-group">
                    <select class="form-control" name="publish_status">
                        <option disabled>Select Publish</option>
                        <option>Days</option>
                        <option>Range</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    @else
@endif
