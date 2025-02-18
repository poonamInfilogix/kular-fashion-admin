<template>
    <div class="col-md-6 my-2" v-for="(condition, index) in conditions" :key="index">
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label>{{condition.label}}</label>
                    <select class="form-control multipleSelect" id="tags" multiple name="tags[]">
                        <option disabled>Select Tag</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="mt-4 btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        conditions: {
            type: Array,
            default: []
        }
    },
    data(){
        return {
            selectedCondition: ''
        }
    },
    methods:{
       
    }
}
</script>