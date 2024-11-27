<template>
    <table id="product-table" data-selected-articles="" class="table table-bordered dt-responsive nowrap w-100">
        <thead>
            <tr>
                <th>
                    <div class="form-check form-check-primary mb-3">
                        <input class="form-check-input" type="checkbox" id="select-all">
                    </div>
                </th>
                <th>Article Code</th>
                <th>Description</th>
                <th>Product Type</th>
                <th>Brand</th>
                <th>Price</th>
            </tr>
        </thead>
    </table>
</template>


<script>
export default {
    mounted() {
        const table = $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/get-products',
                data: function (d) {
                    d.page = Math.floor(d.start / d.length) + 1;
                }
            },
            columns: [
                {
                    title: `<div class="form-check form-check-primary">
                            <input class="form-check-input" type="checkbox" id="select-all">
                        </div>`,
                    orderable: false,
                    render: function (data, type, row) {
                        let selectedArticles = $('#product-table').attr('data-selected-articles').split(',');
                        let checked = selectedArticles.includes(String(row.id)) ? 'checked' : '';

                        return `<div class="form-check form-check-primary">
                                <input class="form-check-input select-row" type="checkbox" value="${row.id}" ${checked}>
                            </div>`
                    }
                },
                { title: "Article Code", data: 'article_code' },
                { title: "Description", data: 'short_description' },
                { title: "Brand", data: 'brand.name' },
                { title: "Product Type", data: 'product_type.product_type_name' },
                { title: "Price", data: 'mrp' },
            ],
            order: [[1, 'desc']]
        });

        // Handle row expansion on clicking any td (except the checkbox column)
        $('#product-table').on('change', '.select-row', (e) => {
            const checkbox = $(e.target);
            const row = checkbox.closest('tr');
            const rowData = table.row(row).data();
            const expandedRow = row.next('.expanded-row');

            if (checkbox.prop('checked')) {
                this.expandRow(row, rowData);
            } else {
                expandedRow.remove();
            }
        });

        $('table').on('change', '#select-all', (event) => {
            var checkboxes = $('#product-table .select-row');

            if (event.target.checked) {
                checkboxes.each((_, checkbox) => {
                    const row = $(checkbox).closest('tr');
                    const rowData = $(checkbox).closest('table').DataTable().row(row).data();
                    this.expandRow(row, rowData);
                });
            } else {
                $('#product-table .expanded-row').remove();
            }
        });


        $('#product-table').on('click', 'tbody tr', (e) => {
            if (e.target.tagName !== 'TD') return;
            const row = $(e.currentTarget);
            const rowData = table.row(row).data();
            const nextRow = row.next('.expanded-row');

            if (nextRow.length) {
                nextRow.remove();
            } else {
                this.expandRow(row, rowData);
            }
        });
    },
    methods: {
        expandRow(row, rowData) {
            const nextRow = $(row).next('.expanded-row');
            if (!rowData || nextRow.length) { return; }
            
            let tempSelectedColors = $(row).attr('data-selected-colors');
            let tempSelectedSizes = $(row).attr('data-selected-sizes');
            
            let selectedColors = [];
            let selectedSizes = [];

            if(typeof tempSelectedColors === 'undefined'){
                selectedColors = rowData.colors.map(color => String(color.color_detail.id));
            } else {
                selectedColors = tempSelectedColors ? tempSelectedColors.split(',') : [];
            }

            if(typeof tempSelectedSizes === 'undefined'){
                selectedSizes = tempSelectedSizes ? tempSelectedSizes.split(',') : rowData.sizes.map(size => String(size.size_id));
            } else {
                selectedSizes = tempSelectedSizes ? tempSelectedSizes.split(',') : [];
            }

            const expandedRow = $('<tr class="expanded-row"><td colspan="6"></td></tr>');
            const detailsHtml = `
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex">
                        <button class="btn btn-primary btn-sm me-3" id="toggleAllColorsBtn">Unselect All Colors</button>
                        
                        ${rowData.colors.map((color, index) => `
                            <div class="me-2 d-color-code ${selectedColors.includes(String(color.color_detail.id)) ? 'selected' : ''}" 
                                data-index="${index}" 
                                style="background-color: ${color.color_detail.ui_color_code};"
                                data-color-id="${color.color_detail.id}">
                            </div>
                        `).join('')}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <button class="btn btn-primary btn-sm me-3" id="toggleAllSizesBtn">Unselect All Sizes</button>

                        ${rowData.sizes.map((size, index) => `
                            <div class="me-2 d-size-box ${selectedSizes.includes(String(size.size_id)) ? 'selected' : ''}" 
                                data-index="${index}" 
                                data-size-id="${size.size_id}">
                                ${size.size_detail.size}
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
            `;

            expandedRow.find('td').html(detailsHtml);
            row.after(expandedRow);

            // Function to update the button text based on the selection state
            function updateButtonText() {
                const allColorDivs = expandedRow.find('.d-color-code');
                const allSizeDivs = expandedRow.find('.d-size-box');
                const selectedClass = 'selected';

                // Check if all colors are selected
                const allColorsSelected = allColorDivs.length === allColorDivs.filter(`.${selectedClass}`).length;
                const colorButton = expandedRow.find('#toggleAllColorsBtn');
                if (allColorsSelected) {
                    colorButton.text('Unselect All Colors');
                } else {
                    colorButton.text('Select All Colors');
                }

                // Check if all sizes are selected
                const allSizesSelected = allSizeDivs.length === allSizeDivs.filter(`.${selectedClass}`).length;
                const sizeButton = expandedRow.find('#toggleAllSizesBtn');
                if (allSizesSelected) {
                    sizeButton.text('Unselect All Sizes');
                } else {
                    sizeButton.text('Select All Sizes');
                }

                // Update the data-selected-colors and data-selected-sizes attributes on the row
                updateSelectedAttributes();
            }

            // Function to update the selected colors and sizes attributes on the row
            function updateSelectedAttributes() {
                const selectedColorDivs = expandedRow.find('.d-color-code.selected');
                const selectedColorIds = selectedColorDivs.map(function () {
                    return $(this).data('color-id');
                }).get();
                $(row).attr('data-selected-colors', selectedColorIds.join(','));

                const selectedSizeDivs = expandedRow.find('.d-size-box.selected');
                const selectedSizeIds = selectedSizeDivs.map(function () {
                    return $(this).data('size-id');
                }).get();
                $(row).attr('data-selected-sizes', selectedSizeIds.join(','));
            }

            // Add click handler to color divs
            expandedRow.find('.d-color-code').on('click', function () {
                const colorDiv = $(this);
                const selectedClass = 'selected';

                // Toggle the selected class
                colorDiv.toggleClass(selectedClass);
                updateButtonText();
            });

            // Add click handler to size divs
            expandedRow.find('.d-size-box').on('click', function () {
                const sizeDiv = $(this);
                const selectedClass = 'selected';

                // Toggle the selected class
                sizeDiv.toggleClass(selectedClass);
                updateButtonText();
            });

            // Add click handler for the "Select All" button for colors
            expandedRow.find('#toggleAllColorsBtn').on('click', function () {
                const allColorDivs = expandedRow.find('.d-color-code');
                const selectedClass = 'selected';

                if ($(this).text() === 'Unselect All Colors') {
                    allColorDivs.removeClass(selectedClass);
                    $(this).text('Select All Colors');
                } else {
                    allColorDivs.addClass(selectedClass);
                    $(this).text('Unselect All Colors');
                }

                // Update the button text after selecting/unselecting all colors
                updateButtonText();
            });

            // Add click handler for the "Select All" button for sizes
            expandedRow.find('#toggleAllSizesBtn').on('click', function () {
                const allSizeDivs = expandedRow.find('.d-size-box');
                const selectedClass = 'selected';

                if ($(this).text() === 'Unselect All Sizes') {
                    allSizeDivs.removeClass(selectedClass);
                    $(this).text('Select All Sizes');
                } else {
                    allSizeDivs.addClass(selectedClass);
                    $(this).text('Unselect All Sizes');
                }

                // Update the button text after selecting/unselecting all sizes
                updateButtonText();
            });

            // Update the button text initially in case all colors or sizes are selected by default
            updateButtonText();
        }
    }
};
</script>