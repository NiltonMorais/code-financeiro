require('./bootstrap');

Vue.component('site-menu', require('./components/SiteMenu.vue'));
Vue.component('subscription-create', require('./components/subscription/SubscriptionCreate.vue'));

const app = new Vue({
    el: '#app'
});
