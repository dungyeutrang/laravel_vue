<template>
    <div class="col-md-11">
        <div class="box">
            <div style="height:55px" class="box-header with-border text-center">
                <span class="pull-left"> Manage Data Category</span>
                <input v-model="searchValue" type="text" :value="searchValue" name="search-input"
                       class="input-custom input-search"
                       id="search-input"
                       placeholder="Search..."/>
                <a href="/admin/category/edit" class="btn btn-success pull-right">Create <span
                        class="glyphicon glyphicon-plus"></span></a>
            </div>
            <div class="box-body">
                <table class="table table-hover">
                    <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Update</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    </thead>
                    <tbody>
                    <template v-for="(item,index) in filteredData">
                        <tr>
                            <td>{{index+1}}</td>
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
            <testcomponent></testcomponent>
        </div>
    </div>
</template>
<script>
    import TestComponent from './test.vue';
    export default {
        props: ['data'],
        components: {
            testcomponent: TestComponent
        },
        data: function () {
            return {searchValue: ''};
        },
        computed: {
            filteredData: function () {
                let self = this
                return self.data.filter(function (item) {
                    let searchRegex = new RegExp(self.searchValue, 'i')
                    return (
                        searchRegex.test(item.name) ||
                        searchRegex.test(item.updated_at)
                    )
                })
            }
        },
        methods: {
            remove: function (id) {
                if (!confirm('Are you sure ?')) {
                    return;
                }
                this.data.forEach(function (value, index, arr) {
                    if (value.id == id) {
                        Vue.http.get('/admin/category/delete/' + id).then(response => {
                            arr.splice(index, 1);
                            let listParentId = [id];
                            let isFind = true;
                            while (isFind) {
                                isFind = false;
                                arr.forEach(function (vl, i, arr2) {
                                    if (listParentId.indexOf(vl.parent_id) >= 0) {
                                        isFind = true;
                                        console.log(arr2);
                                        arr2.splice(i, 1);
                                        arr = arr2;
                                    }
                                })
                            }
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
