<template src="../_form.html"></template>
<script>
    import billMixin from '../../../mixins/bill-mixin';

    export default{
        mixins: [billMixin],
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
