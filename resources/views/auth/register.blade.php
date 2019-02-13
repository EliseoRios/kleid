@extends('layouts.login')

@section('titulo')
  {{ __('Register') }}
@endsection

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="msg">{{ __('Register') }}</div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">person</i>
        </span>
        <div class="form-line">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Nombre" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">email</i>
        </span>
        <div class="form-line">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Correo electrónico" required>

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
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">lock</i>
        </span>
        <div class="form-line">
            <input id="password-confirm" type="password" class="form-control" placeholder="Confirmar contraseña" name="password_confirmation" required>
        </div>
    </div>
    {{-- <div class="form-group">
        <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
        <label for="terms">I read and agree to the <a href="javascript:void(0);">terms of usage</a>.</label>
    </div> --}}

    <button type="submit" class="btn btn-block btn-lg bg-pink waves-effect">
        {{ __('Register') }}
    </button>

    <div class="m-t-25 m-b--5 align-center">
        <a href="{{ url('/') }}">Ya estás registrado?</a>
    </div>
</form>
@endsection
