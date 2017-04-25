<template src="./_list.html">
</template>
<script>
    import store from '../../store/store';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    export default{
        components: {
            'page-title': PageTitleComponent,
        },
        computed: {
            cashFlows(){
                return store.state.cashFlow.cashFlows;
            },
            monthsList()
            {
                return this.cashFlows.months_list;
            },
            categoriesMonths()
            {
                return this.cashFlows.categories_months;
            },
            hasFirstMonthYear(){
                return store.getters['cashFlow/hasFirstMonthYear'];
            },
            firstMonthYear(){
                return store.state.cashFlow.firstMonthYear;
            },
            firstBalance(){
                return store.getters['cashFlow/firstBalance'];
            },
            secondBalance(){
                return store.getters['cashFlow/secondBalance'];
            },
            monthsListBalanceFinal(){
                return store.getters['cashFlow/monthsListBalanceFinal'];
            },
            hasCashFlows(){
            return store.getters['cashFlow/hasCashFlows'];
            }

        },
        created(){
            store.commit('cashFlow/setFirstMonthYear', new Date());
            store.dispatch('cashFlow/query');
        },
        methods: {
            balance(index){
                return store.getters['cashFlow/balance'](index);
            },
             categoryTotal(category, monthYear){
                return store.getters['cashFlow/categoryTotal'](category, monthYear);
             }
        }
    }


</script>
