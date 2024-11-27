<template>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Print Barcodes</h4>

                <div class="page-title-right">
                    <button class="btn btn-primary me-2" id="printBarcodeBtn">
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

    <h5>{{ selectedArticles.length }} selected Articles</h5>

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
    data() {
        return {
            selectedArticles: []
        };
    },
    watch: {
        selectedArticles: {
            handler() {
                $('#product-table').attr('data-selected-articles', this.selectedArticles)
            },
            deep: true
        }
    },
    mounted() {
        $('table').on('change', '#select-all', (event) => {
            var checkboxes = $('#product-table .select-row');

            if (event.target.checked) {
                checkboxes.prop('checked', true);
                this.selectedArticles = checkboxes.map((_, checkbox) => $(checkbox).val()).get();
            } else {
                checkboxes.prop('checked', false);
                this.selectedArticles = [];
            }

        });

        $('#product-table').on('change', '.select-row', (event) => {
            this.toggleSelection($(event.target).val());
            var allChecked = $('#product-table .select-row').length === $('#product-table .select-row:checked').length;
            $('#select-all').prop('checked', allChecked);
        });
    },
    methods: {
        toggleSelection(productId) {
            const index = this.selectedArticles.indexOf(productId);
            if (index === -1) {
                this.selectedArticles.push(productId);
            } else {
                this.selectedArticles.splice(index, 1);
            }
        },
    }
};
</script>