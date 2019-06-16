<?php

namespace App\Http\Controllers\Admin;

use App\Http\CrudClass;
use App\Seo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SeoController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->info = (object)[];
        $this->info->head = 'SEO';
        $this->info->url = 'seo';
        $this->info->modelName = 'Seo';
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $items = Seo::all();
        $info = $this->info;

        return view('admin.seo.index', compact(['items', 'info']));
    }

    public function add()
    {
        $info = $this->info;

        return view('admin.seo.insert', compact(['info']));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = Seo::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.seo.insert', compact(['item', 'info']));
    }

    public function remove($id)
    {
        $result = $this->crudClass->remove($this->info->modelName, $id);

        return back()->with($result);
    }

    public function insert(Request $request, $id = null)
    {
        $rules = [
            'url' => 'required',
            'page' => 'required',
/*            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',*/
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, null, null);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);
    }
}
