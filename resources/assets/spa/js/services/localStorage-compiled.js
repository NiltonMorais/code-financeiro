"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.default = {
    set: function set(key, value) {
        window.localStorage[key] = value;
        return window.localStorage[key];
    },
    get: function get(key) {
        var defaultValue = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

        return window.localStorage[key] || defaultValue;
    },
    setObject: function setObject(key, value) {},
    getObjetct: function getObjetct(key) {},
    remove: function remove(key) {
        window.localStorage.removeItem(key);
    }
};

//# sourceMappingURL=localStorage-compiled.js.map