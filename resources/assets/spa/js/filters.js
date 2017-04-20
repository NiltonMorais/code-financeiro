import moment from 'moment';
import 'moment/locale/pt-br';

moment.locale('pt-br');

Vue.filter('dateFormat', {
    read(value){
        if (value && typeof value !== undefined) {
            let date = moment(value);
            return date.isValid() ? date.format('DD/MM/YYYY') : value;
        }
        return value;
    },
    write(value){
        let date = moment(value,'DD/MM/YYYY');
        return date.isValid() ? date.toDate() : value;
    }
});