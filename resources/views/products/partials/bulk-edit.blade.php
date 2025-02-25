<div class="modal fade" id="bulkEditModal" tabindex="-1" aria-labelledby="bulkEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkEditModalLabel">Bulk Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="bulkEditAction">Select action</label>
                <select id="bulkEditAction" class="form-control">
                    <option value="Assign Tags">Assign Tags</option>
                    <option value="Unassign Tags">Unassign Tags</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary choose-bulk-edit-action">Choose Action</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bulkEditTagsModal" tabindex="-1" aria-labelledby="bulkEditTagsModallLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkEditTagsModalLabel">Choose Tags</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="bulkEditTags">Choose Tags</label>
                <select id="bulkEditTags" class="form-control" multiple>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary apply-bulk-edit-action" disabled>Apply Action</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#bulkEditAction').select2({
            width: '100%',
            dropdownParent: $('#bulkEditModal')
        });

        $('#bulkEditTags').select2({
            width: '100%',
            dropdownParent: $('#bulkEditTagsModal')
        });

        $('#bulkEditTags').change(function(){
            if($(this).val().length > 0){
                $('.apply-bulk-edit-action').removeAttr('disabled');
            } else {
                $('.apply-bulk-edit-action').attr('disabled', 'disabled')
            }
        })

        $('.choose-bulk-edit-action').click(function() {
            $('#bulkEditModal').modal('hide');
            $('#bulkEditTagsModal').modal('show');

            let selectedAction = $('#bulkEditAction').val();
            $('#bulkEditTagsModalLabel').html(selectedAction);
        })
    })
</script>
