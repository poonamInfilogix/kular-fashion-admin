<template>
    <div class="modal fade" id="addManufactureBarcodeModal" tabindex="-1"
        aria-labelledby="addManufactureBarcodeModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addManufactureBarcodeModalLabel">Add manufacture code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="search-box mb-2">
                        <div class="position-relative">
                            <input type="number" v-model="query" class="form-control" placeholder="Scan barcode"
                                @input="addManufactureBarcode">
                            <i class="bx bx-barcode search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            query: '',
        };
    },
    methods: {
        async addManufactureBarcode() {
            if (String(this.query).length === 12 || String(this.query).length === 13) {
                const response = await axios.post('/api/products/add-manufacture-barcode', {
                    id: this.item.id,
                    barcode: String(this.query),
                });

                const { success } = response.data;
                if(success){
                    const addManufactureBarcodeModal = document.getElementById('addManufactureBarcodeModal');
                    addManufactureBarcodeModal.classList.remove('show');
                    addManufactureBarcodeModal.style.display = 'none';
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) {
                        backdrop.remove();
                    }

                    this.$emit('item-scanned', this.query);
                    this.query = '';
                }
            }
        }
    }
}
</script>