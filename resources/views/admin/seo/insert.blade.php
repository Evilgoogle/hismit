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
                        'name' => 'page',
                        'label' => 'Название страницы',
                        'item' => isset($item) ? $item : '',
                        'required' => true
                    ])

                    <h2 class="card-inside-title">Относительный URL страницы *</h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon">{{ url('/') }}/</span>
                                <div class="form-line">
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="url"
                                        name="url"
                                        placeholder="Относительный URL страницы"
                                        value="{{ $item->url ?? '' }}" required {{ isset($item->url) && $item->url == 'main' ? ' readonly' : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin._input.textarea', [
                        'name' => 'title',
                        'label' => 'Title',
                        'item' => isset($item) ? $item : '',
                    ])

                    @include('admin._input.textarea', [
                        'name' => 'description',
                        'label' => 'Description',
                        'item' => isset($item) ? $item : '',
                    ])

                    @include('admin._input.textarea', [
                        'name' => 'keywords',
                        'label' => 'Keywords',
                        'item' => isset($item) ? $item : '',
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