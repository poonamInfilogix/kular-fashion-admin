<template>
    <h4 class="card-title my-2">Transfer Items</h4>
    <div class="table-responsive">
        <table class="table align-middle table-nowrap mb-0 table-striped">
            <thead class="table-light">
                <tr>
                    <th class="align-middle p-2">Article Code</th>
                    <th class="align-middle p-2">Barcode</th>
                    <th class="align-middle p-2">Description</th>
                    <th class="align-middle p-2">Color</th>
                    <th class="align-middle p-2">Size</th>
                    <th class="align-middle p-2">Brand</th>
                    <th class="align-middle p-2">Price</th>
                    <th class="align-middle p-2">Quantity</th>
                    <th class="align-middle p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Add class conditionally based on index -->
                <tr v-for="(item, index) in items" :key="item.code" :class="index % 2 === 0 ? 'even' : 'odd'">
                    <td class="p-1">{{ item.code }}</td>
                    <td class="p-1">{{ item.scanned_barcode }}</td>
                    <td class="p-1">{{ item.description }}</td>
                    <td class="p-1">{{ item.color }}</td>
                    <td class="p-1">{{ item.size }}</td>
                    <td class="p-1">{{ item.brand }}</td>
                    <td class="p-1">{{ item.price }}</td>
                    <td class="p-1">{{ item.quantity }}</td>
                    <td class="p-1">
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

<style scoped>
/* For odd rows */
table tbody tr.odd {
    background-color: #f2f2f2; /* Light gray */
}

/* For even rows */
table tbody tr.even {
    background-color: #ffffff; /* White */
}
</style>
