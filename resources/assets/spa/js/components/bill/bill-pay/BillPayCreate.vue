<template src="../_form.html"></template>
<script>
    import billMixin from '../../../mixins/bill-mixin';
    import validatorOffRemoveMixim from '../../../mixins/validator-off-remove-mixin';

    export default{
        mixins: [billMixin, validatorOffRemoveMixim],
        ready(){
            this.initSelect2();
        },
        methods: {
            namespace(){
                return 'billPay';
            },
            categoryNamespace(){
                return 'categoryExpense';
            },
            title(){
                return 'Novo pagamento';
            }

        }
    }
</script>

<style type="text/css" scoped src="../_style.css">
</style>
