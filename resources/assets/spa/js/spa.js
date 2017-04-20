import appConfig from './services/appConfig';

require('materialize-css');
window.Vue = require('vue');
require('vue-resource');
require('vuex');

Vue.http.options.root = appConfig.api_url;

require('./filters');
require('./validators');
require('./services/interceptors');
require('./router');