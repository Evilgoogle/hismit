<?php
namespace App\EmotionsGroup\Basic;

include_once(app_path('Helpers/simple_html_dom.php'));

/**
 * Class ClearRSS - этот класс занмается очишением и перброзованеим img тегов для YANDEX ZEN
 * @package App\EmotionsGroup\Basic
 */
class ClearRSS {

    public $images = [];

    /**
     * @param $text - принимает текст от ckeditor
     * @return bool|\simple_html_dom
     */
    public function get($text) {

        // Чистка от не нужнго html
        $text = strip_tags($text, '<img> <p> <a>');
        $new_text = str_get_html($text);

        // Преоброзование
        $replace = "img";
        if($new_text) {
            foreach ($new_text->find('img') as $key => $element) {
                $new_text->find($replace, $key)->outertext = (array_key_exists('src', $element->attr)) ?
                    '
                    <figure>
                        <img src="'.asset($element->attr['src']).'">
                        <figcaption>'.$element->attr['alt'].'</figcaption>
                    </figure>
                    '
                    : '';
                $this->images[] = array_key_exists('src', $element->attr) ? $element->attr['src'] : '';
            }
        }

        return $new_text;
    }
}