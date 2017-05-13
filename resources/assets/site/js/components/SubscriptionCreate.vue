<template src="./_template.html">
</template>
<script>
    export default{
        props: ['plan','csrf-token','action'],
        data(){
            return{
                payment_type: 'credit_card',
                credit_card: {
                    number: '4111111111111111',
                    cvv: '123',
                    expiration: '12/07',
                    first_name: 'Nome',
                    last_name: 'Sobrenome'
                }
            }
        },
        ready(){
            Iugu.setAccountID("63C332E29A1B44B386991BF2A6B96D43");
            Iugu.setTestMode(true);
            Iugu.setup();
        },
        methods: {
            submit(){
                if(this.payment_type == 'credit_card'){
                    let expirationArray = this.credit_card.expiration.split('/');
                    let creditCard = Iugu.CreditCard(
                      this.credit_card.number,
                      expirationArray[0],
                      expirationArray[1],
                      this.credit_card.first_name,
                      this.credit_card.last_name,
                      this.credit_card.cvv
                    );
                    Iugu.createPaymentToken(creditCard, response => {
                        if(response.errors){
                            Materialize.toast("Erro ao processar cartão de crédito. Tente novamente!", 4000);
                        }else{
                            console.log(response.id);
                        }
                    });
                }else{
                }
            }
        }
    }
</script>
