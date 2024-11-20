<template>
    <table id="product-table" class="table table-bordered dt-responsive nowrap w-100">
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
        $(document).ready(function () {
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
                        render: function (data, type, row, meta) {
                            return `<div class="form-check form-check-primary">
                                <input class="form-check-input select-row" type="checkbox" data-id="${row.id}">
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
            $('#product-table').on('click', 'tbody tr', function (e) {
                if ($(e.target).is('input[type="checkbox"]')) return;

                const row = $(this);
                const rowData = table.row(row).data();
                const nextRow = row.next('.expanded-row');

                if (nextRow.length) {
                    nextRow.remove();
                } else {
                    console.log('rowData', rowData)
                    const expandedRow = $('<tr class="expanded-row"><td colspan="6"></td></tr>');
                    const detailsHtml = `
                        <div>
                        <p><strong>Article Code:</strong> ${rowData.article_code}</p>
                        <p><strong>Manufacture Code:</strong> ${rowData.manufacture_code}</p>
                        <p><strong>Department:</strong> ${rowData.department.name}</p>
                        <p><strong>Brand:</strong> ${rowData.brand.name}</p>
                        <p><strong>Product Type:</strong> ${rowData.product_type.product_type_name}</p>
                        <p><strong>Additional Details:</strong> More details about this product...</p>
                        </div>
                    `;
                    expandedRow.find('td').html(detailsHtml);
                    row.after(expandedRow);
                }
            });
        });
    }
};
</script>