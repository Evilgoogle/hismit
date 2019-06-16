@extends('layouts.admin')

@section('admin_content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Профайл | Пользователь: {{ Auth::user()->name }}</h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right js-sweetalert">
                            <li><a href="{{ url('/admin/profile/change-password') }}" class="change_password">Сменить пароль</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <form id="form_validation" action="{{ url('/admin/profile/update') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="form-line">
                            <b>Имя пользователя</b>
                            <input type="text" class="form-control" name="name" placeholder="Имя" value="{{ Auth::user()->name }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-line">
                            <div class="form-line">
                                <b>Почта</b>
                                <input type="text" class="form-control email" name="email" placeholder="example@example.com" value="{{ Auth::user()->email }}" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit">Изменить</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop