<template src="../_form.html"></template>
<script>
    import billMixin from '../../../mixins/bill-mixin';
    import validatorOffRemoveMixim from '../../../mixins/validator-off-remove-mixin';
    import store from '../../../store/store';
    import BillPay from '../../../models/bill-pay';

    export default{
        mixins: [billMixin, validatorOffRemoveMixim],
        created(){
            let self = this;
            this.modalOptions.options = {};
            this.modalOptions.options.ready = () => {
                self.getBill();
            };
        },
        methods: {
            namespace(){
                return 'billPay';
            },
            categoryNamespace(){
                return 'categoryExpense';
            },
            title(){
                return 'Editar pagamento';
            },
            getBill(){
                this.resetScope();
                let bill = store.getters[`${this.namespace()}/billByIndex`](this.index);
                this.bill = new BillPay(bill);
                let text = store.getters['bankAccount/textAutocomplete'](bill.bankAccount.data);
                this.bankAccount.text = text;
            }
        }
    }
</script>
