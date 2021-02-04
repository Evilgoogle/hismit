<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            [
                'title' => 'Рус',
                'url' => 'ru',
                'default' => 1,
                'position' => 1
            ],
            [
                'title' => 'Қаз',
                'url' => 'kz',
                'default' => 0,
                'position' => 2
            ],
            [
                'title' => 'Eng',
                'url' => 'en',
                'default' => 0,
                'position' => 3
            ]
        ];

        foreach ($languages as $lang) {
            $newLang = Language::where('url', '=', $lang['url'])->first();
            if ($newLang === null) {
                Language::create([
                    'title' => $lang['title'],
                    'url' => $lang['url'],
                    'default' => $lang['default'],
                    'position' => $lang['position'],
                ]);
            }
        }
    }
}
