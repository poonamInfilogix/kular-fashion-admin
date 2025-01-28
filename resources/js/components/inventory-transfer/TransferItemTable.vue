<template>
    <h4 class="card-title my-2">Transfer Items</h4>
    <div class="table-responsive">
        <table class="table align-middle table-nowrap mb-0">
            <thead class="table-light">
                <tr>
                    <th class="align-middle">Article Code</th>
                    <th class="align-middle">Barcode</th>
                    <th class="align-middle">Description</th>
                    <th class="align-middle">Color</th>
                    <th class="align-middle">Size</th>
                    <th class="align-middle">Brand</th>
                    <th class="align-middle">Price</th>
                    <th class="align-middle">Quantity</th>
                    <th class="align-middle">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in items" :key="item.code">
                    <td>{{ item.code }}</td>
                    <td>{{ item.scanned_barcode }}</td>
                    <td>{{ item.description }}</td>
                    <td>{{ item.color }}</td>
                    <td>{{ item.size }}</td>
                    <td>{{ item.brand }}</td>
                    <td>{{ item.price }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="deleteItem(index)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
export default {
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    emits: ['update-items'],
    methods: {
        deleteItem(index) {
            if (confirm("Are you sure you want to delete this item?")) {
                this.items.splice(index, 1);
                this.$emit('update-items', this.items);
            }
        }
    }
};
</script>