import Echo from "laravel-echo";
import JwtToken from "./services/jwt-token";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '722fe87d08a56a1d5599'
});

const changeJwtTokenInEcho = value => {
    window.Echo.connector.pusher.config.auth.headers['Authorization'] =
        JwtToken.getAuthorizationHeader();
};

JwtToken.event('updateToken', value => {
    changeJwtTokenInEcho(value);
});

changeJwtTokenInEcho(JwtToken.token);