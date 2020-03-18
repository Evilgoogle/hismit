@extends('layouts.admin')

@section('admin_content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Пользователи / Изменение</h2>
            </div>
            <div class="body">
                <form action="/admin/access/users/update/{{ $user->id }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="name">Имя</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control" placeholder="Имя" value="{{ $user->name }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="username">Имя пользователя (уникальное)</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" id="username" class="form-control" placeholder="username" value="{{ $user->username }}" readonly>
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
                                    <input type="email" class="form-control" placeholder="E-mail" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                            <label for="referrer_id">Выбрать реферала</label>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="referrer_id" name="referrer_id">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ in_array($role->id, $role_user) ? "selected" : "" }} {{ ($role->name == 'login') ? "disabled" : "" }}>{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
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
                                            <option value="{{ $role->id }}" {{ in_array($role->id, $role_user) ? "selected" : "" }} {{ ($role->name == 'login') ? "disabled" : "" }}>{{ $role->display_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </form>
            </div>
        </div>
    </div>
</div>

@stop
