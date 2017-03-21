require('../../bootstrap.js');
Vue.component('example', require('./index.vue'));
const vm = new Vue({
    el: '#app',
    data : {
        listData: [],
        a:1
    },
    methods : {
        getData: function () {
            this.$http.get('/admin/category/getData').then(response => {
                this.listData = JSON.parse(response.body);
            }, response => {
                alert('Load data error !');
            });
        }
    }
});
vm.getData();

