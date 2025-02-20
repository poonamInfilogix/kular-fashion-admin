<div class="row mb-2">
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="name" value="{{ $color->name ?? '' }}" label="Color Name" placeholder="Enter Color Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="short_name" value="{{ $color->short_name ?? '' }}" label="Short Name" placeholder="Enter Short Name"  required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <x-form-input name="code" value="{{ $color->code ?? '' }}" label="Color Code" placeholder="Enter Color Code"  required="true" maxlength="3"/>
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
            <label for="color-status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active" @selected(($color->status ?? '') === 'Active')>Active</option>
                <option value="Inactive" @selected(($color->status ?? '') === 'Inactive')>Inactive</option>
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