<div class="row mb-2">
    <div class="col-sm-6 col-md-4">
        <div class="mb-3">
            <x-form-input name="collection_name" value="{{ $collection->name ?? '' }}" label="Collection Name" placeholder="Enter Collection Name" required="true"/>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="color-status" class="form-control">
                <option value="Active" @selected($collection->status ?? '' === 1)>Active</option>
                <option value="Inactive" @selected($collection->status ?? '' === 0)>Inactive</option>
            </select>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-between">
                <h6>Include Condition</h6>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#addConditionModal">Add new condition</button>
            </div>
        </div>
        
    </div>

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 d-flex justify-content-between">
                <h6>Exclude Condition</h6>
                <button type="button" class="btn btn-sm btn-secondary">Add new condition</button>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-3">
        <div class="mb-3">
            <label for="status">Image</label>
            <input type="file" name="collection_image" class="form-control" accept="image/*">

            <div class="row d-block">
                <div class="col-md-8 mt-2">
                    @if(isset($collection) && $collection->image)
                        <img src="{{ asset($collection->image) }}" id="preview-collection" class="img-preview img-fluid w-50">
                    @else
                        <img src="" id="preview-collection" class="img-fluid w-50;" name="image" hidden>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-lg-6 mb-2">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
</div>

<div class="modal fade" id="addConditionModal" tabindex="-1" aria-labelledby="addConditionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addConditionModalLabel">Add Condition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="selectOption" class="form-label">Select Condition</label>
                    <select class="form-select" id="selectOption" aria-label="Select option">
                        <option value="0">Have one of these tags</option>
                        <option value="1">Be in the category</option>
                        <option value="2">Be in the price list</option>
                        <option value="2">Be in the price range</option>
                        <option value="2">Have the price status</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('[name="collection_image"]').change(function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Show the preview image
                $('#preview-collection').attr('src', e.target.result).removeAttr('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
</script>
@endpush