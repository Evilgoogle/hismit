@extends('layouts.admin')

@section('admin_content')

    <input type="hidden" id="ajaxUrl" value="{{ $info->url }}">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>{{ $info->head }}</h2>
                </div>
                <div class="body table-responsive">
                    <table class="table table-bordered table-striped js-table dataTable" data-order-column="1" data-order-type="desc">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Сообщение</th>
                                <th>Время</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            <tr id="{{ $item->id }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->message }}</td>
                                <td>{{ date('d.m.Y H:i:s', strtotime($item->created_at)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
