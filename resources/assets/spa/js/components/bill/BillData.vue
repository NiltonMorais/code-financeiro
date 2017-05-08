<template>
    <table class="grey-text text-darken-2">
        <tbody class="left">
        <tr>
            <td><strong>{{ paidText }}</strong></td>
            <td><strong>{{ billData.total_paid | numberFormat true }}</strong></td>
        </tr>
        <tr>
            <td><strong>{{ toPayText }}</strong></td>
            <td><strong>{{ billData.total_to_pay | numberFormat true }}</strong></td>
        </tr>
        <tr>
            <td><strong>Vencidas</strong></td>
            <td><strong>{{ billData.total_expired | numberFormat true }}</strong></td>
        </tr>
        <tr>
            <td><strong>{{ totalFinalText }}</strong></td>
            <td><strong>{{ (billData.total_paid + billData.total_to_pay) | numberFormat true }}</strong></td>
        </tr>
        <tbody>
    </table>
</template>
<script>
    import store from '../../store/store';

    export default{
        props: ['namespace'],
        computed: {
            billData(){
                return store.state[this.namespace].billData;
            },
            paidText(){
                return this.namespace == "billReceive" ? "Recebidas" : "Pagas";
            },
            toPayText(){
                return this.namespace == "billReceive" ? "A receber" : "A pagar";
            },
            totalFinalText(){
                return this.namespace == "billReceive" ? "Total de Recebimentos" : "Total de Pagamentos";
            }
        }
    }
</script>
