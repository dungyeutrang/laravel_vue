require('../../bootstrap.js');
Vue.component('example', require('./index.vue'));

let VueRouter = require('vue-router');
Vue.use(VueRouter);

require('select2');
require('select2/dist/css/select2.css');

Vue.directive('select',function (el, binding, vnode) {
    $(el).select2().on("select2:select", (e) => {
        el.dispatchEvent(new Event('change', {target: e.target}));
    });
});



// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// Vue.extend(), or just a component options object.
// We'll talk about nested routes later.
const routes = [
    {path: '/edit', component: require('./edit.vue')},
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    routes // short for routes: routes
})


const vm = new Vue({
    el: '#app',
    router:router,
    data: {
        listData: [],
    },
    methods: {
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

