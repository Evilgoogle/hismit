<?php

namespace App\Http\Controllers\Admin;

use App\Http\CrudClass;
use App\NewsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogsController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->info = (object)[];
        $this->info->head = 'Логи';
        $this->info->url = 'logs';
        $this->info->modelName = 'NewsLog';
        $this->middleware('role:admin');
    }

    public function index()
    {
        $items = NewsLog::orderBy('pubDate', 'desc')->get();
        $info = $this->info;

        return view('admin.logs.index', compact('items', 'info'));
    }

    public function add()
    {
        $info = $this->info;

        return view('admin.logs.insert', compact('info'));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = NewsLog::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.logs.insert', compact('item', 'info'));
    }

    public function remove($id)
    {
        $result = $this->crudClass->remove($this->info->modelName, $id);

        return back()->with($result);
    }

    public function insert(Request $request, $id = null)
    {
        $result = $this->crudClass->insert($this->info->modelName, $id ,$request, null, null, null, null, false);

        if ($result['status'] == 'ok')
            return redirect('/admin/'.$this->info->url)->with('message', 'Запись обновлена');
        else
            return back()->withErrors($result['message']);
    }

}
