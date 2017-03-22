require('./bootstrap');

Vue.component('admin-menu', require('./components/AdminMenu.vue'));
Vue.component('delete-action', require('./components/DeleteAction.vue'));

const app = new Vue({
    el: '#app'
});
