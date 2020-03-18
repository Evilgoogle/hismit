<?php

namespace App\Http\ViewComposers;

use App\Seo;
use Illuminate\Support\Facades\Request;
use Illuminate\View\View;

class SeoComposer
{

    public function compose(View $view)
    {
        $segments = Request::segments();
        $url = implode('/', $segments);
        if (empty($url)) $url = "main";
        $seo = Seo::where('url', $url)->first();

        return $view->with(compact('seo'));
    }

}
