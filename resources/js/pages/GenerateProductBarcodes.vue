<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Print Barcodes</h4>


                <div class="page-title-right">
                    <button class="btn btn-primary me-2">
                        <i class="bx bx-printer"></i>
                        Print
                    </button>
                    
                    <a :href="links.productList" class="btn btn-primary">
                        <i class="bx bx-arrow-back me-2"></i>
                        Back to products</a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ProductsForBarcode />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductsForBarcode from '../components/product/ProductsForBarcode.vue';

export default {
    components: {
        ProductsForBarcode
    },
    props: {
        links: {
            required: true
        }
    },
    mounted() {
        console.log('links', this.links)
        $(document).ready(function () {
            // Handle 'select-all' checkbox
            $('#select-all').on('change', function () {
                var checkboxes = $('#product-table .select-row');
                checkboxes.prop('checked', this.checked); // Set all checkboxes based on header checkbox
            });

            // Handle individual row selection
            $('#product-table').on('change', '.select-row', function () {
                var allChecked = $('#product-table .select-row').length === $('#product-table .select-row:checked').length;
                $('#select-all').prop('checked', allChecked);
            });
        });
    }
};
</script>