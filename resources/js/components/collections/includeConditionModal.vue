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
                            <option value="tags">Have one of these tags</option>
                            <option value="category">Be in the category</option>
                            <option value="price_list">Be in the price list</option>
                            <option value="price_range">Be in the price range</option>
                            <option value="price_status">Have the price status</option>
                            <option value="published_within">Have been published within</option>
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
        }
    },
    data() {
        return {
            selectedCondition: '',
            conditionMap: {
                tags: "Have one of these tags",
                category: "Be in the category",
                price_list: "Be in the price list",
                price_range: "Be in the price range",
                price_status: "Have the price status",
                published_within: "Have been published within"
            }
        }
    },
    methods: {
        saveCondition() {
            const conditionLabel = this.conditionMap[this.selectedCondition];
            const conditionObject = {
                name: this.selectedCondition,
                label: conditionLabel
            };
            
            this.$emit('addCondition', conditionObject)
        }
    }
}
</script>