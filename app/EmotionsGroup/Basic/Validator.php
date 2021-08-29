<?php
namespace App\EmotionsGroup\Basic;
use App\EmotionsGroup\Language\LangDb;

/**
 * Class Validator
 * Этот класс делает обычну проверку и проверяет данные которые могут передоватся массивом если включена языковая поддержка. В массиве проверяется только та данная у которого язык равен языку которая сейчас по умолчанию.
 *
 * @package App\EmotionsGroup\Basic
 */
class Validator
{

    public $info = 'ok';

    public function make($request, $rules) {
        /* Здесь отдельно извлекаются те значений у которого ключ set_lang. Set_lang указывают на наличие языков в массиве*/
        $lang_data = [];
        foreach ($request as $key=>$array) {
            if(is_array($array)) {
                if(array_key_exists('set_lang',$array)) {
                    foreach ($array as $item) {
                        $lang_data[$key] = $item;
                        unset($request[$key]);
                    }
                }
            }
        }

        /* Извлечение даных по языку которая сейчас по умолчанию */
        $langDefault = new LangDb();
        $langDefault->get();
        $analysis = [];

        foreach ($lang_data as $key=>$langs) {
            foreach ($langs as $lang=>$stub) {
                if($langDefault->default_lang == $lang) {
                    $analysis[$key] = $langs[$langDefault->default_lang];
                }
            }
        }

        /* Валидация */
        $v = \Illuminate\Support\Facades\Validator::make(array_merge($analysis, $request), $rules);
        if ($v->fails()) {
            $this->info = $v->messages();
        }
    }

    public function fails() {
        return $this->info;
    }

}