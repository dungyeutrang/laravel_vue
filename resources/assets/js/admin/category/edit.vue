<template>
    <div class="col-md-11">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span v-if="id"> Edit Category </span>
                <span v-else>  Create Category </span>
            </div>
            <div class="panel-body">
                <form action="" class="form form-vertical">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" v-model="name" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <a href="/admin/category" class="btn btn-default" >Back</a>
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
            return {name: ''};
        },
        mounted: function () {
            if (this.id) {
                this.getData();
            }
        },
        methods: {
            getData: function () {
                Vue.http.get('/admin/category/getRecord/' + this.id).then(response => {
                    let data = JSON.parse(response.body);
                    this.name = data.name;
                }, response => {
                })
            }
        }
    }
</script>
