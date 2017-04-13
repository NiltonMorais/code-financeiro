<template src="./_form.html"></template>
<script>
    import store from '../../store/store';
    import PageTitleComponent from '../../../../_default/components/PageTitle.vue';
    import 'materialize-autocomplete';

    export default{
        components: {
            'page-title': PageTitleComponent
        },
        data(){
            return{
                title: 'Nova conta bancária',
                bankAccount: {
                    name: '',
                    agency: '',
                    account: '',
                    bank_id: '',
                    'default': false
                },
                bank: {
                    name: ''
                }
            }
        },
        computed: {
            banks(){
                return store.state.bank.banks;
            },
            banksLength(){
                return store.getters['bank/banksLength'];
            }
        },
        created(){
            this.getBanks();
        },
        methods: {
            submit(){
                store.dispatch('bankAccount/save', this.bankAccount).then(() => {
                    Materialize.toast('Conta bancária criada com sucesso!',5000);
                    this.$router.go({name: 'bank-account.list'});
                });
            },
            getBanks(){
                store.dispatch('bank/query', this.bankAccount).then((response) => {
                    this.initAutocomplete();
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
                            let mapBanks = store.getters['bank/mapBanks'];
                            let banks = mapBanks(value);
                            callback(value, banks);
                        },
                        onSelect(item){
                            self.bankAccount.bank_id = item.id;
                        }
                    });
                });
            }
        }
    }
</script>
