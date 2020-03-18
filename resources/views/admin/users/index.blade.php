@extends('layouts.admin')

@section('admin_content')

<input type="hidden" id="ajaxUrl" value="{{ $info->url }}">
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>{{ $info->head }}</h2>
                <a href="/admin/{{ $info->url }}/add" class="btn btn-info waves-effect m-t-15">Добавить</a>
            </div>
            <div class="body table-responsive users">
                <table class="table table-bordered table-striped table-hover js-table dataTable" data-order-column="1" data-order-type="desc">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Уникальный номер</th>
                            <th>Имя</th>
                            <th>E-mail</th>
                            <th>Роль</th>
                            <th>Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->role_name }}</td>
                            <td>
                                <a href="/admin/{{ $info->url }}/edit/{{ $item->id }}">Изменить</a>
                                <a href="/admin/{{ $info->url }}/remove/{{ $item->id }}">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop
