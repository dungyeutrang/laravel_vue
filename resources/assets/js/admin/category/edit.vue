<template>
    <div class="col-md-11">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span v-if="id"> Edit Category </span>
                <span v-else>  Create Category </span>
            </div>
            <div class="panel-body">
                <form @submit.prevent="saveForm" action="" class="form form-vertical">
                    <div class="form-group" :class="{'has-error':validateName}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" v-model="name" name="name" id="name">
                        <span v-if="validateName"  class="help-block">Name is required !</span>
                    </div>

                    <div class="form-group">
                        <label for="parent_id">Parent Category</label>
                        <select v-select="parent_id" v-model="parent_id" name="parent_id" id="parent_id"
                                class="form-control">
                            <option value="0">Select Parent Category</option>
                            <option :selected="category.id==parent_id" v-for="category in listCategory"
                                    :value="category.id">{{category.name}}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <a href="/admin/category" class="btn btn-default">Back</a>
                        <button class="btn btn-success" v-if="id">Update</button>
                        <button class="btn btn-success" v-else>Add</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['id'],
        data: function () {
            return {name: '', parent_id: 0, listCategory: [], submited: false, error: false};
        },
        computed: {
            validateName: function () {
                this.error = this.submited && !this.name.trim()
                return this.error;
            },
        },
        mounted: function () {
            $('#parent_id').select2();
            if (this.id) {
                return this.getData();
            }
            this.getListCategory();
        },
        methods: {
            getData: function () {
                Vue.http.get('/admin/category/getRecord/' + this.id).then(response => {
                    let dataJson = response.body;
                    this.name = dataJson.data.name;
                    this.parent_id = dataJson.data.parent_id;
                    this.listCategory = dataJson.listCategory
                }, response => {
                })
            },
            getListCategory: function () {
                Vue.http.get('/admin/category/getListCategory/').then(response => {
                    let dataJson = response.body;
                    this.listCategory = dataJson;
                }, response => {
                })
            },
            saveForm: function () {
                this.submited = true;
                if (!this.validateName) {
                    Vue.http.post('/admin/category/saveData', {
                        _token: window.Laravel.csrfToken,
                        name: this.name,
                        id: this.id,
                        parent_id: this.parent_id
                    })
                        .then(response => {
                            location.assign('/admin/category');
                        }, response => {
                            alert('Save data error !');
                        });
                }
            }
        }
    }
</script>
