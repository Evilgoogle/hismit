<?php
// active lang
$all_langs = \App\Language::where('enable', true)->orderBy('position', 'asc')->get();
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

            </div>
        </div>
    </div>
</header>
