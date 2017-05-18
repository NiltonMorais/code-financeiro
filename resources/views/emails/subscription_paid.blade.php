<h3>{{config('app.name')}}</h3>
<p>Olá {{$user->name}}!</p>
<p>Parabéns, sua assinatura na plataforma já está ativa.</p>
<p>
    Data de expiração:
    <strong>{{(new \Carbon\Carbon($subscription->expires_at))->format('d/m/Y')}}</strong>
</p>
<p>
    Clique <a target="_blank" href="{{url('/')."app/#!/login"}}">aqui</a> para acessar a plataforma financeira.
</p>
<p>
    Quando chegar a data de expiração, sua assinatura será renovada automaticamente, caso tenha efetuado o pagamento via
    cartão de crédito. Se o pagamento foi feito por boleto, um novo boleto será gerado nessa data de pagamento.
</p>
<p>Obs: Não responda este e-mail, ele é gerado automaticamente.</p>