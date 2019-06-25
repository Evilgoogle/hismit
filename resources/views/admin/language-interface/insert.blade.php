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

{{--                        @include('admin._input.input-text', [
                            'name' => 'name',
                            'label' => 'Название',
                            'item' => isset($item) ? $item : '',
                            'required' => true
                        ])--}}

                        @include('admin._input.input-text', [
                            'name' => 'key',
                            'label' => 'Ключ',
                            'item' => isset($item) ? $item : '',
                            'required' => true
                        ])
                        
                        @include('admin._input.inputs-lang', [
                            'allLang' => $allLang,
                            'item' => isset($item) ? $item : ''
                        ])

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
