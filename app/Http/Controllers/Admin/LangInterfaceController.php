<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use App\EmotionsGroup\Crud\newCrudClass;
use App\LanguageInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LangInterfaceController extends Controller
{
    protected $control = false;
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new newCrudClass();
        $this->info = (object)[];
        $this->info->head = 'Интерфейс';
        $this->info->url = 'language-interface';
        $this->info->modelName = 'LanguageInterface';

        /* Включение и отклчючение возможности добавить и удалить текста интерефейса*/
        if(config('emotions.language_developer')) {
            $this->control = true;
        } else {
            $this->control = false;
        }

        $this->middleware('role:admin');
    }

    public function index() {

        $items = LanguageInterface::all();
        $info = $this->info;
        $control = $this->control;

        return view('admin.language-interface.index', compact('items', 'info', 'control'));
    }

    public function add() {

        $info = $this->info;
        $allLang = Language::orderBy('position', 'asc')->get();

        return view('admin.language-interface.insert', compact('info', 'allLang'));
    }

    public function edit($id)
    {
        $info = $this->info;
        $allLang = Language::orderBy('position', 'asc')->get();

        try {
            $item = LanguageInterface::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.language-interface.insert', compact('item', 'info', 'allLang'));
    }

    public function insert(Request $request, $id = null)
    {
//        $pattern = '#^[a-zA-zа-яА-Я0-9\_\-]*$#';
        $rules = [
//            'name' => 'required',
            'key' => 'required'/*|regex:'.$pattern*/
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, null, null);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);

    }

    public function remove($id)
    {
        if($this->control) {
            $result = $this->crudClass->remove($this->info->modelName, $id);

            return back()->with($result);
        }
    }
}
