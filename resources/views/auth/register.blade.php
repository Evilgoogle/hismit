@extends('auth.auth')

@section('auth_content')

<div class="login-box">
    <div class="logo">
        <a href="/">{{ config('app.name') }}</a>
    </div>
    <div class="card">
        <div class="body">
            <form id="sign_in" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="msg">Регистрация нового пользователя</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line{{ $errors->has('name') ? ' error' : '' }}">
                        <input type="text" class="form-control" placeholder="Имя" required autofocus name="name" value="{{ old('name') }}">
                    </div>
                    @if ($errors->has('name'))
                        <label id="name-error" class="error" for="email">{{ $errors->first('name') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        <input type="email" class="form-control" placeholder="Email" required name="email" value="{{ old('email') }}">
                    </div>
                    @if ($errors->has('email'))
                        <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line{{ $errors->has('password') ? ' error' : '' }}">
                        <input type="password" class="form-control" name="password" minlength="6" placeholder="Пароль" required>
                    </div>
                    @if ($errors->has('password'))
                        <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line{{ $errors->has('password_confirmation') ? ' error' : '' }}">
                        <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Повторите пароль" required>
                    </div>
                    @if ($errors->has('password_confirmation'))
                        <label id="password-confirmation-error" class="error" for="password_confirmation">{{ $errors->first('password_confirmation') }}</label>
                    @endif
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Регистрация</button>

                <div class="m-t-25 m-b--5 align-center">
                    <a href="/login">Войти, если зарегистрированы</a>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
