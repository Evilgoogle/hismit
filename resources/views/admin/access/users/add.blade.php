@extends('layouts.admin')

@section('admin_content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Пользователи / Добавление</h2>
            </div>
            <div class="body">
                <form action="/admin/access/users/create" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    {{--<p>Пароль генерируется автоматически и отсылается на указанный email</p>--}}
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Имя *</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Степан" required>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="username">Имя пользователя (на латинском/слитно) *</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="username" name="username" class="form-control check-username" placeholder="username" minlength="3" maxlength="50" required>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="email">E-mail *</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="email" id="email" name="email" class="form-control check-email" placeholder="example@example.com" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password">Пароль *</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" id="password" name="password" class="form-control check-min check-max" placeholder="Пароль" minlength="8" maxlength="50" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="password_confirmation">Повторите пароль *</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Повторите пароль" required>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="role">Роли *</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="role" name="role[]" multiple>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ ($role->name == 'login') ? "selected disabled" : "" }} >{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                    <div class="row clearfix">
                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                            <button type="submit" class="btn btn-primary m-t-10 waves-effect">Добавить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
