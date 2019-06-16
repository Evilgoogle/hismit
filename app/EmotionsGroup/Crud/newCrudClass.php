<?php
namespace App\EmotionsGroup\Crud;
use App\EmotionsGroup\Crud\Elements\Ontomany;
use App\EmotionsGroup\Crud\Elements\Processing;

/**
 * Class newCrudClass
 * Этот класс наследует \App\Http\CrudClass и в метод insert добавляет дополнительные возможности:
 * 1. Возможность в массиве отправить несколько модели в $modelName (['news', 'goods']) - этим можно добавить записи в несколко таблиц
 * 2. Подключать другие обработчики передав в insert параметр $custom. По умолчанию подключается класс Processing что занимается add edit записей
 *
 * @package App\EmotionsGroup\Crud
 */
class newCrudClass extends \App\Http\CrudClass {

    /**
     * @param $modelName
     * @param null $id
     * @param $request
     * @param null $exceptions
     * @param null $boolean_exceptions
     * @param null $file_exceptions
     * @param null $upload_url
     * @param null $custom - если мы хотим подключить другие обработчики, то отправляем сюда массив с элементами
     * @return array
     */
    public function insert($modelName, $id = null, $request, $exceptions = null, $boolean_exceptions = null, $file_exceptions = null, $upload_url = null, $custom = null) {

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

        /*
        | Здесь идет проверка не является ли $modelName массивом что указывает что мы будем работать с нескольками таблицами.
        | Если да то перебираем эти модели и каждую отправляем в класс Model для обработки
        | Если нет то работает стандартный код - отправляется одна модель.
        */
        if(is_array($modelName)) {
            /*
            | Проверка и подключение другого обработчика, иначе идет обработка каждого моделя по отдельности
            | Пока существует только один дополнительный обработчик - класс OneToMany
            */
            if($custom != null && is_array($custom)) {
                foreach ($custom as $class=>$parameter) {
                    if($class == 'one-to-many') {
                        /* ---- Ontomany -------
                        | Подключается класс Ontomany которая делает добавлеие записи в таблицу, а также
                        | делает добавление записи дополнительную еще одну таблицу
                        */
                        $result = (new Ontomany($id, $modelName, $request, $requestNew, $parameter, $this->fileClass, $bools, $files, $upload_url))->result;
                    }
                }
            } else {
                foreach ($modelName as $model) {
                    /* ---- Processing -------
                    | Стандартная обработка данных каждого моделя
                    */
                    $result = (new Processing($id, $model, $request, $requestNew, $this->fileClass, $bools, $files, $upload_url))->result;
                }
            }
        } else {
            /* ---- Processing -------
            | Стандартная обработка данных
            */
            $result = (new Processing($id, $modelName, $request, $requestNew, $this->fileClass, $bools, $files, $upload_url))->result;
        }

        return $result;
    }
}