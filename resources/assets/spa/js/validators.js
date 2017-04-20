import VeeValidate from 'vee-validate';
import dicPtMessages from './locale/validator/pt-br';

Vue.use(VeeValidate, {
    locale: 'pt-br',
    dictionary: {
        'pt-br': {
            messages: dicPtMessages
        }
    }
});