<?php

namespace App\EmotionsGroup\Language;

/**
 * Class langBoxs
 * Этот класс выдает кнопки с языками
 * @package App\Language
 */
class LangBoxs
{
    static function get() {
        $lang = LangDb::getInstance();

        if(config('emotions.language_switch')) {?>
            <div class="lang_switch">
                <?php foreach ($lang->get() as $item) {?>
                    <button class="bn js_switch <?php if($lang->default_lang == $item->url) {?> active <?php }?>" data-switch="<?php echo htmlspecialchars($item->url)?>"><?php echo htmlspecialchars($item->url)?></button>
                <?php }?>
            </div>
        <?php }
    }
}