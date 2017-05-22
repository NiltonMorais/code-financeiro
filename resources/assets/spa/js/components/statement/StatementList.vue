<template>
        <div class="row">
                <page-title>
                    <h5>Extrato</h5>
                </page-title>
            <div class="card-panel z-depth-5">
                <search @on-submit="filter" :model.sync="search"></search>
                <table class="bordered striped hightlight responsive-table">
                    <thead>
                    <tr>
                        <th v-for="(key,o) in table.headers" :width="o.width">
                            <a href="#" @click.prevent="sortBy(key)">
                                {{o.label}}
                                <i class="material-icons left" v-if="searchOptions.order.key == key">
                                    {{searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'}}
                                </i>
                            </a>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="o in statements">
                        <td>{{o.date | dateFormat}}</td>
                        <td>{{o.bankAccount.data.name}}</td>
                        <td>{{o.value | numberFormat true}}</td>
                        <td>{{o.balance | numberFormat true}}</td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="searchOptions.pagination.current_page" :per-page="searchOptions.pagination.per_page"
                            :total-records="searchOptions.pagination.total"></pagination>
                <table class="grey-text text-darken-2">
                    <tbody class="left">
                        <tr>
                            <td><strong>Total de Recebimentos</strong></td>
                            <td><strong>{{statementData.revenues.total | numberFormat true}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total de Pagamentos</strong></td>
                            <td><strong>{{statementData.expenses.total | numberFormat true}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Quantidade de lançamentos</strong></td>
                            <td><strong>{{statementData.count}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Total do Período</strong></td>
                            <td><strong>{{statementData.revenues.total + statementData.expenses.total | numberFormat true}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</template>
<script>
    import store from '../../store/store';
    import moment from 'moment';
    import PaginationComponent from '../../../../_default/components/Pagination.vue';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    import SearchComponent from '../../../../_default/components/Search.vue';
    export default{
        components: {
            'pagination': PaginationComponent,
            'page-title': PageTitleComponent,
            'search': SearchComponent,
        },
        data(){
            return{
                table: {
                    headers: {
                        date: {
                            label: 'Data', width: '10%'
                        },
                        'bank_accounts:bank_account_id|bank_accounts.name': {
                            label: 'Conta bancária', width: '13%'
                        },
                        value: {
                            label: 'Valor',  width: '20%'
                        },
                        balance: {
                            label: 'Saldo', width: '20%'
                        }
                    }
                }
            }
        },
        computed: {
            statements(){
                return store.state.statement.statements;
            },
            statementData(){
                return store.state.statement.statementData;
            },
            searchOptions(){
                return store.state.statement.searchOptions;
            },
            search: {
                get(){
                    return store.state.statement.searchOptions.search;
                },
                set(value){
                    store.commit('statement/setFilter',value);
                }
            }
        },
        created(){
            store.commit('statement/setFilter', `${this.dateFilterStart()} - ${this.dateFilterEnd()}`);
            store.dispatch('statement/query');
        },
        methods: {
            sortBy(key){
                store.dispatch('statement/queryWithSortBy',key);
            },
            filter(){
                store.dispatch('statement/queryWithFilter');
            },
            dateFilterStart(){
                let date = new Date();
                date.setDate(1);
                return moment(date).format('DD/MM/YYYY');
            },
            dateFilterEnd(){
                return moment(new Date).endOf('month').format('DD/MM/YYYY');
            }
        },
        events: {
            'pagination::changed'(page){
                store.dispatch('statement/queryWithPagination',page);
            }
        }
    }


</script>
