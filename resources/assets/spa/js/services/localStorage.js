export default {
    set(key, value){
        window.localStorage[key] = value;
        return window.localStorage[key];
    },
    get(key, defaultValue = null){
        return window.localStorage[key] || defaultValue;
    },
    setObject(key, value){
        window.localStorage[key] = JSON.stringify(value);
        return this.getObjetct(key);
    },
    getObjetct(key){
        return JSON.parse(window.localStorage[key] || null);
    },
    remove(key){
        window.localStorage.removeItem(key);
    }
}
