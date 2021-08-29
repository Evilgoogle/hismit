<?php
namespace App\EmotionsGroup\Crud;

use App\EmotionsGroup\Language\LangDb;
use App\EmotionsGroup\Basic\Transliteration;
use Illuminate\Support\Facades\Schema;

class CrudClass extends \App\Http\CrudClass {

    public function insert($modelName, $id = null, $request, $exceptions = null, $boolean_exceptions = null, $file_exceptions = null, $upload_url = null, $url_id = true)
    {
        if (!empty($exceptions) && isset($exceptions))
            $exceptions_new = array_merge(['_token'], $exceptions);
        else
            $exceptions_new = ['_token'];

        $bools = [];
        if (!empty($boolean_exceptions) && isset($boolean_exceptions))
            $bools = $boolean_exceptions;

        $files = [];
        if (!empty($file_exceptions) && isset($file_exceptions))
            $files = $file_exceptions;

        $requestNew = (object)$request->except($exceptions_new);

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
                    }

                    if (in_array($key, $bools) && in_array($key, $tableColumns)) {
                        $item->$key = true;
                    }

                    if (isset($_FILES[$key]) && (!is_array($_FILES[$key]['tmp_name']) || is_object(!$_FILES[$key]['tmp_name'])) && in_array($key, $tableColumns)) {
//                      $this->fileClass->removeFile($key);
                        $this->fileClass->putFile($value, $key, $item, false, $upload_url);
                    }
                }

                if (!empty($bools)) {
                    foreach ($bools as $value) {
                        if (array_key_exists($value, $requestNew) === false && in_array($value, $tableColumns)) {
                            $item->$value = false;
                        }
                    }
                }
            } catch (\Exception $e) {
                return $result = [
                    'status' => 'errors',
                    'message' => $e->getMessage()
                ];
            }

            $item->save();

            if (in_array('url', $tableColumns)) {
                if (in_array('title', $tableColumns)) {
                    $array_map = [
                        "&amp;" => "&",
                        "amp;" => "&",
                        "&nbsp;" => " ",
                        "nbsp;" => " ",
                        "&laquo;" => "«",
                        "laquo;" => "«",
                        "&raquo;" => "»",
                        "raquo;" => "»",
                        "&ndash;" => "–",
                        "ndash;" => "–",
                        "&mdash;" => "—",
                        "mdash;" => "—",
                        "&lsquo;" => "‘",
                        "lsquo;" => "‘",
                        "&rsquo;" => "’",
                        "rsquo;" => "’",
                        "&sbquo;" => "‚",
                        "sbquo;" => "‚",
                        "&ldquo;" => "“",
                        "ldquo;" => "“",
                        "&rdquo;" => "”",
                        "rdquo;" => "”",
                        "&bdquo;" => "„",
                        "bdquo;" => "„",
                        "&hellip;" => "…",
                        "hellip;" => "…",
                        "&prime;" => "′",
                        "prime;" => "′",
                        "&Prime;" => "″",
                        "Prime;" => "″"
                    ];

                    if(isset($requestNew->url)) {
                        if($id == null) {
                            if ($url_id == true) {
                                $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($requestNew->url, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]) . '-' . $item->id;
                            } else {
                                $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($requestNew->url, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]);
                            }
                        } else {
                            if($item->url != $requestNew->url) {
                                $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($requestNew->url, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]);
                            }
                        }
                    } else {
                        /*
                        | Если попадется массив c ключом lang что указывает на наличие языков,
                        | то в Transliteration пойдет title того языка который идет по умолчанию
                        */
                        if(is_array($requestNew->title)) {
                            if(array_key_exists('lang', $requestNew->title)) {
                                foreach ($requestNew->title['lang'] as $language => $setTitle) {
                                    $lang = LangDb::getInstance();
                                    $lang->get();

                                    if ($lang->default_lang == $language) {
                                        if($url_id == true) {
                                            $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($setTitle, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]).'-'.$item->id;
                                        } else {
                                            $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($setTitle, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]);
                                        }
                                    }
                                }
                            }
                        } else {
                            if($url_id == true) {
                                $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($requestNew->title, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]).'-'.$item->id;
                            } else {
                                $item->url = Transliteration::make(strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($requestNew->title, null, 'utf-8')))), ['type' => 'url', 'lowercase' => true]);
                            }
                        }
                    }
                }

                $item->save();
            }

            if (!empty($files)) {
                $this->filesInsert($modelName, $request->only($files), $item->id);
            }

            $result = [
                'status' => 'ok',
                'message' => $item
            ];
        } else
            $result = [
                'status' => 'errors',
                'message' => 'Таблица не существует!'
            ];

        return $result;
    }
}
