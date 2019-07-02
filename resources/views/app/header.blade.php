<?php
    // active lang
    $alllang = \App\Language::where('enable', true)->orderBy('position', 'asc')->get();
    if (isset($_ENV['routing']) && !empty($_ENV['routing'])) {
        $select_lang = $alllang->firstWhere('url', $_ENV['routing']);
    } else {
        $select_lang = $alllang->firstWhere('default', true);
    }

    // current url
    $current_page = explode('/', url()->current());
    for ($i = 0; $i < 3; $i++){
        unset($current_page[$i]);
    } if (count($current_page) > 0 && $current_page[3] == 'kz' || count($current_page) > 0 && $current_page[3] == 'ru' || count($current_page) > 0 && $current_page[3] == 'en'){
        unset($current_page[3]);
        $current_page = implode("/", $current_page);
    } else{
        $current_page = implode("/", $current_page);
    }
?>

<header>
    <div class="header">
        <div class="container header-container">
            <div class="wrap header-wrap">

            </div>
        </div>
    </div>
</header>
