<template>
    <div class="col-md-11">
        <div class="panel panel-default">
            <div style="height:55px" class="panel-heading">
                <span> Manage Data Category</span>
                <a href="/admin/category/edit" class="btn btn-success pull-right">Create <span
                        class="glyphicon glyphicon-plus"></span></a>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Update</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>
                    <template v-for="item in data">
                        <tr>
                            <td>{{item.id}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.updated_at | formatDate}}</td>
                            <td><a class="btn btn-warning" :href="'/admin/category/edit/'+item.id">Edit &nbsp;<span
                                    class="glyphicon glyphicon-pencil"></span></a></td>
                            <td><a @click.prevent="remove(item.id)" class="btn btn-danger"
                                   :href="'/admin/category/edit/'+item.id">Delete
                                &nbsp;<span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data'],
        methods: {
            remove: function (id) {
                this.data.forEach(function (value, index, arr) {
                    if (value.id == id) {
                        Vue.http.get('/admin/category/delete/' + id).then(response => {
                            arr.splice(index, 1);
                        }, response => {
                            alert('Delete error !');
                        });
                        return index;
                    }
                });
            }
        }
    }
</script>
