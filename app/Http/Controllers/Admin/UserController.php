<?php

namespace App\Http\Controllers\Admin;

use App\Http\CrudClass;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->info = (object)[];
        $this->info->head = 'Пользователи';
        $this->info->url = 'users';
        $this->info->modelName = 'User';
        $this->middleware('role:admin');
    }

    public function index()
    {
        $info = $this->info;
        $items = User::getAllUsersNotAdmin();

        return view('admin.users.index', compact('items', 'info'));
    }

    public function add()
    {
        $info = $this->info;
        $roles = Role::all();
        $role_user = [];

        return view('admin.users.insert', compact('info', 'roles', 'role_user'));
    }

    public function edit($id)
    {
        $info = $this->info;

        try {
            $item = User::findOrFail($id);
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }

        $roles = Role::all();
        $role_user = DB::table(config('roles.roleUserTable'))->where('user_id', $id)->pluck('role_id')->toArray();

        return view('admin.users.insert', compact('item', 'info', 'roles', 'role_user'));
    }

    public function remove($id)
    {
        $user = User::find($id);

        $user->detachAllRoles();
        $user->delete();

        return redirect('/admin/users')->with('message', 'Пользователь удален');
    }

    public function insert(Request $request, $id = null)
    {
        $arr = [];
        if (empty($id)) {
            $arr = [
                'password' => 'required|min:8|confirmed',
            ];
        }
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:190|unique:users',
            'role' => 'required'
        ];
        $rules = array_merge($rules, $arr);

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $user = new User();
        if ($request->has('name'))
            $user->name = $request->name;

        if ($request->has('email'))
            $user->email = $request->email;

        if ($request->has('password'))
            $user->password = bcrypt($request->password);

        $user->save();

        //$role = Role::where('slug', '=', 'user')->first();
        //$user->attachRole($role);

        if ($request->has('role')) {
            $user->detachAllRoles();

            $role = $request->role;

            foreach ($role as $key => $value) {
                $user->attachRole($value);
            }
        }

        return redirect('/admin/users')->with('message', 'Пользователь добавлен');
    }
}
