@extends('auth.auth')

@section('auth_content')

<div class="login-box">
    <div class="logo">
        <a href="/">{{ config('app.name') }}</a>
    </div>
    <div class="card">
        <div class="body">
            <form id="sign_in" role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="msg">Войти в систему</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" required autofocus value="{{ old('email') }}">
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
                        <input type="password" class="form-control" name="password" placeholder="Пароль" required>
                    </div>
                    @if ($errors->has('password'))
                        <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                    @endif
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="remember" id="remember" class="filled-in chk-col-pink">
                        <label for="remember">Запомнить меня</label>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-block bg-pink waves-effect" type="submit">Войти</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-12 align-right">
                        <a href="{{ url('/password/reset') }}">Забыли пароль?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
    
