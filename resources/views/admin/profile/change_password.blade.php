@extends('layouts.admin')

@section('admin_content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Профайл | Смена пароля</h2>
            </div>
            <div class="body">
                <form id="form_validation" action="{{ url('/admin/profile/update-password') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" class="form-control" name="old_password" required>
                            <label for="old_password" class="form-label">Введите старый пароль</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" required>
                            <label for="password" class="form-label">Введите новый пароль</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_confirmation" required>
                            <label for="password_confirmation" class="form-label">Повторите новый пароль</label>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit">Изменить</button>
                </form>
            </div>
        </div>
    </div>
</div>

@stop