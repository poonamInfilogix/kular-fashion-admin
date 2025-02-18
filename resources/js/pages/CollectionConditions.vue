<template>
    <div class="row mb-2">
        <div class="col-sm-6 col-md-4">
            <div class="form-group">
                <div class="mb-3">
                    <label for="collection_name">Collection Name<span class="text-danger">*</span></label>
                    <input class="form-control" name="collection_name" value="" placeholder="Enter Collection Name" />
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="color-status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <h6>Include Conditions</h6>
                    <button type="button" class="btn btn-sm btn-secondary" @click="addNewCondition('include')">Add new
                        condition</button>
                </div>
            </div>

            <AddedConditions :conditionType="'include'" :conditions="conditions.include" @removeCondition="removeCondition"></AddedConditions>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <h6>Exclude Conditions</h6>
                    <button type="button" class="btn btn-sm btn-secondary" @click="addNewCondition('exclude')">Add new
                        condition</button>
                </div>
            </div>
            <AddedConditions :conditionType="'exclude'" :conditions="conditions.exclude" @removeCondition="removeCondition"></AddedConditions>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="mb-3">
                <label for="status">Image</label>
                <input type="file" name="collection_image" class="form-control" accept="image/*">

                <div class="row d-block">
                    <div class="col-md-8 mt-2">
                        <img src="" id="preview-collection" class="img-fluid w-50" name="image" hidden>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-lg-6 mb-2">
            <button type="submit" class="btn btn-primary w-md">Submit</button>
        </div>
    </div>

    <AddConditionModal :conditionType="conditionType" :addedConditions="conditions[conditionType]"
        @addCondition="addCondition"></AddConditionModal>
</template>

<script>
import AddConditionModal from '../components/collections/AddConditionModal.vue';
import AddedConditions from '../components/collections/AddedConditions.vue';

export default {
    components: {
        AddConditionModal,
        AddedConditions
    },
    props: {
        conditionDependencies: {
            type: Array,
            requied: true
        }
    },
    data() {
        return {
            conditionType: 'include',
            conditions: {
                'include': [],
                'exclude': []
            },
        }
    },
    mounted() {
        $('[name="collection_image"]').change(function (event) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-collection').attr('src', e.target.result).removeAttr('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        });
    },
    methods: {
        addNewCondition(conditionType) {
            this.conditionType = conditionType;
            $('#addConditionModal').modal('show');
        },
        removeCondition(payload){
            this.conditions[payload.conditionType].splice(payload.conditionIndex, 1);
        },
        addCondition(condition) {
            switch (condition.name) {
                case 'tags':
                    condition.type = 'select';
                    condition.multiple = true;
                    condition.values = this.conditionDependencies.tags;
                    break;
                case 'categories':
                    condition.type = 'select';
                    condition.multiple = true;
                    condition.values = this.conditionDependencies.ProductTypes;
                    break;
                case 'price_list':
                    condition.type = 'number';
                    break;
                case 'price_range':
                    condition.type = 'range';
                    condition.values = { min: 0, max: this.conditionDependencies.maxProductPrice };
                    break;
                case 'published_within':
                    condition.type = 'select';

                    condition.values = [{
                        id: 'Days',
                        value: 'Days',
                    }, {
                        id: 'Range',
                        value: 'Range',
                    }];

                    condition.subFields = [{
                        type: 'number',
                        name: 'number_of_days',
                        label: 'Number Of Days',
                        value: 30,
                        basedOn: 'Days'
                    }, {
                        type: 'date',
                        name: 'published_between',
                        label: 'Published Between',
                        multiple: true,
                        basedOn: 'Range'
                    }];


                    break;
                case 'price_status':
                    condition.type = 'select';
                    condition.values = [{
                        id: 'Reduce Item Only',
                        value: 'Reduce Item Only'
                    }, {
                        id: 'Full Price Item Only',
                        value: 'Full Price Item Only'
                    }];
                    break;
                default:
                    condition.type = 'text';
                    break;
            }

            this.conditions[this.conditionType].push({ condition: condition, value: '' });

            setTimeout(function () {
                if (condition.type === 'select' && condition.multiple) {
                    $('.multiSelect').each(function () {
                        let defaultPlaceholder = $(this).find('option').first().html();

                        $(this).chosen({
                            width: '100%',
                            placeholder_text_multiple: defaultPlaceholder,
                        });
                    });
                }
            });
        }
    }
};
</script>