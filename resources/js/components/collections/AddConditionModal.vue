<template>
    <div class="modal fade" id="addConditionModal" tabindex="-1" aria-labelledby="addConditionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addConditionModalLabel">Add New Condition</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="selectOption" class="form-label">Select Condition</label>
                        <select class="form-select" id="selectCondition" aria-label="Select option"
                            v-model="selectedCondition">
                            <option v-for="(label, condition) in availableConditions" :key="condition"
                                :value="condition">
                                {{ label }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" :disabled="selectedCondition === ''"
                        @click="saveCondition">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        conditionType: {
            type: String,
            default: 'include'
        },
        conditionMap: {
            type: Object,
            default: {}
        },
        addedConditions: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            selectedCondition: '',
        }
    },
    computed: {
        availableConditions() {
            const addedConditionNames = this.addedConditions.map(addedCondition => addedCondition.name);

            return Object.keys(this.conditionMap).reduce((result, key) => {
                if (!addedConditionNames.includes(key)) {
                    result[key] = this.conditionMap[key];
                }
                return result;
            }, {});
        }
    },
    methods: {
        saveCondition() {
            const conditionLabel = this.conditionMap[this.selectedCondition];
            const conditionObject = {
                name: this.selectedCondition,
                label: conditionLabel
            };

            this.$emit('addCondition', conditionObject);
            $('#addConditionModal').modal('hide');
        }
    }
}
</script>