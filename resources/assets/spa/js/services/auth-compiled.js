"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _resources = require("./resources");

var _localStorage = require("./localStorage");

var _localStorage2 = _interopRequireDefault(_localStorage);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = {
    login: function login(email, password) {
        return _resources.Jwt.accessToken(email, password).then(function (response) {
            _localStorage2.default.set('token', response.data.token);
            return response;
        });
    }
};

//# sourceMappingURL=auth-compiled.js.map