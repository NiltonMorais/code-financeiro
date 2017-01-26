require('materialize-css');
window.Vue = require('vue');
require('vue-resource');
Vue.http.options.root = "http://localhost:8000/api";
require('./router');