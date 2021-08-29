<?php

namespace App\Console\Commands;

use App\EmotionsGroup\Basic\NewsParse\GetRSS;
use App\EmotionsGroup\Basic\NewsParse\NewsSave;
use Illuminate\Console\Command;

class NewsParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsparse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing news in RSS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $rss = new GetRSS();
            $rss->url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
            $rss->go();

            $data = $rss->result;
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        $set = new NewsSave($data);
        $set->save();

        dd('Парсинг прошел успешно');
    }
}
