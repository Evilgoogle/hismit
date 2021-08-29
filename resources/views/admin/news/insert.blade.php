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
                        'name' => 'title',
                        'label' => 'Заголовок',
                        'item' => isset($item) ? $item : '',
                        'required' => true
                    ])

                    @include('admin._input.textarea', [
                        'name' => 'desc',
                        'label' => 'Описание',
                        'item' => isset($item) ? $item : '',
                        'required' => true,
                        'editor' => true,
                        'editor_type' => 'simple'
                    ])

                    @if(isset($files))
                    <div class="files">
                        @foreach($files as $file)
                            <div class="item">
                                <div class="box">
                                    @if($file->type == 'image/jpeg' || $file->type == 'image/png')
                                        <a href="{{ $file->file }}" target="_blank"><img src="{{ $file->file }}" alt="file_{{ $file->id }}"></a>
                                    @elseif($file->type == 'video/mp4')
                                        <a href="{{ $file->file }}" target="_blank"><span>Смотреть Видео</span></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

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
