<?php
namespace App\EmotionsGroup\Crud\Elements;
use ElForastero\Transliterate\Transliteration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use \App\Http\FileClass;

/**
 * Class Ontomany
 * Класс выполняет стандартное сохранение записи в таблице, а также добавлят записи в другую таблицу и связывает эту запись с id добавленной записи.
 * Это нужно например: Допустим есть каталог товаров и при добавлений или редактирование товара картины этого товара потребуется сохранить отдельно от основной таблицы. В этом случае пригодится этот класс.
 * @package App\EmotionsGroup\Crud\Elements
 */
class Ontomany
{
    public $result;
    public $status_main;
    public $status_cat;

    /**
     * Ontomany constructor.
     * @param null $id - наличие id указывает что запись будет редактироватся
     * @param $modelName - Массив моделей. Должна отправится 2 моделя в массиве - ['ShortStory', 'HistoryGallery']. 1 - это главная модель, 2 - дополнительная.
     * @param $request - обычный request приходящий при POST
     * @param $requestNew - обычный request приходящий при POST без поле Token (она убирается класса newCrudClass)
     * @param $parameter - этот параметр обязателенв этом классе. В нем должен быть массив с такими параметрами:
     * [
            'request' => 'blockImage',
            'link' => 'history_id'
        ]
     * request - приходяшем request в POST запросе должна быть поле нарпример с названием blockImage и c такими данными:
     * [
     *  'insert' => [
     *      1 => [
     *          'title' => 'Alex',
     *          'text' => 'Hello world'
     *      ]
     *  ]
     *  'edit' => []
     * ]
     * Здесь указызываем название этого поле. Данные этого поле будут добавленные во 2 таблицу после обработки основного.
     * link - здесь указываем название столбца 2 таблицы, где будет сохранятся id основного запися.
     * @param $fileClass - сюда приходит класс fileClass
     * @param $bools - положение переключателся
     * @param $files
     * @param $upload_url - временная папка для картин
     */
    public function __construct($id = null, $modelName, $request, $requestNew, $parameter, $fileClass, $bools, $files, $upload_url) {
        foreach ($modelName as $key=>$model) {
            if($key == 0) {
                $main_model = $model;
            }
            if($key == 1) {
                $cat_model = $model;
            }
        }
        /* |||||||| Добавляется запись в главную таблицу  |||||||| */

        $item = eval('return new \\App\\'. $main_model .';');
        $tableName = $item->getTable();
        if (Schema::hasTable($tableName)) {
            $tableColumns = Schema::getColumnListing($tableName);
            if (isset($id) && !empty($id)) {
                try {
                    $item = eval('return \\App\\' . $main_model . '::findOrFail($id);');
                } catch (\Exception $e) {
                    return $this->result = [
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
                if (in_array('url', $tableColumns) && !in_array('url', (array)$requestNew)) {
                    if (in_array('title', $tableColumns) && empty($item->url)) {
                        $item->url = Transliteration::make(strip_tags($requestNew->title), ['type' => 'url', 'lowercase' => true]) .'-'. $item->id;
                    }
                }

                $item->save();
            }

            if (!empty($files)) {
                $this->filesInsert($modelName, $request->only($files), $item->id);
            }

           $this->status_main = 'ok';

        } else
            return $this->result = [
                'status' => 'errors',
                'message' => 'Таблица не существует!'
            ];


        /* |||||||| Добавление записи в дополнительную таблицу |||||||| */

        $table_link = $parameter['link'];
        $parameter = $parameter['request'];

        /* Пересобираю $_FILES для дальнейших проверок */
        $files = [];
        if(isset($_FILES[$parameter])) {
            foreach($_FILES[$parameter] as $file_type=>$file_array) {
                foreach ($file_array as $method=>$method_array) {
                    foreach ($method_array as $file_id=>$file_block) {
                        foreach ($file_block as $file_key=>$file_item) {
                            $files[$method][$file_id][$file_key][$file_type] = $file_item;
                        }
                    }
                }
            }
        }
        try {
            if(isset($requestNew->$parameter)) {
                /* Если есть добавляемые записи */
                if(array_key_exists('insert',$requestNew->$parameter)) {
                    foreach ($requestNew->$parameter['insert'] as $get_id => $array) {
                        $cat = eval('return new \\App\\'. $cat_model .';');
                        $tableName = $cat->getTable();
                        if (Schema::hasTable($tableName)) {
                            $tableColumns = Schema::getColumnListing($tableName);
                            foreach ($array as $key=>$value) {
                                /*
                                | $table_link - здесь название столбца таблицы предназначенный для связки
                                | Заполняю специальное поле для связки таблицы $cat_model с основной $main_model
                                | $item->id - это id только что добавленный записи в $item
                                */
                                $cat->$table_link = $item->id;

                                /* приготавливаю текстовые свойства моделя */
                                if(in_array($key, $tableColumns) && !isset($files['insert'][$get_id][$key])) {
                                    /*
                                    | Если попадется массив что указывает на наличие языков то идет упаковка в json
                                    */
                                    if(is_array($value)) {
                                        $cat->$key = json_encode($value, JSON_UNESCAPED_UNICODE);
                                    } else {
                                        $cat->$key = $value;
                                    }
                                    /* */
                                }

                                /* приготавливаю файловые свойства моделя*/
                                if (isset($files['insert'][$get_id][$key]) && in_array($key, $tableColumns)) {
                                    $fileClass->putFile($value, $key, $cat, false, $upload_url);
                                }
                            }
                        } else {
                            return $this->result = [
                                'status' => 'errors',
                                'message' => 'Таблица не существует!'
                            ];
                        }
                        $cat->save();
                    }
                }

                /* Если есть редактируемые записи */
                if(array_key_exists('edit',$requestNew->$parameter)) {
                    $cat = eval('return new \\App\\'. $cat_model .';');
                    $tableName = $cat->getTable();
                    if (Schema::hasTable($tableName)) {
                        $tableColumns = Schema::getColumnListing($tableName);
                        /* Тут вытаскивается коллекция записей по $table_link */
                        try {
                            $cat = eval('return \\App\\' . $cat_model . '::where(\''.$table_link.'\', $id);');
                        } catch (\Exception $e) {
                            return $this->result = [
                                'status' => 'errors',
                                'message' => $e->getMessage()
                            ];
                        }
                        /*
                        | Тут для каждой колекций устанавливаются свойства моделей нужно что сделать
                        | сохранение сохранение в базе
                        */
                        foreach($cat->get() as $collect) {
                            foreach ($requestNew->$parameter['edit'] as $get_id => $array) {
                                if($collect->id == $get_id) {
                                    foreach ($array as $key => $value) {
                                        /* приготавливаю текстовые свойства моделя */
                                        if (in_array($key, $tableColumns) && !isset($files['edit'][$get_id][$key])) {
                                            /*
                                            | Если попадется массив что указывает на наличие языков то идет упаковка в json
                                            */
                                            if (is_array($value)) {
                                                $collect->$key = json_encode($value, JSON_UNESCAPED_UNICODE);
                                            } else {
                                                $collect->$key = $value;
                                            }
                                        }

                                        /* приготавливаю файловые свойства моделя*/
                                        if (isset($files['edit'][$get_id][$key]) && in_array($key, $tableColumns)) {
                                            $fileClass->putFile($value, $key, $collect, false, $upload_url);
                                        }
                                    }
                                    $collect->save();
                                }
                            }
                        }

                    } else {
                        return $this->result = [
                            'status' => 'errors',
                            'message' => 'Таблица не существует!'
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            return $this->result = [
                'status' => 'errors',
                'message' => $e->getMessage()
            ];
        }

        $this->status_cat = 'ok';

        /* result */
        if($this->status_main == 'ok' && $this->status_cat == 'ok') {
            return $this->result = [
                'status' => 'ok',
                'message' => $item
            ];
        }
    }
}
