<?php

namespace App\Http\Controllers\Admin;

use App\Http\CrudClass;
use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->info = (object)[];
        $this->info->head = 'Новости';
        $this->info->url = 'news';
        $this->info->modelName = 'News';
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $items = News::orderBy('publish', 'desc')->get();
        $info = $this->info;

        return view('admin.news.index', compact(['items', 'info']));
    }

    public function add()
    {
        $info = $this->info;

        return view('admin.news.insert', compact(['info']));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = News::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.news.insert', compact(['item', 'info']));
    }

    public function remove($id)
    {
        $result = $this->crudClass->remove($this->info->modelName, $id);

        return back()->with($result);
    }

    public function insert(Request $request, $id = null)
    {
        $rules = [
            'title' => 'required',
            'desc' => 'required',
            'image' => 'image',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, null, null, null, false);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);
    }

    public function removeImage(Request $request)
    {
        $result = $this->crudClass->removeImage($request);

        return response()->json($result);
    }

}
