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
		$arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];
		$sw = file_get_contents($path, false, stream_context_create($arrContextOptions));

        $svg = new \SimpleXMLElement($sw);
        $svg->addAttribute("class", $class);
        $output = $svg->asXML();

        return $output;
    }
}

if (!function_exists('getArrayFromJsonCollection')) {
    function getArrayFromJsonCollection ($items, $requiredField) {
        foreach ($items as $item) {
            $array[] = $item;
        }

        foreach ($array as $key => $value) {
            $value[$requiredField] = langFilter($value['title']);
        }
        return $array;
    }
}

if (!function_exists('url_slug')) {
    function url_slug($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Kazakh
            'Ғ' => 'G', 'Ә' => 'A', 'Қ' => 'K', 'Ң' => 'N', 'Ө' => 'O', 'Ұ' => 'Y', 'Ү' => 'U', 'Һ' => 'H', 'І' => 'I',
            'ғ' => 'g', 'ә' => 'a', 'қ' => 'k', 'ң' => 'n', 'ө' => 'o', 'ұ' => 'y', 'ү' => 'u', 'һ' => 'h', 'і' => 'i',
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        $str = str_replace(array_keys($char_map), $char_map, $str);

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }
}
