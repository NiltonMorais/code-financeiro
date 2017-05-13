require('./bootstrap');

Vue.component('site-menu', require('./components/SiteMenu.vue'));
Vue.component('subscription-create', require('./components/SubscriptionCreate.vue'));

const app = new Vue({
    el: '#app'
});
