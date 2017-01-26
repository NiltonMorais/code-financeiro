import {Jwt} from "./resources";
import LocalStorage from "./localStorage";

export default {
    login(email,password){
        return Jwt.accessToken(email, password).then((response)=>{
            LocalStorage.set('token',response.data.token);
            return response;
        });
    }
}