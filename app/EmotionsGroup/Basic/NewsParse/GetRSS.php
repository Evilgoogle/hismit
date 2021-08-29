<?php
namespace App\EmotionsGroup\Basic\NewsParse;

use App\NewsLog;
use Carbon\Carbon;
use willvincent\Feeds\Facades\FeedsFacade;

class GetRSS
{
    public $result;
    public $url;

    public function go() {
        // Проверка
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);

        $error = false;
        $info = curl_getinfo($ch);
        if ($content === false) {
            $error = curl_error($ch);
        } elseif ($info['http_code'] != 200) {
            $error = 'Не удалось получить RSS: '.$info['http_code'];
        }

        // Логирование и вывод результата
        $this->log($info, $content);
        if($error) {
            throw new \Exception($error);
        }

        $this->makeResult();
        curl_close($ch);
    }

    private function makeResult() {
        $feed = FeedsFacade::make($this->url);
        $this->result = ($feed->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['item']);
    }

    private function log($info, $body) {
        $set = new NewsLog();
        $set->pubDate = Carbon::now();
        $set->url = $info['url'];
        $set->http_code = $info['http_code'];
        $set->body = $body;
        $set->save();
    }
}
