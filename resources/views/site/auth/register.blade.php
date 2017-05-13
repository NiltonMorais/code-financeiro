@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row card-panel center">
            <h3>Registre sua conta</h3>
        </div>
        {!! Form::open(['route'=>'site.auth.register.store']) !!}
        <div class="row card-panel">
            <h5 class="blue-grey-text center">Informações do usuário</h5>
            <div class="row">
                <?php $errorClass = $errors->first('name') ? ['class'=>'validate invalid'] : []; ?>
                <div class="input-field col s6">
                    {!! Form::text('name', null, $errorClass) !!}
                    {!! Form::label('name','Nome',['data-error' => $errors->first('name')]) !!}
                </div>
                <?php $errorClass = $errors->first('email') ? ['class'=>'validate invalid'] : []; ?>
                <div class="input-field col s6">
                    {!! Form::email('email', null, $errorClass) !!}
                    {!! Form::label('email','E-mail',['data-error' => $errors->first('email')]) !!}
                </div>
            </div>
            <div class="row">
                <?php $errorClass = $errors->first('password') ? ['class'=>'validate invalid'] : []; ?>
                <div class="input-field col s6">
                    {!! Form::password('password', $errorClass) !!}
                    {!! Form::label('password','Senha',['data-error' => $errors->first('password')]) !!}
                </div>

                <div class="input-field col s6">
                    {!! Form::password('password_confirmation') !!}
                    {!! Form::label('password_confirmation','Repita a senha') !!}
                </div>
            </div>
        </div>
        <div class="row card-panel">
            <h5 class="blue-grey-text center">Informações da empresa</h5>
            <div class="row">
                <?php $errorClass = $errors->first('client.name') ? ['class'=>'validate invalid'] : []; ?>
                <div class="input-field col s6">
                    {!! Form::text('client[name]', null, $errorClass) !!}
                    {!! Form::label('client[name]','Nome',['data-error' => $errors->first('client.name')]) !!}
                </div>
                <?php $errorClass = $errors->first('client.email') ? ['class'=>'validate invalid'] : []; ?>
                <div class="input-field col s6">
                    {!! Form::email('client[email]', null, $errorClass) !!}
                    {!! Form::label('client[email]','E-mail',['data-error' => $errors->first('client.email')]) !!}
                </div>
            </div>
        </div>
        <div class="row center">
            {!! Form::submit('Criar conta',['class'=>'btn waves-effect']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
