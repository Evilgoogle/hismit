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
                    <form action="/admin/{{ $info->url }}/update" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <h2 class="card-inside-title">Рассылка заявок на указанные email (через запятую) *</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control"
                                               type="text"
                                               id="emails"
                                               name="emails"
                                               placeholder="Рассылка заявок на указанные email (через запятую)"
                                               value="{{ $items->where('key', 'emails')->pluck('value')->first() }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">WhatsApp</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control"
                                               type="text"
                                               id="whatsapp"
                                               name="whatsapp"
                                               placeholder="WhatsApp"
                                               value="{{ $items->where('key', 'whatsapp')->pluck('value')->first() }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Карта. Широта</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control"
                                               type="text"
                                               id="map_latitude"
                                               name="map_latitude"
                                               placeholder="Карта. Широта"
                                               value="{{ $items->where('key', 'map_latitude')->pluck('value')->first() }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h2 class="card-inside-title">Карта. Долгота</h2>
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control"
                                               type="text"
                                               id="map_longitude"
                                               name="map_longitude"
                                               placeholder="Карта. Долгота"
                                               value="{{ $items->where('key', 'map_longitude')->pluck('value')->first() }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary m-t-10 waves-effect">Обновить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
