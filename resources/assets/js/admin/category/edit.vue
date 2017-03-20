<template>
    <div class="col-md-11">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span v-if="id"> Edit Category </span>
                <span v-else>  Create Category </span>
            </div>
            <div class="panel-body">
                <span>{{name}}</span>
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
            this.getData();
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
