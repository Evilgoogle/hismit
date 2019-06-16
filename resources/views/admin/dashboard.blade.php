@extends('layouts.admin')

@section('admin_content')

    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

{{--    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Подписчики:</h2>
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                @if(count($subscribes) > 0)
                                    <div class="form-line">
                                        @foreach($subscribes as $item)
                                            {{ $item->email }}{{ !$loop->last ? ',' : '' }}
                                        @endforeach
                                    </div>
                                @else
                                    Подписчиков нет
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}

@stop
