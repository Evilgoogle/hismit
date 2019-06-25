<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Spatie\Searchable\Search;

class IndexController extends Controller
{
    public function index()
    {
        return view('app.pages.index', compact(''));
    }

    public function news($url = null)
    {
        if (!empty($url)) {

            $news = News::where('url', $url)->first();

            if (empty($news))
                abort(404);

            $breadcrumbs = [
                '/news' => 'Новости',
                '/news/'.$url => $news->title
            ];

            return view('app.pages.news.news-show', compact('breadcrumbs', 'news'));
        }

        $breadcrumbs = [
            '/news' => 'Новости'
        ];

        $news = News::orderBy('publish', 'desc')->get();

        return view('app.pages.news.news', compact('breadcrumbs', 'news'));
    }

}
