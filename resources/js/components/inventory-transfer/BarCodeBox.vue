<template>
    <div class="search-box mb-2">
        <div class="position-relative">
            <input type="number" v-model="query" class="form-control" placeholder="Enter barcode" @input="addToCart">
            <i class="bx bx-barcode search-icon"></i>
        </div>
    </div>
</template> 
<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            query: '',
        };
    },
    methods: {
        async addToCart() {
            if(this.query.toString().length === 13){
                const barcode = this.query;
                this.query = '';
                const response = await axios.get(`/product-validate/${barcode}`);
                const {product} = response.data;
                if (product) {
                    this.$emit('add-to-cart', product);
                    console.log(this.$parent.orderItems);
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Product Barcode is invalid.',
                        icon: 'error',
                        confirmButtonText: 'Okay'
                    });
                }
            }
        },
    },
};
</script>