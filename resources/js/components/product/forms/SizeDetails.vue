<template>
    <div>
        <!-- Modal for size details -->
        <div class="modal fade" id="sizeDetailsModal" tabindex="-1" role="dialog"
            aria-labelledby="sizeDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered  modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modalTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p v-if="selectedSizeScale">
                            <strong>Size Scale:</strong> {{ selectedSizeScale.size_scale }}
                        </p>

                        <table class="table table-bordered" v-if="selectedSizeScale">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col">Size</th>
                                <th scope="col" v-for="(size, index) in selectedSizeScale.sizes" :key="index"> {{ size.size }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Quantity</th>
                                    <td v-for="(size, index) in selectedSizeScale.sizes" :key="index">
                                        <input type="number" name="quantity" class="form-control" min="0">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">MRP</th>
                                    <td v-for="(size, index) in selectedSizeScale.sizes" :key="index">
                                        <input type="number" name="mrp" class="form-control" min="0">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Supplier</th>
                                    <td v-for="(size, index) in selectedSizeScale.sizes" :key="index">
                                        <input type="number" name="supplier" class="form-control" min="0">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        selectedSizeScale: {
            type: Object,
            required: true,
        },
    },
    computed: {
        modalTitle() {
        return this.selectedSizeScale
            ? `${this.selectedSizeScale.size_scale} Details`
            : "No Size Scale Selected";
        },
    },
    methods: {
        showModal() {
            $('#sizeDetailsModal').modal('show');
        },
        hideModal() {
            $('#sizeDetailsModal').modal('hide');
        },
    },
    watch: {
        selectedSizeScale(newValue) {
            if (newValue) {
                this.showModal();
            }
        },
    },
};
</script>

<style scoped>
/* Add custom styles for the modal if needed */
</style>