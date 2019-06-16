@extends('auth.auth')

@section('auth_content')

<div class="login-box">
    <div class="logo">
        <a href="/">{{ config('app.name') }}</a>
    </div>
    <div class="card">
        <div class="body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <form id="sign_in" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}
                <div class="msg">Сброс пароля</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        <input type="email" class="form-control" placeholder="Email" required autofocus name="email" value="{{ old('email') }}">
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

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Обновить пароль</button>

                <div class="m-t-25 m-b--5 align-center">
                    <a href="/login">Войти, если зарегистрированы</a>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
    
