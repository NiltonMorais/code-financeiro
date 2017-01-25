'use strict';

var _App = require('./components/App.vue');

var _App2 = _interopRequireDefault(_App);

var _vueRouter = require('vue-router');

var _vueRouter2 = _interopRequireDefault(_vueRouter);

var _router = require('./router.map');

var _router2 = _interopRequireDefault(_router);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var router = new _vueRouter2.default();

router.map(_router2.default);

router.start({
    components: {
        'app': _App2.default
    }
}, 'body');

//# sourceMappingURL=router-compiled.js.map