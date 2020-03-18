@extends('layouts.admin')

@section('admin_content')

<input type="hidden" id="ajaxUrl" value="{{ $info->url }}">
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>{{ $info->head }}</h2>
            </div>
            <div class="body">
                <form action="/admin/{{ $info->url }}/insert{{ isset($item->id) ? '/'. $item->id : '' }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include('admin._input.input-text', [
                        'name' => 'name',
                        'label' => 'Имя',
                        'item' => isset($item) ? $item : '',
                        'required' => true
                    ])

                    @include('admin._input.input-text', [
                        'name' => 'email',
                        'label' => 'E-mail',
                        'item' => isset($item) ? $item : '',
                        'required' => true,
                        'type' => 'email'
                    ])

                    @include('admin._input.input-text', [
                        'name' => 'password',
                        'label' => 'Пароль',
                        'item' => isset($item) ? $item : '',
                        'type' => 'password'
                    ])

                    @include('admin._input.input-text', [
                        'name' => 'password_confirmation',
                        'label' => 'Повторите пароль',
                        'item' => isset($item) ? $item : '',
                        'type' => 'password'
                    ])

                    <h2 class="card-inside-title">Роли *</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <select class="form-control show-tick" id="role" name="role[]" multiple title="Выберите роль">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ in_array($role->id, $role_user) ? "selected" : "" }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary m-t-10 waves-effect">{{ isset($item) ? 'Обновить' : 'Записать' }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@stop
