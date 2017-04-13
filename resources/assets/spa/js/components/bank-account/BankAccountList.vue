<template>
    <!--<div class="container">-->
        <div class="row">

                <page-title>
                    <h5>Minhas contas bancárias</h5>
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
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(index,o) in bankAccounts">
                        <td>{{o.id}}</td>
                        <td>{{o.name}}</td>
                        <td>{{o.agency}}</td>
                        <td>{{o.account}}</td>
                        <td>
                            <div class="row valign-wrapper">
                                <div class="col s2">
                                    <img :src="o.bank.data.logo" class="bank-logo">
                                </div>
                                <div class="col s10">
                                    <span class="left">{{o.bank.data.name}}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <i class="material-icons green-text" v-if="o.default">check</i>
                        </td>
                        <td>
                            <a v-link="{name: 'bank-account.update', params: {id: o.id} }">Editar</a>
                            <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <pagination :current-page.sync="searchOptions.pagination.current_page" :per-page="searchOptions.pagination.per_page"
                            :total-records="searchOptions.pagination.total"></pagination>
            </div>

            <div class="fixed-action-btn">
                <a class="btn-floating btn-large" v-link="{name: 'bank-account.create'}">
                    <i class="large material-icons">add</i>
                </a>
            </div>
        </div>
    <!--</div>  container -->
    <modal :modal="modal">
        <div slot="content" v-if="bankAccountDelete">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja excluir esta conta bancária?</strong></p>
            <div class="divider"></div>
            <p>Nome: <strong>{{bankAccountDelete.name}}</strong></p>
            <p>Agência: <strong>{{bankAccountDelete.agency}}</strong></p>
            <p>C/C: <strong>{{bankAccountDelete.account}}</strong></p>
            <div class="divider"></div>
        </div>
        <div slot="footer">
            <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" @click="destroy()">Ok
            </button>
            <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
        </div>
    </modal>
</template>
<script>
    import store from '../../store/store';
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../../../../_default/components/Pagination.vue';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    import SearchComponent from '../../../../_default/components/Search.vue';
    import SearchOptions from '../../services/search-options';
    export default{
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
            'page-title': PageTitleComponent,
            'search': SearchComponent,
        },
        data(){
            return{
                modal: {
                    id: "modal-delete"
                },
                table: {
                    headers: {
                        id: {
                            label: '#', width: '7%'
                        },
                        name: {
                            label: 'Nome', width: '30%'
                        },
                        agency: {
                            label: 'Agência',  width: '13%'
                        },
                        account: {
                            label: 'C/C', width: '13%'
                        },
                        'banks:bank_id|banks.name': {
                            label: 'Banco', width: '17%'
                        },
                        'default': {
                            label: 'Padrão', width: '5%'
                        }
                    }
                }
            }
        },
        computed: {
            bankAccounts(){
                return store.state.bankAccount.bankAccounts;
            },
            bankAccountDelete(){
                return store.state.bankAccount.bankAccountDelete;
            },
            searchOptions(){
                return store.state.bankAccount.searchOptions;
            },
            search: {
                get(){
                    return store.state.bankAccount.searchOptions.search;
                },
                set(value){
                    store.commit('bankAccount/setFilter',value);
                }
            }
        },
        created(){
            store.dispatch('bankAccount/query');
        },
        methods: {
            destroy(){
                store.dispatch('bankAccount/delete').then((response) => {
                    Materialize.toast('Conta bancária excluída com sucesso',5000);
                });
            },
            openModalDelete(bankAccount){
                store.commit('bankAccount/setDelete',bankAccount);
                $('#modal-delete').modal('open');
            },
            sortBy(key){
                store.dispatch('bankAccount/queryWithSortBy',key);
            },
            filter(){
                store.dispatch('bankAccount/queryWithFilter');
            }
        },
        events: {
            'pagination::changed'(page){
                store.dispatch('bankAccount/queryWithPagination',page);
            }
        }
    }


</script>
