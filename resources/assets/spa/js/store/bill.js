import SearchOptions from '../services/search-options';

export default () => {

    const state = {
        bills: [],
        billDelete: null,
        resource: null,
        searchOptions: new SearchOptions()
    };

    const mutations = {
        set(state, bills){
            state.bills = bills;
        },
        update(state, {index,bill}){
            state.bills.$set(index, bill);
        },
        setDelete(state, bill){
            state.billDelete = bill;
        },
        'delete'(state){
            state.bills.$remove(state.billDelete);
        },
        setOrder(state, key){
            state.searchOptions.order.key = key;
            let sort = state.searchOptions.order.sort;
            state.searchOptions.order.sort = sort == 'desc' ? 'asc' : 'desc';
        },
        setPagination(state, pagination){
            state.searchOptions.pagination = pagination;
        },
        setCurrentPage(state, currentPage){
            state.searchOptions.pagination.current_page = currentPage;
        },
        setFilter(state, filter){
            state.searchOptions.search = filter;
        }
    };

    const actions = {
        query(context){
            let searchOptions = context.state.searchOptions;
            return context.state.resource.query(searchOptions.createOptions()).then((response) => {
                context.commit('set', response.data.data);
                context.commit('setPagination', response.data.meta.pagination);
            });
        },
        queryWithSortBy(context, key){
            context.commit('setOrder', key);
            context.dispatch('query');
        },
        queryWithPagination(context, currentPage){
            context.commit('setCurrentPage', currentPage);
            context.dispatch('query');
        },
        queryWithFilter(context){
            context.dispatch('query');
        },
        'delete'(context){
            let id = context.state.billDelete.id;
            return context.state.resource.delete({id: id}).then((response) => {
                context.commit('delete');
                context.commit('setDelete', null);

                let bills = context.state.bills;
                let pagination = context.state.searchOptions.pagination;

                if (bills.length === 0 && pagination.current_page > 0) {
                    context.commit('setCurrentPage', pagination.current_page--);
                }
                return response;
            });
        },
        save(context, bill){
            return context.state.resource.save({}, bill).then((response) => {
                context.dispatch('query');
                return response;
            });
        },
        edit(context, {index,bill}){
            return context.state.resource.update({id: bill.id}, bill).then((response) => {
                context.commit('update',{index, bill});
                return response;
            });
        }
    };

    const getters = {
        billByIndex: (state) => (index) => {
            return state.bills[index];
        }
    }

    const module = {
        namespaced: true,
        state,
        mutations,
        actions,
        getters
    };
    return module;
};