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
                                <i class="material-icons left" v-if="order.key==key">
                                    {{order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'}}
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
                <pagination :current-page.sync="pagination.current_page" :per-page="pagination.per_page"
                            :total-records="pagination.total"></pagination>
            </div>

            <div class="fixed-action-btn">
                <a class="btn-floating btn-large" v-link="{name: 'bank-account.create'}">
                    <i class="large material-icons">add</i>
                </a>
            </div>
        </div>
    <!--</div>  container -->
    <modal :modal="modal">
        <div slot="content" v-if="bankAccountToDelete">
            <h4>Mensagem de confirmação</h4>
            <p><strong>Deseja excluir esta conta bancária?</strong></p>
            <div class="divider"></div>
            <p>Nome: <strong>{{bankAccountToDelete.name}}</strong></p>
            <p>Agência: <strong>{{bankAccountToDelete.agency}}</strong></p>
            <p>C/C: <strong>{{bankAccountToDelete.account}}</strong></p>
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
    import {BankAccount} from '../../services/resources';
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../../../../_default/components/Pagination.vue';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    import SearchComponent from '../../../../_default/components/Search.vue';
    export default{
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
            'page-title': PageTitleComponent,
            'search': SearchComponent,
        },
        data(){
            return{
                bankAccounts: [],
                bankAccountToDelete: null,
                modal: {
                    id: "modal-delete"
                },
                pagination: {
                    current_page: 0,
                    per_page: 0,
                    total: 0
                },
                search: '',
                order: {
                    key: 'id',
                    sort: 'asc'
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
        created(){
            this.getBankAccounts();
        },
        methods: {
            destroy(){
                BankAccount.delete({id: this.bankAccountToDelete.id}).then((response) => {
                    this.bankAccounts.$remove(this.bankAccountToDelete);
                    this.bankAccountToDelete = null;
                    if(this.bankAccounts.length === 0 && this.pagination.current_page > 0){
                        this.pagination.current_page--;
                    }
                    Materialize.toast('Conta bancária excluída com sucesso',4000);
                });
            },
            openModalDelete(bankAccount){
                this.bankAccountToDelete = bankAccount;
                $('#modal-delete').modal('open');
            },
            getBankAccounts(){
                BankAccount.query({
                    page: this.pagination.current_page + 1,
                    orderBy: this.order.key,
                    sortedBy: this.order.sort,
                    search: this.search,
                    include: 'bank'
                }).then((response) => {
                    this.bankAccounts = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            },
            sortBy(key){
                this.order.key = key;
                this.order.sort = this.order.sort == 'desc' ? 'asc' : 'desc';
                this.getBankAccounts();
            },
            filter(){
                this.pagination.current_page = 0;
                this.getBankAccounts();
            }
        },
        events: {
            'pagination::changed'(page){
                this.getBankAccounts();
            }
        }
    }


</script>
