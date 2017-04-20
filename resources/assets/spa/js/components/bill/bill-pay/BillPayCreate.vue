<template src="../_form.html"></template>
<script>
    import billMixin from '../../../mixins/bill-mixin';

    export default{
        mixins: [billMixin],
        methods: {
            namespace(){
                return 'billPay';
            },
            title(){
                return 'Novo pagamento';
            }

        }
    }
</script>
