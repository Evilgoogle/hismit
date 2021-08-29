<?php
namespace App\EmotionsGroup\Basic;

use App\Filemanager;
use Illuminate\Support\Facades\DB;

class Paginator {

    public $paginate;
    public $start;

    public function go($model_name, $quantities, $conditions = null, $count = null, $model = 'default') {

        // в $count надо отправить число
        if($count === null) {

            if($model == 'default') {

                // Это метод получает count выборки. Сюда дополнительно можно отправлять условий $conditions, чтоб регулировать count
                $count_page = eval('return \\App\\'.$model_name.'::paginator('.json_encode($conditions).');');
            } elseif ('filemanager') {

                $count_page = Filemanager::select('id')->count();
            }
        } else {

            $count_page = $count;
        }

        $total = intval(($count_page - 1) / $quantities) + 1;
        if(!isset($_GET['page'])) {
            $_GET['page'] = 1;
        } elseif($_GET['page'] < 1) {
            $_GET['page'] = 1;
        }

        if($_GET['page'] >= $total) {
            $_GET['page'] = $total;
        }

        $this->paginate = [
            'page' => $_GET['page'],
            'total' => $total,
        ];

        $this->start = $_GET['page'] * $quantities - $quantities;
    }

    public function ajax($quantities, $page, $conditions = null, $model = 'news') {

        if($model == 'news') {

            $count_page = News::paginator($conditions);
        } elseif($model == 'filemanager') {

            $count_page = Filemanager::select('id')->count();
        }

        $total = intval(($count_page - 1) / $quantities) + 1;

        $this->paginate = [
            'page' => $page,
            'total' => $total,
        ];

        $this->start = $page * $quantities - $quantities;

    }
}