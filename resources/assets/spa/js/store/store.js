import Vuex from 'vuex';
import auth from './auth';
import bankAccount from './bank-account';
import bank from './bank';
import categoryModule from './category';
import {CategoryExpense, CategoryRevenue} from '../services/resources';

let categoryRevenue = categoryModule(), categoryExpense = categoryModule();
categoryRevenue.state.resource =  CategoryRevenue;
categoryExpense.state.resource =  CategoryExpense;



export default new Vuex.Store({
    modules: {
        auth,
        bankAccount,
        bank,
        categoryRevenue: categoryRevenue,
        categoryExpense: categoryExpense,
    }
});
