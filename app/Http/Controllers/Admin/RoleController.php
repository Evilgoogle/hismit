<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\CrudClass;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->info = (object)[];
        $this->info->head = 'Роли';
        $this->info->url = 'roles';
        $this->info->modelName = 'Role';
        $this->middleware('role:admin');
    }

    public function index()
    {
        $items = Role::all();
        $info = $this->info;

        return view('admin.role.index', compact('items', 'info'));
    }

    public function add()
    {
        $info = $this->info;

        return view('admin.role.insert', compact('info'));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = Role::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        return view('admin.role.insert', compact('item', 'info'));
    }

    public function remove($id)
    {
        $result = $this->crudClass->remove($this->info->modelName, $id);

        return back()->with($result);
    }

    public function insert(Request $request, $id = null)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'slug' => 'required'
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
