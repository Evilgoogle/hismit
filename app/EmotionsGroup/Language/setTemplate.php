<?php
namespace App\EmotionsGroup\Language;

/**
 * Class setTemplate
 * Этот класс занимается добавлением шаблонов
 * @package App\Language
 */
class setTemplate
{
    public $item;
    public $required;
    public $sets;

    /**
     * setTemplate constructor.
     * Приготавляет нужные вещи
     * @param $array
     */

    public function __construct($array) {
        $this->sets = $array;
        $this->required = isset($array['required']) && $array['required'] ? 'required' : '';

        $item = $array['name'];
        $element = isset($array['item']->$item) ? $array['item']->$item : '';
        if(isJSON($element)) {
            $this->item = json_decode($element);
        } else {
            $this->item = $element;
        }
    }

    /**
     * set
     * Устанавливает шаблон
     * @return string
     */
    public function set() {

        if(config('emotions.language_switch') === false) {

            echo 'вызовите include()';

        } elseif(config('emotions.language_switch') === true) {

            $lang = LangDb::getInstance();
            $land_data = $lang->get();

            foreach ($land_data as $value) { $url = $value->url ?>
                <div class="langActive_insert <?php if($lang->default_lang == $value->url) {?> active_insert <?php }?> js_lang_<?php echo $value->url ?>">
                    <h2 class="card-inside-title"><?php echo $this->sets['label'] ?></h2>
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">

                                    <!-- Проверка type. По переданному значению подключается нужный шаблон -->
                                    <?php if(isset($this->sets['input_type'])) {
                                        if($this->sets['input_type'] == 'input') {?>

                                            <input
                                                class="form-control"
                                                type="<?php echo isset($this->sets['type']) ? $this->sets['type'] : 'text' ?>"
                                                name="<?php echo $this->sets['name'].'[set_lang]['.$value->url.']' ?>"
                                                placeholder="<?php echo $this->sets['label'] ?>"
                                                value="<?php echo isset($this->item->set_lang->$url) ? htmlspecialchars($this->item->set_lang->$url) : '' ?>"
                                                <?php if($lang->default_lang == $value->url) { echo $this->required; } ?>>

                                        <?php } elseif ($this->sets['input_type'] == 'textarea') {?>

                                            <textarea
                                                class="form-control <?php echo isset($this->sets['editor']) && $this->sets['editor'] ? 'text-editor' : '' ?><?php echo isset($this->sets['editor_type']) && $this->sets['editor_type'] ? '-'.$this->sets['editor_type'] : '' ?>"
                                                name="<?php echo $this->sets['name'].'[set_lang]['.$value->url.']'?>"
                                                placeholder="<?php echo $this->sets['label'] ?>"
                                                <?php if (isset($this->sets['editor']) && $this->sets['editor']) {
                                                    echo isset($this->sets['name']) ? $this->sets['name'] : '';
                                                }?>
                                            ><?php echo isset($this->item->set_lang->$url) ? $this->item->set_lang->$url : '' ?></textarea>

                                        <?php }
                                    } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }

        }
    }
}
