@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <h1>
                    <strong>CodeFinanceiro</strong>
                    <span> é uma aplicação para controle financeiro</span>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div class="row card">
                    <div class="card-content white-text center-align blue-grey">
                        <span class="card-title">Empresarial</span>
                    </div>
                    <div class="card-content main-content white center-align">
                        <p>
                            <strong>R$ 40,00/mês</strong>
                        </p>
                        <ul class="collection" id="plan-business">
                            <li class="collection-item">Contas a pagar</li>
                            <li class="collection-item">Contas a receber</li>
                            <li class="collection-item">Contas bancárias</li>
                            <li class="collection-item">Extrato</li>
                            <li class="collection-item">Fluxo de Caixa Anual</li>
                            <li class="collection-item">Gráfico Fluxo de Caixa Mensal</li>
                            <li class="collection-item">Notificação do saldo em tempo real</li>
                        </ul>
                    </div>
                    <div class="card-action white center-align">
                        <a href="{{route('site.subscriptions.create')}}" class="btn btn-large waves-effect waves-light blue-grey darken-2">
                            Contratar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
