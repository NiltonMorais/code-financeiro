import {Bank} from '../services/resources';
import _ from 'lodash';

const state = {
    banks: []
};

const mutations = {
    set(state, banks){
        state.banks = banks;
    }
};

const actions = {
    query(context){
        return Bank.query().then((response) => {
            context.commit('set', response.data.data);
        });
    }
};

const getters = {
    filterBankByName: (state) => (name) => {
        let banks = _.filter(state.banks, (o) => {
            return _.includes(o.name.toLowerCase(), name.toLowerCase());
        });
        return banks;
    },
    mapBanks: (state, getters) => (name) => {
            let banks = getters.filterBankByName(name);
            return banks.map((o) => {
                return {id: o.id, text: o.name};
            });
    }
};

const module = {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};

export default module;
