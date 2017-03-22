<template>
    <div class="col-md-11">
        <div class="panel panel-default">
            <div style="height:55px" class="panel-heading">
                <span> Manage Data Provider</span>
                <a href="/admin/provider/edit" class="btn btn-success pull-right">Create <span
                        class="glyphicon glyphicon-plus"></span></a>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>
                    <template v-for="item in data">
                        <tr>
                            <td>{{item.id}}</td>
                            <td>{{item.name}}</td>
                            <td>{{item.email}}</td>
                            <td>{{item.avatar}}</td>
                            <td>{{item.address}}</td>
                            <td><a class="btn btn-warning" :href="'/admin/provider/edit/'+item.id">Edit &nbsp;<span
                                    class="glyphicon glyphicon-pencil"></span></a></td>
                            <td><a @click.prevent="remove(item.id)" class="btn btn-danger"
                                   :href="'/admin/provider/delete/'+item.id">Delete
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
                if (!confirm('Are you sure ?')) {
                    return;
                }
                this.data.forEach(function (value, index, arr) {
                    if (value.id == id) {
                        Vue.http.get('/admin/provider/delete/' + id).then(response => {
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
