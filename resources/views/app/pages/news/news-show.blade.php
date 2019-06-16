@extends('layouts.app')

@section('app_content')

    <?php
        $seo_new = (object)[];
        $seo_new->title = 'Success Medical | '.html_entity_decode($news->title);
        $seo_new->description = html_entity_decode(strip_tags($news->desc));
    ?>

    <section class="news-show">
        <div class="container">
            @include('app._templates.breadcrumbs')

            <div class="content">
                <div class="show-content">
                    <div class="image" style="background-image: url(/uploads/{{ $news->image }});"></div>
                    <h1 class="title">{{ $news->title }}</h1>
                    <div class="date">{{ date('d.m.Y', strtotime($news->publish)) }}</div>
                    <div class="desc text-content">{!! $news->desc !!}</div>
                </div>
            </div>
        </div>
    </section>

@stop
