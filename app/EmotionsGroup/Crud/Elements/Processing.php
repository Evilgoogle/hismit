<?php
namespace App\EmotionsGroup\Crud\Elements;
use App\EmotionsGroup\Language\LangDb;
use App\Http\CrudClass;
use ElForastero\Transliterate\Transliteration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use \App\Http\FileClass;

/**
 * Class Processing
 * Этот класс занимается стандартной обработкой (add, edit) написанной программистом - Irolik.
 * @package App\EmotionsGroup\Crud\Elements
 */
class Processing
{
    public $result;

    public function __construct($id = null, $modelName, $request, $requestNew, $fileClass, $bools, $files, $upload_url, $url_id) {
        $item = eval('return new \\App\\'. $modelName .';');
        $tableName = $item->getTable();
        if (Schema::hasTable($tableName)) {
            $tableColumns = Schema::getColumnListing($tableName);
            if (isset($id) && !empty($id)) {
                try {
                    $item = eval('return \\App\\' . $modelName . '::findOrFail($id);');
                } catch (\Exception $e) {
                    return $result = [
                        'status' => 'errors',
                        'message' => $e->getMessage()
                    ];
                }
            }

            try {
                /*
                | Это действие работает только в LangController-е.
                | data_lang упаковывается в json тип для хранение в таблице
                | В data_lang - заполняют языки интерефейса
                */
                if ($request->has('data_lang')) {
                    $item->data = json_encode($requestNew->data_lang, JSON_UNESCAPED_UNICODE);
                }
                /* */

                foreach ($requestNew as $key => $value) {

                    if (!in_array($key, $bools) && !in_array($key, $files) && !isset($_FILES[$key]) && in_array($key, $tableColumns)) {
                        /*
                        | Если попадется массив что указывает на наличие языков то идет упаковка в json
                        */
                        if(is_array($value)) {
                            $item->$key = json_encode($value, JSON_UNESCAPED_UNICODE);
                        } else {
                            $item->$key = $value;
                        }
                        /* */

                    }

                    /*
                    | $bools отвечает за переключатель. Переключатель станет в положение - включен
                    */
                    if (in_array($key, $bools) && in_array($key, $tableColumns)) {
                        $item->$key = true;
                    }

                    /*
                    | Здесь идет сохранение загруженных файлов в папке определенной в $upload_url
                    | Сохранением занимается класс FileClass, и он для моделя $item притоговливает свойсвтва
                    | для далнейшего сохранение записи в базе
                    */
                    if (isset($_FILES[$key]) && (!is_array($_FILES[$key]['tmp_name']) || is_object(!$_FILES[$key]['tmp_name'])) && in_array($key, $tableColumns)) {
                        $fileClass->putFile($value, $key, $item, false, $upload_url);
                    }
                }

                /*
                | Состояние переключателя станет отключен
                */
                if (!empty($bools)) {
                    foreach ($bools as $value) {
                        if (array_key_exists($value, $requestNew) === false && in_array($value, $tableColumns)) {
                            $item->$value = false;
                        }
                    }
                }

            } catch (\Exception $e) {
                return $this->result = [
                    'status' => 'errors',
                    'message' => $e->getMessage()
                ];
            }
            $item->save();

            /* Если есть url то она сохранится в базе пройдя обработку в Transliteration */
            if (in_array('position', $tableColumns) || in_array('url', $tableColumns)) {
                if (in_array('url', $tableColumns) && !array_key_exists('url', (array)$requestNew)) {
                    if (in_array('title', $tableColumns) /*&& empty($item->url)*/) {
                        /*
                        | Если попадется массив c ключом set_lang что указывает на наличие языков,
                        | то в Transliteration пойдет title того языка который идет по умолчанию
                        */
                        if(is_array($requestNew->title)) {
                            if(array_key_exists('set_lang', $requestNew->title)) {
                                foreach ($requestNew->title as $title_array) {
                                    foreach($title_array as $language=>$setTitle) {
                                        $lang = LangDb::getInstance();
                                        $lang->get();
                                        if($lang->default_lang == $language) {
                                            if ($url_id == true)
                                                $item->url = Transliteration::make(strip_tags($setTitle), ['type' => 'url', 'lowercase' => true]) .'-'. $item->id;
                                            else
                                                $item->url = Transliteration::make(strip_tags($setTitle), ['type' => 'url', 'lowercase' => true]);
                                        }
                                    }
                                }
                            }

                        } else {
                            $item->url = Transliteration::make(strip_tags($requestNew->title), ['type' => 'url', 'lowercase' => true]) .'-'. $item->id;
                        }
                    }
                }

                $item->save();
            }

            if (!empty($files)) {
                $filesM = new CrudClass();
                $filesM->filesInsert($modelName, $request->only($files), $item->id);
            }


            return $this->result = [
                'status' => 'ok',
                'message' => $item
            ];
        } else
            return $this->result = [
                'status' => 'errors',
                'message' => 'Таблица не существует!'
            ];
    }
}
