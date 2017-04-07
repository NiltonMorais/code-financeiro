<template src="./_form.html"></template>
<script>
    import {BankAccount, Bank} from '../../services/resources';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    import 'materialize-autocomplete';
    import _ from 'lodash';

    export default{
        components: {
            'page-title': PageTitleComponent
        },
        data(){
            return{
                title: 'Edição de conta bancária',
                bankAccount: {
                    name: '',
                    agency: '',
                    account: '',
                    bank_id: '',
                    'default': false
                },
                bank: {
                    name: ''
                },
                banks: []
            }
        },
        created(){
            this.getBanks();
            this.getBankAccount(this.$route.params.id);
        },
        methods: {
            submit(){
                let id = this.$route.params.id;
                BankAccount.update({id: id},this.bankAccount).then(() => {
                    Materialize.toast('Conta bancária atualizada com sucesso!',5000);
                    this.$router.go({name: 'bank-account.list'});
                });
            },
            getBanks(){
                Bank.query().then((response) => {
                    this.banks = response.data.data;
                    this.initAutocomplete();
                });
            },
            getBankAccount(id){
                BankAccount.get({id: id, include: 'bank'}).then((response) => {
                    this.bankAccount = response.data.data;
                    this.bank = response.data.data.bank.data;
                });
            },
            initAutocomplete(){
                let self = this;
                $(document).ready(() => {
                    $('#bank-id').materialize_autocomplete({
                        limit: 10,
                        multiple: {
                            enable: false
                        },
                        dropdown: {
                            el: '#bank-id-dropdown'
                        },
                        getData(value, callback){
                            let banks = self.filterBankByName(value);
                            banks = banks.map((o) => {
                                return {id: o.id, text: o.name};
                            })
                            callback(value, banks);
                        },
                        onSelect(item){
                            self.bankAccount.bank_id = item.id;
                        }
                    });
                });
            },
            filterBankByName(name){
                let banks = _.filter(this.banks, (o) => {
                    return _.includes(o.name.toLowerCase(), name.toLowerCase());
                });
                return banks;
            }
        }
    }
</script>
