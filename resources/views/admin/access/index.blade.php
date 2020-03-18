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
                            <th>Имя пользователя (уникальное)</th>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th>Роль</th>
                            <th>Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role_name }}</td>
                            <td><a href="/admin/access/users/edit/{{ $user->id }}">Изменить</a> <a href="/admin/access/users/remove/{{ $user->id }}">Удалить</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
