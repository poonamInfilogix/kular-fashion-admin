@push('scripts')
    <script>
        $(function() {
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
                        let removeBtn = $('<button type="button" class="btn btn-danger btn-sm remove-image-btn"><i class="fa fa-trash"></i></button>');
                        let altDiv = $(`<div class="alt-container"><input type="text" name="image_alt[${index}]" class="form-control" placeholder="Alt text"></div>`);

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

            // Initialize Dropzone
            /* const dropzone = new Dropzone("#product-dropzone", {
                url: "{{ route('product.uploadImages', $product->id) }}",
                paramName: "image",
                maxFilesize: 10,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictDefaultMessage: "Drop files here or click to upload.",
                dictRemoveFile: "Remove",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                init: function() {
                    this.on("success", function(file, response) {
                        file.previewElement.setAttribute("data-id", response.id);
                    });
                    this.on('removedfile', function(file) {
                        const imageId = file.previewElement.getAttribute("data-id");

                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('product.destroy.image', '') }}/" + imageId,
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                        });
                    })
                }
            }); */

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
@endpush
