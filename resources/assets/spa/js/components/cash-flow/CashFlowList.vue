<template src="./_list.html">
</template>
<script>
    import store from '../../store/store';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    import Papa from 'papaparse';
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
                return this.cashFlows.period_list;
            },
            categoriesMonths()
            {
                return this.cashFlows.categories_period;
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
            },
            isCurrentMonthYear(monthYear){
                return this.$options.filters.monthYear(new Date) ==
                    this.$options.filters.monthYear(monthYear);
            },
            downloadCsv(){
                let anchor = $('<a/>');
                anchor.css('display','none');
                anchor.attr('download','fluxo-de-caixa.csv')
                    .attr('target','_blank')
                    .attr('href',`data:text/csv;charset=UTF-8,${encodeURIComponent(this.getCsv())}`);
                anchor.html('Download CSV');
                $('body').append(anchor);
                anchor[0].click();
                anchor.remove();
            },
            getCsv(){
                let csvResult = [];
                csvResult.push([]);
                $('table thead .text-csv').each(function(key,item){
                    csvResult[0].push($(item).text().trim());
                });
                $('table tbody tr').each(function(key,tr){
                    csvResult.push([]);
                    $(tr).find('.text-csv').each((k, element) => {
                        csvResult[csvResult.length-1].push($(element).text().trim());
                    });
                });

                return Papa.unparse(csvResult);
            }
        }
    }
</script>

<style type="text/css" scoped>
    th, tr{
        border-radius: 0px;
    }
</style>
