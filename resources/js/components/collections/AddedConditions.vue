<template>
    <div class="row bg-dark-subtle mt-2">
        <div class="col-md-6 my-1" v-for="(addedCondition, index) in conditions" :key="index">
            <div class="row">
                <div :class="addedCondition.condition.subFields?.length > 0 ? 'col-md-5' : 'col-md-10'">
                    <div class="form-group">
                        <label class="mb-0" :for="addedCondition.condition.name">{{ addedCondition.condition.label
                        }}</label>

                        <select class="form-control" :class="{ multiSelect: addedCondition.condition.multiple }"
                            :id="addedCondition.condition.name" :multiple="addedCondition.condition.multiple"
                            :name="`${conditionType}[${addedCondition.condition.name}][]`" v-model="selectedOption"
                            v-if="addedCondition.condition.type === 'select'">
                            <option disabled>Select {{ addedCondition.condition.label }}</option>
                            <option v-for="(field, index) in addedCondition.condition.values" :value="field.id">{{
                                field.value }}</option>
                        </select>

                        <input v-else :id="addedCondition.condition.name" :name="`${conditionType}[${addedCondition.condition.name}]`" :type="addedCondition.condition.type || 'text'" class="form-control"
                            :placeholder="`Enter ${addedCondition.condition.label}`">
                    </div>
                </div>

                <div v-if="addedCondition.condition.subFields?.length > 0" :class="addedCondition.condition.subFields?.length > 0 ? 'col-md-5' : 'col-md-10'">
                    <div v-for="(subField, index) in addedCondition.condition.subFields" :key="index">
                        <div v-if="subField.basedOn && subField.basedOn === selectedOption">
                            <label class="mb-0" :for="subField.number_of_days">{{ subField.label }}</label>
                            <input :type="subField.type" class="form-control" :placeholder="`Enter ${subField.label}`">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="mt-4 btn btn-danger" @click="removeCondition(index)"><i class="fa fa-trash"></i></button>
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
        conditions: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            selectedOption: ''
            /* selectedCondition: '' */
        }
    },
    methods: {
        removeCondition(conditionIndex){
            this.$emit('removeCondition', {
                conditionIndex: conditionIndex,
                conditionType: this.conditionType
            });
        }
    }
}
</script>