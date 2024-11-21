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
                <th>Manufacture Code</th>
                <th>Department</th>
                <th>Product Type</th>
                <th>Brand</th>
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
                { title: "Manufacture Code", data: 'manufacture_code' },
                { title: "Department", data: 'department.name' },
                { title: "Brand", data: 'brand.name' },
                { title: "Product Type", data: 'product_type.product_type_name' },
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
            const expandedRow = $('<tr class="expanded-row"><td colspan="6"></td></tr>');
            const detailsHtml = `
        <div class="d-flex">
            <button class="btn btn-primary btn-sm me-3" id="toggleAllColorsBtn">Unselect All Colors</button>
            
            ${rowData.colors.map((color, index) => `
                <div class="me-2 d-color-code selected" 
                    data-index="${index}" 
                    style="background-color: ${color.color_detail.ui_color_code};"
                    data-color-id="${color.color_detail.id}">
                </div>
            `).join('')}
        </div>
    `;
            expandedRow.find('td').html(detailsHtml);
            row.after(expandedRow);

            // Function to update the button text based on the selection state
            function updateButtonText() {
                const allColorDivs = expandedRow.find('.d-color-code');
                const selectedClass = 'selected';

                // Check if all colors are selected
                const allSelected = allColorDivs.length === allColorDivs.filter(`.${selectedClass}`).length;

                const button = expandedRow.find('#toggleAllColorsBtn');
                if (allSelected) {
                    button.text('Unselect All Colors');
                } else {
                    button.text('Select All Colors');
                }
            }

            // Add click handler to color divs
            expandedRow.find('.d-color-code').on('click', function () {
                const colorDiv = $(this);
                const selectedClass = 'selected';

                // Toggle the selected class
                colorDiv.toggleClass(selectedClass);

                // Optionally, you can keep track of selected color IDs
                const colorId = colorDiv.data('color-id');
                if (colorDiv.hasClass(selectedClass)) {
                    console.log(`Color ID ${colorId} selected`);
                } else {
                    console.log(`Color ID ${colorId} deselected`);
                }

                // Update the button text after a color is clicked
                updateButtonText();
            });

            // Add click handler for the "Select All" button
            expandedRow.find('#toggleAllColorsBtn').on('click', function () {
                const allColorDivs = expandedRow.find('.d-color-code');
                const selectedClass = 'selected';

                if ($(this).text() === 'Unselect All Colors') {
                    allColorDivs.removeClass(selectedClass);
                    $(this).text('Select All Colors');
                    allColorDivs.each(function () {
                        const colorId = $(this).data('color-id');
                        console.log(`Color ID ${colorId} deselected`);
                    });
                } else {
                    allColorDivs.addClass(selectedClass);
                    $(this).text('Unselect All Colors');
                    allColorDivs.each(function () {
                        const colorId = $(this).data('color-id');
                        console.log(`Color ID ${colorId} selected`);
                    });
                }
            });

            // Update the button text initially in case all colors are selected by default
            updateButtonText();
        }

    }
};
</script>