<?php

namespace App\Http\Controllers\Admin;

use App\Http\CrudClass;
use App\News;
use App\NewsMedia;
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
        $this->middleware('role:admin');
    }

    public function index()
    {
        $items = News::orderBy('pubDate', 'desc')->get();
        $info = $this->info;

        return view('admin.news.index', compact('items', 'info'));
    }

    public function add()
    {
        $info = $this->info;

        return view('admin.news.insert', compact('info'));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = News::findOrFail($id);
            $files = NewsMedia::where('item_id', $item->id)->get();
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.news.insert', compact('item', 'files', 'info'));
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
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, null, null, null, false);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);
    }

}
