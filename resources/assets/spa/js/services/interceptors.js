import Auth from './auth';

Vue.http.interceptors.push((request,next) => {
    request.headers.set('Authorization', Auth.getAuthorizationHeader());
    next();
});