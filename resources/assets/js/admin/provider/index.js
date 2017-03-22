require('../../bootstrap.js');
Vue.component('example', require('./index.vue'));
const vm = new Vue({
    el: '#app',
    data : {
        listData: [],
    },
    methods : {
        getData: function () {
            this.$http.get('/admin/provider/getData').then(response => {
            }, response => {
                alert('Load data error !');
            });
        }
    }
});
vm.getData();