import {Jwt} from "./resources";
import LocalStorage from "./localStorage";
import {User} from './resources';

const TOKEN = 'token';
const USER = 'user';

const afterLogin = (response) => {
    User.get()
        .then((response) => LocalStorage.setObject(USER,response.data));
};

export default {
    login(email,password){
        return Jwt.accessToken(email, password).then((response)=>{
            LocalStorage.set('token',response.data.token);
            afterLogin(response);
            return response;
        });
    },
    logout(){
        let afterLogout = () => {
            LocalStorage.remove(TOKEN);
            LocalStorage.remove(USER);
        };

        return Jwt.logout().
            then(afterLogout())
            .catch(afterLogout());
    },
    getAuthorizationHeader(){
        return `Bearer ${LocalStorage.get(TOKEN)}`;
    },
    user(){
        return LocalStorage.getObjetct(USER);
    }
}