@extends('layouts.app')

@section('app_content')

    <section class="news-main">
        <div class="container">
            @include('app._templates.breadcrumbs')

            <div class="content">
                <div class="items">
                    @foreach($news as $n)
                        <a href="/news/{{ $n->url }}" class="item">
                            <div class="img">
                                <img src="/uploads/{{ $n->image }}" alt="{{ $n->title }}">
                            </div>
                            <div class="desc">
                                <h2 class="title">{{ html_entity_decode($n->title) }}</h2>
                                <div class="date">{{ date('d.m.Y', strtotime($n->publish)) }}</div>
                                <div class="desc">{{ html_entity_decode(str_limit(strip_tags($n->desc), 300)) }}. <span class="more">Подробнее</span></div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@stop
