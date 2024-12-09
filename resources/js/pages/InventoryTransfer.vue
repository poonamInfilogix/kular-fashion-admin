<template>
    <div class="row">
        <div class="col-3">
            <label>From</label>
            <select class="form-control" v-model="fromStore">
                <option disabled value="">Select a store</option>
                <option 
                    v-for="(branch, index) in defaultBranches" 
                    :key="index" 
                    :value="branch.id">
                    {{ branch.name }}
                </option>
            </select>
        </div>
        <div class="col-3">
            <label>To</label>
            <select class="form-control" v-model="toStore">
                <option disabled value="">Select a store</option>
                <option 
                    v-for="(branch, index) in defaultBranches" 
                    :key="index" 
                    :value="branch.id"
                    :disabled="branch.id === fromStore">
                    {{ branch.name }}
                </option>
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <BarCodeBox @add-to-cart="addToCart" />
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <TransferItemTable />
        </div>
    </div>
</template>

<script>
import BarCodeBox from '../components/inventory-transfer/BarCodeBox.vue';
import TransferItemTable from '../components/inventory-transfer/TransferItemTable.vue';

export default {
    components: {
        BarCodeBox,
        TransferItemTable
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
        selectAnotherStore(target) {
            const availableBranches = this.defaultBranches.filter(
                branch => branch.id !== this[target]
            );

            if (availableBranches.length > 0) {
                this[target] = availableBranches[0].id;
            }
        },
        addToCart(product) {
            console.log('product',product);
        }
    },
};
</script>
