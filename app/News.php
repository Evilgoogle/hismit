<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class News extends Model implements Searchable
{

    public function getSearchResult(): SearchResult
    {
        $url = route('news.show', $this->url);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }

}
