<?php
/*
  |--------------------------------------------------------------------------
  | Libs
  |--------------------------------------------------------------------------
*/

if (!function_exists('getBlock')) {

    function getBlock($key) {
        return \App\Block::where('key', $key)->where('enable', true)->pluck('desc')->first();
    }
}

if (!function_exists('configKey')) {
    function configKey($key) {
        return App\Config::where('key', $key)->pluck('value')->first();
    }
}

if(!function_exists('isJSON')) {
    /**
     * isJSON - Проверяет не является ли данные в формате json
     * @param $string
     * @return bool
     */
    function isJSON($string) {
        return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
    }
}

// для админки
if(!function_exists('lang_filter')) {
    /**
     * lang_filter - проверяет не является ли данная json массивом,
     * если да то возвращает значение из массива у которого ключ равна языку по умолчанию
     * @param $item
     * @param $json
     * @return mixed
     */
    function lang_filter($item, $json = false)
    {
        if($json) {
            $lang = \App\EmotionsGroup\Language\LangDb::getInstance();
            $lang->get();
            $item = (array)$item['set_lang'];

            //Тут делается isset на тот случай - в $item иногда может не быть языка установленного по умолчанию в $lang->default_lang. Такое может получится если добавили записи в базу и потом добавили новый язык. А этого нового языка нету в массиве запися.
            return isset($item[$lang->default_lang]) ? $item[$lang->default_lang] : '';
        } else {
            if (isJSON($item)) {
                $item = (array)json_decode($item);
                $lang = \App\EmotionsGroup\Language\LangDb::getInstance();
                $lang->get();
                $item = (array)$item['set_lang'];

                //Тут делается isset на тот случай - в $item иногда может не быть языка установленного по умолчанию в $lang->default_lang. Такое может получится если добавили записи в базу и потом добавили новый язык. А этого нового языка нету в массиве запися.
                return isset($item[$lang->default_lang]) ? $item[$lang->default_lang] : '';
            } else {
                return $item;
            }
        }
    }
}

if(!function_exists('langFilter')) {
    /*
     | langFilter - вытаскивает значение из JSON массива запися по языку что идет по умолчанию или по языку что был выбран.
     | @param $item
     | @return mixed
     */
    function langFilter($array, $lang = null) {
        $get_lang = \App\EmotionsGroup\Language\LangDb::getInstance();
        $get_lang->get();

        $def_lang = $get_lang->default_lang;

        if (!empty($lang) && !is_null($lang))
            $get_lang->switch_lang = $lang;

        if (isJSON($array)) {
            $array = json_decode($array);
            foreach ($array as $is_lang=>$langs) {
                foreach ($langs as $lang=>$item) {
                    if($lang == $get_lang->switch_lang) {
                        if (!empty($item))
                            return $item;
                        else {
                            return $langs->$def_lang;
                        }
                    }
                }
            }
        }
    }
}

if(!function_exists('getTexti')) {
    /*
     | getTexti - это функция возвращает ответ от класса TextInterface. Был создан чтоб не писать большой путь к классу
     | @param $item
     | @return mixed
     */
    function getTexti($key) {
        $var = \App\EmotionsGroup\Basic\TextInterface::getInstance();
        return $var->get($key);
    }
}

if(!function_exists('getRoute')) {
    /*
     | getRoute - это функция возвращает путь от $_ENV['routing'] что определяется в /route/web.php
     | @return mixed
     */
    function getRoute() {
        if(empty($_ENV['routing'])) {
            return '';
        } else {
            return '/'.$_ENV['routing'];
        }
    }
}

if(!function_exists('getActiveLang')) {
    /*
     | getActiveLang - это функция возвращает загаловок активного языка
     | @return mixed
     */
    function getActiveLang() {
        $lang = \App\EmotionsGroup\Language\LangDb::getInstance();
        $lang->get();
        $item = \App\Language::where('url', $lang->switch_lang)->first();
        return $item->title;
    }
}

if (!function_exists('svgBlade')) {

    function svgBlade($path, $class) {
        $svg = new \DOMDocument();
        $svg->load($path);
        $svg->documentElement->setAttribute("class", $class);
        $output = $svg->saveXML($svg->documentElement);

        return $output;
    }
}