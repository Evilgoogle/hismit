<?php

namespace App\Http;

use ElForastero\Transliterate\Map;
use ElForastero\Transliterate\Transliterator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class CrudClass
{
    protected $fileClass;

    public function __construct()
    {
        $this->fileClass = new FileClass();
    }

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

        $requestNew = (object)$request->except($exceptions_new);
        $title_url = strip_tags(trim(str_replace(array_keys($array_map), array_values($array_map), htmlentities($requestNew->title, null, 'utf-8'))));

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
                        if (is_null($value))
                            $item->$key = null;
                        else
                            $item->$key = $value;
                    }

                    if (in_array($key, $bools) && in_array($key, $tableColumns)) {
                        $item->$key = true;
                    }

                    if (isset($_FILES[$key]) && (!is_array($_FILES[$key]['tmp_name']) || is_object(!$_FILES[$key]['tmp_name'])) && in_array($key, $tableColumns)) {
                        $this->fileClass->removeFile($key);
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

            if (in_array('position', $tableColumns) || in_array('url', $tableColumns)) {
                if (in_array('position', $tableColumns)) {
                    $item->position = $item->id;
                }

                if (in_array('url', $tableColumns) && !array_key_exists('url', (array)$requestNew)) {
                    if (in_array('title', $tableColumns)/* && empty($item->url)*/) {
                        $transliterator = new Transliterator(Map::LANG_RU, Map::GOST_7_79_2000);

                        if ($url_id == true)
                            $item->url = $transliterator->slugify($title_url) .'-'. $item->id;
                        else
                            $item->url = $transliterator->slugify($title_url);
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

    public function remove($modelName, $id)
    {
        try {
            $item = eval('return \\App\\'. $modelName .'::findOrFail($id);');
        } catch (\Exception $e) {
            return $result = [
                'status' => 'errors',
                'message' => $e->getMessage()
            ];
        }

        if (eval('return \\App\\'. $modelName .'::destroy($id);')) {
            return $result = [
                'status' => 'ok',
                'message' => 'Запись удалена'
            ];
        } else
            return $result = [
                'status' => 'errors',
                'message' => 'Ошибка, попробуйте снова'
            ];
    }

    public function changePosition($modelName, $request)
    {
        $rules = [
            'id' => 'required',
            'position' => 'required'
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails())
            return $result = [
                'status' => 'errors',
                'message' => $v->errors()
            ];

        $id = $request->id;
        $position = $request->position;

        try {
            try {
                $item = eval('return \\App\\'. $modelName .'::findOrFail($id);');
            } catch (\Exception $e) {
                return $result = [
                    'status' => 'errors',
                    'message' => $e->getMessage()
                ];
            }

            $item->position = $position;
            $item->save();

            return $result = [
                'status' => 'ok',
                'message' => 'Позиция сменена'
            ];
        } catch (\Exception $e) {
            return $result = [
                'status' => 'errors',
                'message' => $e->getMessage()
            ];
        }
    }

    public function enable($modelName, $request)
    {
        $rules = [
            'id' => 'required',
            'check' => 'required'
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails())
            return $result = [
                'status' => 'errors',
                'message' => $v->errors()
            ];

        $id = $request->id;
        $check = $request->check;

        try {
            try {
                $item = eval('return \\App\\'. $modelName .'::findOrFail($id);');
            } catch (\Exception $e) {
                return $result = [
                    'status' => 'errors',
                    'message' => $e->getMessage()
                ];
            }

            $check = $check == 1 ? 0 : 1;
            $item->enable = $check;
            $item->save();

            $tableName = $item->getTable();
            if (Schema::hasTable($tableName)) {
                $tableColumns = Schema::getColumnListing($tableName);
                if (in_array('parent', $tableColumns)) {
                    eval('\\App\\'. $modelName .'::where("parent", $id)->update(["enable" => $check]);');
                }
            }

            return $result = [
                'status' => 'ok',
                'message' => 'Состояние изменено',
                'value' => $check
            ];
        } catch (\Exception $e) {
            return $result = [
                'status' => 'errors',
                'message' => $e->getMessage()
            ];
        }
    }

    public function filesInsert($modelName, $request, $id = null)
    {
        if (!empty($request)) {
            foreach ($request as $key => $value) {
                foreach ($value as $v) {
                    try {
                        $item = eval('return new \\App\\' . $modelName . substr(getCamelCase($key), 0, -1) . '();');
                    } catch (\Exception $e) {
                        return $result = [
                            'status' => 'errors',
                            'message' => $e->getMessage()
                        ];
                    }

                    $tableName = $item->getTable();
                    if (Schema::hasTable($tableName)) {
                        $tableColumns = Schema::getColumnListing($tableName);

                        if (in_array(substr($key, 0, -1), $tableColumns) && isset($_FILES[$key]) && (is_array($_FILES[$key]['tmp_name']) || is_object($_FILES[$key]['tmp_name'])) && !empty($_FILES[$key]['tmp_name'])) {
                            $this->fileClass->putFile($v, $key, $item, true, null);

                            if (isset($id) && !empty($id))
                                $item->item_id = $id;
                        }
                        $item->save();
                    } else {
                        return $result = [
                            'status' => 'errors',
                            'message' => 'Таблица не существует'
                        ];
                    }
                }
            }

            $result = [
                'status' => 'ok',
            ];
        }
        else
            $result = [
                'status' => 'ok'
            ];

        return $result;
    }

    public function removeImage($request)
    {
        $rules = [
            'id' => 'required',
            'model' => 'required',
            'column' => 'required',
            'remove' => 'required'
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails())
            return $result = [
                'status' => 'errors',
                'message' => $v->errors()
            ];

        $id = $request->id;
        $modelName = $request->model;
        $columnName = $request->column;
        $remove = $request->remove;

        try {
            try {
                $item = eval('return \\App\\'. $modelName .'::findOrFail($id);');
            } catch (\Exception $e) {
                return $result = [
                    'status' => 'errors',
                    'message' => $e->getMessage()
                ];
            }

            $this->fileClass->removeFile($item->$columnName);

            if($remove == 1) {
                $item->delete();
            } else {
                $item->$columnName = null;
                $item->save();
            }

            return $result = [
                'status' => 'ok',
                'message' => 'Изображение удалено',
            ];
        } catch (\Exception $e) {
            return $result = [
                'status' => 'errors',
                'message' => $e->getMessage()
            ];
        }
    }
}

function getCamelCase($string)
{
    $str = explode('_', $string);
    foreach ($str as $key => $value) {
        $str[$key] = ucwords($value);
    }

    return implode($str);
}
