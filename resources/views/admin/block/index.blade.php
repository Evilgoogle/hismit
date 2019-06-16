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
            <div class="body table-responsive">
                <table class="table table-bordered table-striped js-table dataTable {{--order-table--}}">
                    <thead>
                        <tr>
                            {{--<th class="index">Порядок сортировки</th>--}}
                            <th>ID</th>
                            <th>Заголовок</th>
                            <th>Ключ</th>
                            {{--<th>Состояние</th>--}}
                            <th>Опции</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr id="{{ $item->id }}">
                                {{--<td class="index">{{ $item->position }}</td>--}}
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->key }}</td>
{{--                                <td>
                                    <input type="checkbox" class="enable filled-in chk-col-blue" name="enable" data-id="{{ $item->id }}" id="enable_{{ $item->id }}" {{ $item->enable ? 'value=1 checked' : 'value=0'}}>
                                    <label for="enable_{{ $item->id }}"></label>
                                </td>--}}
                                <td>
                                    <a href="/admin/{{ $info->url }}/edit/{{ $item->id }}">Изменить</a> <a href="/admin/{{ $info->url }}/remove/{{ $item->id }}">Удалить</a>
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
