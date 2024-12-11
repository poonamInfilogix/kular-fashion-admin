<template>
    <div class="row">
        <div class="col-3">
            <label>From</label>
            <select class="form-control" v-model="fromStore">
                <option disabled value="">Select a store</option>
                <option v-for="(branch, index) in defaultBranches" :key="index" :value="branch.id">
                    {{ branch.name }}
                </option>
            </select>
        </div>
        <div class="col-3">
            <label>To</label>
            <select class="form-control" v-model="toStore">
                <option disabled value="">Select a store</option>
                <option v-for="(branch, index) in defaultBranches" :key="index" :value="branch.id"
                    :disabled="branch.id === fromStore">
                    {{ branch.name }}
                </option>
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <BarCodeBox @transfer-item="transferItem" />
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <TransferItemTable :items="items" @update-items="updateItems"/>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 text-right">
            <button 
                class="btn btn-success"
                @click="handleTransfer"
                :disabled="!fromStore || !toStore || fromStore === toStore || items.length === 0">
                Transfer
            </button>
        </div>
    </div>
    <AddManufactureBarcodeModal ref="virtualKeyboard" :item="itemToBeAdd" @item-scanned="itemScanned" />
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import BarCodeBox from '../components/inventory-transfer/BarCodeBox.vue';
import TransferItemTable from '../components/inventory-transfer/TransferItemTable.vue';
import AddManufactureBarcodeModal from '../components/inventory-transfer/AddManufactureBarcodeModal.vue';

export default {
    components: {
        BarCodeBox,
        TransferItemTable,
        AddManufactureBarcodeModal
    },
    props: {
        defaultBranches: {
            type: Array,
            required: true,
        },
        currentUserStore: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            fromStore: this.currentUserStore,
            toStore: null,
            itemToBeAdd: {},
            items: localStorage.getItem('transferItems') ? JSON.parse(localStorage.getItem('transferItems')) : []
        };
    },
    watch: {
        fromStore(newVal) {
            if (newVal === this.toStore) {
                this.selectAnotherStore('toStore');
            }
        },
        toStore(newVal) {
            if (newVal === this.fromStore) {
                this.selectAnotherStore('fromStore');
            }
        },
    },
    methods: {
        async handleTransfer() {
            if (!this.fromStore || !this.toStore || this.fromStore === this.toStore || this.items.length === 0) {
                return; // Disable button if no valid transfer data
            }
            const transferData = {
                from_store_id: this.fromStore,
                to_store_id: this.toStore,
                items: this.items
            }; 
            try {
                const response = await axios.post('/inventory-transfer-items', transferData);

                if (response.data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Items transferred successfully.',
                        icon: 'success',
                        confirmButtonText: 'Okay'
                    });

                    localStorage.removeItem('transferItems');
                    this.items = [];
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an issue with the transfer.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                }
            } catch (error) {
                console.error('Error during transfer:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Something went wrong. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'Okay'
                });
            }
        },

        selectAnotherStore(target) {
            const availableBranches = this.defaultBranches.filter(
                branch => branch.id !== this[target]
            );

            if (availableBranches.length > 0) {
                this[target] = availableBranches[0].id;
            }
        },
        updateItems(updatedItems) {
            localStorage.setItem('transferItems', JSON.stringify(updatedItems));
            this.items = updatedItems;
        },
        itemScanned(scanned_barcode){
            this.itemToBeAdd.manufacture_barcode = scanned_barcode;
            this.transferItem(this.itemToBeAdd);
            this.itemToBeAdd = {};
        },
        transferItem(item) {
            if (!item.manufacture_barcode) {
                this.itemToBeAdd = item;

                const addManufactureBarcodeModal = document.getElementById('addManufactureBarcodeModal');
                new bootstrap.Modal(addManufactureBarcodeModal).show();
                return;
            }

            let products = [];
            if (localStorage.getItem('transferItems')) {
                products = JSON.parse(localStorage.getItem('transferItems'));
            }

            const existingProductIndex = products.findIndex(product => product.barcode === item.barcode);

            if (existingProductIndex !== -1) {
                products[existingProductIndex].quantity += 1;
                if (products[existingProductIndex].quantity > products[existingProductIndex].total_quantity) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Item maximum quantity exceed',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                    return;
                }

            } else {
                item.quantity = 1;
                products.push(item);
            }

            localStorage.setItem('transferItems', JSON.stringify(products));

            this.items = products;
        },
    },
};
</script>
