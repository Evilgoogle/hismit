<?php

namespace App\Http\Controllers\Admin;

use App\Block;
use App\Http\CrudClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BlockController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->info = (object)[];
        $this->info->head = 'Текста';
        $this->info->url = 'block';
        $this->info->modelName = 'Block';
        $this->middleware('role:admin');
    }

    public function index()
    {
        $items = Block::all();
        $info = $this->info;

        return view('admin.'.$this->info->url.'.index', compact('items', 'info'));
    }

    public function add()
    {
        $info = $this->info;

        return view('admin.'.$this->info->url.'.insert', compact('info'));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = Block::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.'.$this->info->url.'.insert', compact('item', 'info'));
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
            'key' => 'required',
            'desc' => 'required'
        ];

        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

//        $boolean_exceptions = ['enable'];

        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, null, null);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);
    }

    public function enable(Request $request)
    {
        $result = $this->crudClass->enable($this->info->modelName, $request);

        return response()->json($result);
    }

    public function changePosition(Request $request)
    {
        $result = $this->crudClass->changePosition($this->info->modelName, $request);

        return response()->json($result);
    }
}
