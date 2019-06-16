@extends('layouts.admin')

@section('admin_content')

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Пользователи</h2>
                <a href="/admin/access/users/add" class="btn btn-info waves-effect m-t-15">Добавить пользователя</a>
            </div>
            <div class="body table-responsive users">
                <table class="table table-bordered table-striped table-hover js-table dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th>Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <th>{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><a href="/admin/access/users/edit/{{ $user->id }}">Изменить</a> <a href="/admin/access/users/remove/{{ $user->id }}">Удалить</a></td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="4" class="text-center">Пользователей нет</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Роли</h2>
                <a href="/admin/access/roles/add" class="btn btn-info waves-effect m-t-15">Добавить роль</a>
            </div>
            <div class="body table-responsive users">
                <table class="table table-bordered table-striped table-hover js-table dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <th>{{ $role->id }}</th>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>
                                <a href="/admin/access/roles/edit/{{ $role->id }}">Изменить</a>
                                {!! (($role->name == 'superadmin') || ($role->name == 'login')) ? '' : '<a href="/admin/access/roles/remove/{{ $role->id }}">Удалить</a>' !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="4" class="text-center">Ролей нет</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Действия</h2>
                <a href="/admin/access/permissions/add" class="btn btn-info waves-effect m-t-15">Добавить дейсвие</a>
            </div>
            <div class="body table-responsive users">
                <table class="table table-bordered table-striped table-hover js-table dataTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <th>{{ $permission->id }}</th>
                            <td>{{ $permission->display_name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td>
                                <a href="/admin/access/permissions/edit/{{ $permission->id }}">Изменить</a>
                                <a href="/admin/access/permissions/remove/{{ $permission->id }}">Удалить</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="4" class="text-center">Действий нет</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop