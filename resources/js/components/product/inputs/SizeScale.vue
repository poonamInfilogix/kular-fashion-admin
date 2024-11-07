<template>
    <div>
      <label for="size_scale_id">
        Size Scale<span class="text-danger">*</span>
      </label>
      
      <select
        ref="chosenSelect"
        v-model="selectedSizeScale"
        name="size_scale_id"
        id="size_scale_id"
        class="form-control"
        :class="{'is-invalid': error}"
        @change="changeSizeScale"
      >
        <option value="" disabled selected>Select size scale</option>
        <option
          v-for="sizeScale in sizeScales"
          :key="sizeScale.id"
          :value="sizeScale.id"
        >
          {{ sizeScale.size_scale }}
        </option>
      </select>
  
      <!-- Display error message if exists -->
      <span v-if="error" class="invalid-feedback">{{ error }}</span>
    </div>
</template>

<script>
export default {
    props: {
        initialSizeScales: {
            type: Array,
            required: true
        },
        initialSizeScaleId: {
            type: [String, Number],
            default: ''
        },
        validationError: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            sizeScales: this.initialSizeScales,
            selectedSizeScale: this.initialSizeScaleId,
            error: this.validationError,
        };
    },
    mounted() {
        // Initialize Chosen after the component is mounted
        $(this.$refs.chosenSelect).chosen().change((e) => {
            // Update the selected value when Chosen changes
            this.selectedSizeScale = $(e.target).val();
        });
    },
    watch: {
        selectedSizeScale(newValue) {
            console.log('newValue', newValue)
            // Optionally, update Chosen's selected value when the Vue model changes
            $(this.$refs.chosenSelect).val(newValue).trigger('chosen:updated');
        }
    },
    beforeDestroy() {
        // Destroy Chosen instance when the component is destroyed to avoid memory leaks
        $(this.$refs.chosenSelect).chosen('destroy');
    }
};
</script>

<style scoped>
/* Optionally add some custom styles for Chosen */
.chosen-select {
    width: 100%;
    /* Adjust as needed */
}
</style>