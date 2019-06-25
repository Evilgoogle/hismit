<?php

namespace App\EmotionsGroup\Language;

use App\Language;
use Illuminate\Support\Facades\Schema;

/**
 * Class LangDb
 * Этот класс выдает список всех языков из таблицы Language и определяет язык по умолчанию.
 * @package App\Language
 */
class LangDb {

    /**
     * @var
     * Все языки вытащенные из базы
     */
    public $lang;

    /**
     * @var
     * Язык по умолчанию
     */
    public $default_lang;
    public $default_lang_id;
    public $default_lang_title;
    public $switch_lang = '';

    /**
     * LangDb constructor.
     * Делаем запрос в базу
     */
    public function __construct() {
        $this->lang = [];

        if (Schema::hasTable('languages'))
        {
            $this->lang = Language::orderBy('position', 'asc')->get();
        }
    }

    /* Шаблон проектирование - Singleton */
    static $instance = false;
    static public function getInstance() {
        if(!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @return array
     * Это функция устанавливает языки по умолчанию и передает список языков вытащенный из базы. За счет функций getInstance запрос в базу по несколько раз не даелается. Это функция передает ранее сохраненый результат.
     */
    public function get() {
        /* Получаю язык которая по умолчанию */
        foreach ($this->lang as $item) {
            if($item->default == true) {
                $this->default_lang = $item->url;
                $this->default_lang_id = $item->id;
                $this->default_lang_title = $item->title;
            }
        }

        return $this->lang;
    }
}
