<?php

namespace App\Http\Controllers\Admin;

use App\EmotionsGroup\Crud\newCrudClass;
use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\EmotionsGroup\Language\LangDb;

class LangController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct() {
        $this->crudClass = new newCrudClass();
        $this->info = (object)[];
        $this->info->head = 'Доступные языки';
        $this->info->url = 'language';
        $this->info->modelName = 'Language';

        $this->middleware('role:admin');
    }

    public function index() {

        $items = Language::all();
        $info = $this->info;

        return view('admin.language.index', compact('items', 'info'));
    }

    public function add() {

        $info = $this->info;

        return view('admin.language.insert', compact('info'));
    }

    public function edit($id)
    {
        $info = $this->info;
        $lang = Language::all();

        try {
            $item = Language::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.language.insert', compact('item', 'info', 'lang'));
    }

    public function remove($id)
    {
        /* Если остается только один язык удалений не будет */
        $lang = Language::all();
        if (count($lang) > 1) {
            $result = $this->crudClass->remove($this->info->modelName, $id);
            return back()->with($result);
        } else {
            return back()->withErrors('Удаление невозможно. Остался только 1 язык');
        }
    }

    public function insert(Request $request, $id = null) {

        $pattern = '#^[a-zA-z]{2}$#';
        $rules = [
            'title' => 'required',
            'url' => 'required|regex:'.$pattern,
            'image' => 'image',
            'fullImage' => 'image'
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $boolean_exceptions = ['enable'];

        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, $boolean_exceptions, null);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);
    }

    public function changePosition(Request $request)
    {
        $result = $this->crudClass->changePosition($this->info->modelName, $request);

        return response()->json($result);
    }

    public function enable(Request $request)
    {
        $result = $this->crudClass->enable($this->info->modelName, $request);

        return response()->json($result);
    }

    public function removeImage(Request $request)
    {
        $result = $this->crudClass->removeImage($request);

        return response()->json($result);
    }

    public function default_lang(Request $request) {
        $lang_default = LangDb::getInstance();
        $lang_default->get();

        $lang = Language::all();

        if(count($lang) > 1 && !empty($lang_default->default_lang_id) && !is_null($lang_default->default_lang_id)) {
            $unset = Language::find($lang_default->default_lang_id);
            $unset->default = false;
            $unset->save();
        }

        foreach ($lang as $item) {
            if($item->id == $request->id) {
                $set = Language::find($item->id);
                $set->default = true;
                $set->save();
            }
        }
        echo 'ok';
    }

}
