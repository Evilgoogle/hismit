<?php
namespace App\EmotionsGroup\Basic\NewsParse;

use App\News;
use App\NewsMedia;

class NewsSave
{
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function save() {
        foreach ($this->data as $d) {
            $item = $d['child'][''];

            $set = new News();
            $set->title = $item['title'][0]['data'];
            $set->url = $item['link'][0]['data'];
            $set->desc = $item['description'][0]['data'];
            $set->author = (array_key_exists('author', $item)) ? $item['author'][0]['data'] : null;
            $set->pubDate = date('Y-m-d h:i:s', strtotime($item['pubDate'][0]['data']));
            $set->save();

            if(array_key_exists('enclosure', $item)) {
                $this->media($set->id, $item['enclosure']);
            }
        }
    }

    private function media($id, $enclosure) {
        foreach ($enclosure as $e) {
            $file = new NewsMedia();
            $file->item_id = $id;
            $file->type = $e['attribs']['']['type'];
            $file->file = $e['attribs']['']['url'];
            $file->save();
        }
    }
}
