require('./bootstrap');

Vue.component('admin-menu', require('./components/AdminMenu.vue'));

const app = new Vue({
    el: '#app'
});
