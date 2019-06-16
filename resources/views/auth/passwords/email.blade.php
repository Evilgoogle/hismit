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
            <form id="forgot_password" method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}
                <div class="msg">Сброс пароля</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">email</i>
                    </span>
                    <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                        <input type="email" class="form-control" name="email" placeholder="Email" required autofocus value="{{ old('email') }}">
                    </div>
                    @if ($errors->has('email'))
                        <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                    @endif
                </div>

                <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Отправить ссылку для сброса пароля</button>

                <div class="row m-t-20 m-b--5 align-center">
                    <a href="{{ url('/login') }}">Войти</a>
                </div>
            </form>
        </div>
    </div>
</div>

@stop