<script>
    $(function() {
        $('.color-swatch-container').click(function() {
            $(this).parent().find('.color_image_picker').click();
        });

        $('.color_image_picker').change(function(event) {
            let file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                var $parentRow = $(this).closest('td');

                reader.onload = function(e) {
                    $parentRow.find('.avatar-sm').css('background-image', 'url(' + e.target.result +
                        ')');
                    $parentRow.find('.remove-image').removeClass('d-none');
                };

                reader.readAsDataURL(file);
            }
        });

        function removeTempImage(input, id) {
            $targetedElement = $(`[data-input="${input}"][data-id="${id}"]`);
            if (input === 'removed_color_images') {
                $parentRow = $targetedElement.closest('td');
                $parentRow.find('.avatar-sm').css('background-image', '');
                $parentRow.find('.remove-image').addClass('d-none');
            } else if(input === 'removed_product_images'){
                $parentContainer = $targetedElement.closest('.preview-image-container');
                $parentContainer.parent().remove();
            } else {
                console.warn('Add condition to remove temp image')
            }
        }

        $(document).on('click', '.remove-image', function() {
            $targetElement = $(this);

            swal({
                title: "Are you sure?",
                text: `You really want to remove this image?`,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
            }, function(isConfirm) {
                if (isConfirm) {
                    let inputName = $targetElement.attr('data-input');

                    $respectiveInput = $(`[name="${inputName}"]`);
                    $targetedId = $targetElement.attr('data-id');;

                    let currentValue = $respectiveInput.val();
                    if (currentValue) {
                        $respectiveInput.val(currentValue + ',' + $targetedId);
                    } else {
                        $respectiveInput.val($targetedId);
                    }

                    removeTempImage(inputName, $targetedId);

                    swal.close();
                }
            });
        });

        let selectedFiles = [];

        $('#productImages').on('change', function(event) {
            let files = event.target.files;
            selectedFiles = Array.from(files); // Store selected files
            $('#imagePreview').empty();

            $.each(files, function(index, file) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let imageBox = $('<div class="col-6 col-sm-2 mb-2"></div>');
                    let imageContainer = $('<div class="preview-image-container"></div>');
                    let img = $('<img src="' + e.target.result + '" class="img-fluid" />');
                    let removeBtn = $(
                        '<button type="button" class="btn btn-danger btn-sm remove-image-btn"><i class="fa fa-trash"></i></button>'
                    );
                    let altDiv = $(
                        `<div class="alt-container"><input type="text" name="image_alt[${index}]" class="form-control" placeholder="Alt text"></div>`
                    );

                    // Remove image when remove button is clicked
                    removeBtn.on('click', function() {
                        selectedFiles = selectedFiles.filter(f => f !== file);
                        updateImagesInput();
                        imageBox.remove();
                    });

                    imageContainer.append(img).append(removeBtn).append(altDiv);
                    imageBox.append(imageContainer);

                    $('#imagePreview').append(imageBox);
                };

                reader.readAsDataURL(file);
            });
        });

        function updateImagesInput() {
            var dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            $('#productImages')[0].files = dataTransfer.files;
        }

        // Add Specification
        let specCount = $('.specification-item').length;

        $('#add-specification').click(function(event) {
            event.preventDefault();
            specCount++;
            const newDiv = `
                <div class="col-md-6 specification-item mb-3" id="spec-${specCount}">
                    <div class="row">
                        <div class="col-md-5">
                            <x-form-input name="specifications[${specCount}][key]" type="text" label="Key" placeholder="Key" class="form-control" required="true" />
                        </div>
                        <div class="col-md-5">
                            <x-form-input name="specifications[${specCount}][value]" label="Value" placeholder="Value" class="form-control" required="true" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-danger delete-specification mt-4" data-spec-id="spec-${specCount}"><i class="fas fa-trash-alt"></i> </button>
                        </div>
                    </div>
                </div>
            `;
            $('#specification-container').append(newDiv);
        });

        // Delete Specification
        $(document).on('click', '.delete-specification', function() {
            const specId = $(this).data('spec-id');
            $(`#${specId}`).remove();
        });

        flatpickr('.sale-date-picker', {
            dateFormat: "d-m-Y",
            allowInput: true,
            minDate: "today"
        });

        $('#tags').select2({
            width: '100%'
        });
    });
</script>
