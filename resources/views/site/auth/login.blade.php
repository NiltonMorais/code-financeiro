@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s8 offset-s2 z-depth-2">
                <h3 class="center">Login</h3>

                <form method="POST" action="{{ env('URL_SITE_LOGIN') }}">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="input-field col s12">
                            <?php $messageError = $errors->has('email') ? "data-error='{$errors->first('email')}'" : null ?>
                            <input id="email" type="email" class="validate {{$messageError ? 'invalid' : ''}}"
                                   name="email" value="{{ old('email') }}"
                                   required autofocus>
                            <label for="email" {!! $messageError !!}>E-Mail</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <?php $messageError = $errors->has('password') ? "data-error='{$errors->first('password')}'" : null ?>
                            <input id="password" type="password" class="validate {{$messageError ? 'invalid' : ''}}"
                                   name="password" value="{{ old('password') }}"
                                   required>
                            <label for="password" {!! $messageError !!}>Senha</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : ''}}>
                            <label for="remember">Lembrar-me</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn">Login</button>
                            <a class="btn white blue-grey-text" href="{{ route('site.auth.register.create') }}">
                                Registre-se aqui
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
