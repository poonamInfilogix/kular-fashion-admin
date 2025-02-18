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
            
            <AddedConditions :conditions="conditions.include"></AddedConditions>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 d-flex justify-content-between">
                    <h6>Exclude Conditions</h6>
                    <button type="button" class="btn btn-sm btn-secondary" @click="addNewCondition('exclude')">Add new
                        condition</button>
                </div>
            </div>
            <AddedConditions :conditions="conditions.exclude"></AddedConditions>
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

    <IncludeConditionModal :conditionType="conditionType" @addCondition="addCondition"></IncludeConditionModal>
</template>

<script>
import IncludeConditionModal from '../components/collections/includeConditionModal.vue';
import AddedConditions from '../components/collections/AddedConditions.vue';

export default {
    components: {
        IncludeConditionModal,
        AddedConditions
    },
    props: {
        conditionDependencies: {
            type: Array,
            requied: true
        }
    },
    data() {
        return{
            conditionType: 'include',
            conditions: {
                'include': [],
                'exclude': []
            },
        }
    },
    mounted(){
        $('[name="collection_image"]').change(function(event) {
            var reader = new FileReader();
            reader.onload = function(e) {
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
        addCondition(condition){
            if(condition.name==='tags'){
                condition.type='select';
                condition.values=this.conditionDependencies.tags;
            }

            console.log('condition',condition)
            this.conditions[this.conditionType].push({ condition: condition, value: '' });
        }
    }
};
</script>