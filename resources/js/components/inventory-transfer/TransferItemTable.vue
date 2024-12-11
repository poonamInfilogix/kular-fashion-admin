<template>
    <h4 class="card-title my-2">Transfer Items</h4>
    <div class="table-responsive">
        <table class="table align-middle table-nowrap mb-0">
            <thead class="table-light">
                <tr>
                    <th class="align-middle">Article Code</th>
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
                <tr v-for="item in items">
                    <td>{{ item.code }}</td>
                    <td>{{ item.description }}</td>
                    <td>{{ item.color }}</td>
                    <td>{{ item.size }}</td>
                    <td>{{ item.brand }}</td>
                    <td>{{ item.price }}</td>
                    <td>{{ item.quantity }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm">
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
    }
};
</script>