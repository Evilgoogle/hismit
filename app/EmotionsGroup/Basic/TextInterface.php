<?php
namespace App\EmotionsGroup\Basic;

/**
 * Class TextInterface
 * @package App\EmotionsGroup\Basic
 *
 * Этот класс предназначен для вставки текстов интерфейса хранящиеся в базе
 */
class TextInterface
{
    /**
     * @var array
     * Здесь хранятся все текста интерфейса вытащенный из базы
     */
    public $texts;

    /* Шаблон проектирование - Singleton */
    static $instance = false;
    static public function getInstance() {
        if(!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * TextInterface constructor.
     * Делаем запрос в базу
     */
    public function __construct() {
        $this->texts = \Illuminate\Support\Facades\DB::select('SELECT * FROM `language_interfaces`');
    }

    /**
     * @param $get
     * @return mixed
     *
     * Этот метод возвращает текст по переданному ключу. Еще проверяет на тип JSON, если да то возврашет результат
     * обрабатывая языки
     */
    public function get($get) {

        foreach ($this->texts as $text) {
            if($text->key == $get) {
                 if(isJSON($text->data)) {
                     return langFilter($text->data);
                 } else {
                     return $text->data;
                }
            }
        }
    }
}