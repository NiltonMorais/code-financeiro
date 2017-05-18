import JwtToken from './jwt-token'
import store from '../store/store';
import appConfig from './appConfig';

Vue.http.interceptors.push((request, next) => {
    request.headers.set('Authorization', JwtToken.getAuthorizationHeader());
    next();
});

let logout = ()=>{
    store.dispatch('clearAuth');
    window.location.href = appConfig.login_url;
};

Vue.http.interceptors.push((request, next) => {
    next((response) => {
        switch(response.status) {
            case 401:    // token expirado
                return JwtToken.refreshToken()
                    .then(() => {
                        return Vue.http(request);
                    })
                    .catch(() => {
                        logout();
                    });
                break;
            default:
                if(response.data &&
                    response.data.hasOwnProperty('error') &&
                    response.data.error.includes('subscription')){
                    logout();
                }
        }
    });
});