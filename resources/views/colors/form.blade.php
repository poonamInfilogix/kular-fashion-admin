<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="color_name" value="{{ $color->color_name ?? '' }}" label="Color Name" placeholder="Enter Color Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="short_name" value="{{ $color->short_name ?? '' }}" label="Short Name" placeholder="Enter Short Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="color_code" value="{{ $color->color_code ?? '' }}" label="Color Code" placeholder="Enter Color Code"  required="true" maxlength="3"/>
        </div>
    </div>
    <div class="Col-sm-6 col-md-3">
        <div class="mb-3">
            <label class="form-label">Color</label>
            <input type="text" name="color" class="form-control colorpicker" id="colorpicker-showinput-intial" value="{{old('color', $color->ui_color_code ?? '')}}" placeholder="Select Color">
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active" {{ (isset($color) && $color->status === 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($color) && $color->status === 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>
<x-include-plugins :plugins="['colorPicker' ]"></x-include-plugins>
<script>


</script>