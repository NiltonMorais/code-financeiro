<template>
    <div class="container">
        <div class="row">
            <div class="col s6">
                <page-title>
                    <h5>Nova conta bancária</h5>
                </page-title>
            </div>
            <div class="col s6">
                <page-title class="valign-wrapper">
                    <div class="valign">
                        <a class="waves-effect waves-light btn" v-link="{name: 'bank-account.list'}">
                            <i class="material-icons">arrow_back</i>
                        </a>
                    </div>
                </page-title>
            </div>
            <div class="card-panel z-depth-5">
                <form name="form" method="GET" @submit="submit()">
                    <div class="row">
                        <div class="input-field col s12">
                            <label class="active">Nome</label>
                            <input type="text" v-model="bankAccount.name" placeholder="Digite o nome"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label class="active">Banco</label>
                            <select v-model="bankAccount.bank_id" id="bank_id" class="browser-default">
                                <option value="" disabled selected>Escolha um banco</option>
                                <option v-for="o in banks" :value="o.id">{{o.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label class="active">Agência</label>
                            <input type="text" v-model="bankAccount.agency" placeholder="Digite a agência"/>
                        </div>
                        <div class="input-field col s6">
                            <label class="active">Conta corrente</label>
                            <input type="text" v-model="bankAccount.account" placeholder="Digite a conta"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" class="filled-ind" v-model="bankAccount.default" id="account_id"/>
                            <label for="account_id">Padrão?</label>
                        </div>
                    </div>
                    <div class="fixed-action-btn">
                        <button type="submit" class="btn-floating btn-large">
                            <i class="large material-icons">save</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import {BankAccount, Bank} from '../../services/resources';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    export default{
        components: {
            'page-title': PageTitleComponent
        },
        data(){
            return{
                bankAccount: {
                    name: '',
                    agency: '',
                    account: '',
                    bank_id: '',
                    'default': false
                },
                banks: [],
            }
        },
        created(){
            this.getBanks();
        },
        methods: {
            submit(){
                BankAccount.save({},this.bankAccount).then(() => {
                    Materialize.toast('Conta bancária criada com sucesso!',5000);
                    this.$router.go({name: 'bank-account.list'});
                });
            },
            getBanks(){
                Bank.query().then((response) => {
                    this.banks = response.data.data;
                });
            }
        }
    }
</script>
