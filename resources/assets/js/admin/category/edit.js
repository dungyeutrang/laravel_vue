require('../../bootstrap.js');
require('select2');
require('select2/dist/css/select2.css');

Vue.directive('select',function (el, binding, vnode) {
    $(el).select2().on("select2:select", (e) => {
        el.dispatchEvent(new Event('change', {target: e.target}));
    });
});
Vue.component('example', require('./edit.vue'));
const vm = new Vue({
    el: '#app',
    data: {
        listData: [],
    },
});
