<?php
    use App\Language;

    // active lang
    $all_langs = Language::where('enable', true)->orderBy('position', 'asc')->get();
    $routing = env('routing');

    // select lang
    if (isset($routing) && !empty($routing)) {
        $select_lang = $all_langs->firstWhere('url', $routing);
    } else {
        $select_lang = $all_langs->firstWhere('default', true);
    }

    // current url
    $current_url = explode('/', request()->path());
    $urls = [];
    foreach ($all_langs as $lang) {
        $urls[] = $lang->url;
    }

    if (in_array($current_url[0], $urls)) {
        unset($current_url[0]);
        $current_url = implode("/", $current_url);
    } else {
        $current_url = implode("/", $current_url);
    }
?>

<header>
    <div class="header">
        <div class="container header-container">
            <div class="wrap header-wrap">
                <nav>
                    <ul class="menu-links">
                        <li><a href="{{ getRoute() }}/"><span>Главная</span></a></li>
                    </ul>
                    <ul class="menu-languages">
                        @foreach($all_langs as $a)
                            @if ($a->url == $select_lang->url)
                                <li class="active"><span class="link">{{ $a->title }}</span></li>
                            @else
                                <li><a class="link" href="/{{ $a->url .'/'. $current_url }}">{{ $a->title }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
