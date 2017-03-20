require('../../bootstrap.js');
Vue.component('example', require('./edit.vue'));
const vm = new Vue({
    el: '#app',
    data : {
        listData: []
    },
});
