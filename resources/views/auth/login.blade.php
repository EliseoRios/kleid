@extends('layouts.catalogo')

@section('titulo')
  {{ __('Login') }}
@endsection

@section('content')
<form id="sign_in" method="POST" action="{{ route('login') }}">
    @csrf

    <div class="msg">{{ __('Login') }}</div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">person</i>
        </span>
        <div class="form-line">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required autofocus>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">lock</i>
        </span>
        <div class="form-line">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 p-t-5">
            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
            <label for="rememberme">{{ __('Remember Me') }}</label>
        </div>
        <div class="col-xs-4">
            <button class="btn btn-block bg-pink waves-effect" type="submit">ENTRAR</button>
        </div>
    </div>
    <div class="row m-t-15 m-b--20">
        <div class="col-xs-6">
            <a href="{{ route('password.request') }}">
                Olvidó su contraseña?
            </a>
        </div>
        <div class="col-xs-6 align-right">
            <a href="{{ route('register') }}">
                Registrarse
            </a>
        </div>
    </div>
</form>
@endsection
