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
          <span v-if="sizeScale.sizes.length > 0">
            ({{ sizeScale.sizes[0].size }} - {{ sizeScale.sizes[sizeScale.sizes.length - 1].size }})
          </span>
        </option>
      </select>
  
      <!-- Display error message if exists -->
      <span v-if="error" class="invalid-feedback">{{ error }}</span>
      
      <!-- Include SizeDetails component -->
      <SizeDetails :selectedSizeScale="getSelectedSizeScale" />
    </div>
  </template>
  
  <script>
  import SizeDetails from '../forms/SizeDetails.vue'; // Make sure the path is correct
  
  export default {
    props: {
      initialSizeScales: {
        type: Array,
        required: true,
      },
      initialSizeScaleId: {
        type: [String, Number],
        default: '',
      },
      validationError: {
        type: String,
        default: '',
      },
    },
    data() {
      return {
        sizeScales: this.initialSizeScales,
        selectedSizeScaleId: this.initialSizeScaleId,
        error: this.validationError,
      };
    },
    computed: {
      // Find the selected size scale object from the list based on the selected ID
      getSelectedSizeScale() {
        return this.sizeScales.find(
          (sizeScale) => sizeScale.id === parseInt(this.selectedSizeScaleId)
        );
      },
    },
    mounted() {
      $(this.$refs.chosenSelect).chosen().change((e) => {
        this.selectedSizeScaleId = $(e.target).val();
      });
    },
    methods: {
      changeSizeScale() {
        // Custom logic for when the size scale is changed
      },
    },
    watch: {
      selectedSizeScaleId(newValue) {
        // Optionally, trigger the modal or any additional logic when the value changes
        if (newValue) {
          // You can also trigger the modal to show when the selected size scale changes
          $('#sizeDetailsModal').modal('show')
        }
      },
    },
    components: {
      SizeDetails,
    },
  };
  </script>
  