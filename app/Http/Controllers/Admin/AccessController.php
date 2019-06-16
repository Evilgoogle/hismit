<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use App\Role;
use App\RolePermission;
use App\RoleUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class AccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.access.index', compact('users', 'roles', 'permissions'));
    }

    /*
     * Users begin
     * */

    public function addUser()
    {
        $roles = Role::all();

        return view('admin.access.users.add', compact('roles'));
    }

    public function createUser(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users'
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $password = mt_rand();
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($password);
        $user->save();

        $user->attachRole(Role::where('name', 'login')->first());

        if (Input::has('role'))
        {
            foreach ($request->role as $key => $value)
            {
                $user->attachRole($value);
            }
        }

        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['password'] = $password;

//            Mail::send('admin.access.email_welcome', ['data' => $data], function($message) use ($data){
//                $message->from('irolik90@gmail.com', 'B1NK Administrator');
//                $message->subject('Добро пожаловать');
//                $message->to($data['email']);
//            });

        return redirect('/admin/access')->with('message', 'Пользователь добавлен');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $role_user = RoleUser::findUser($id)->pluck('role_id')->toArray();

        return view('admin.access.users.edit', compact(['user', 'roles', 'role_user']));
    }

    public function updateUser(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->save();

        RoleUser::removeUser($id);

        $user->attachRole(Role::where('name', 'login')->first());

        if (Input::has('role'))
        {
            foreach ($request->role as $key => $value)
            {
                $user->attachRole($value);
            }
        }

        return redirect('/admin/access')->with('message', 'Пользователь обновлен');
    }

    public function removeUser($id)
    {
        User::removeUser($id);
        RoleUser::removeUser($id);

        return redirect('/admin/access')->with('message', 'Пользователь удалена');
    }

    /*
     * Users end
     * */

    /*
     * Roles begin
     * */

    public function addRole()
    {
        $permissions = Permission::all();

        return view('admin.access.roles.add', compact('permissions'));
    }

    public function createRole(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $role = Role::create($request->except(['permission','_token']));

        if (Input::has('permission')){
            foreach ($request->permission as $key => $value){
                $role->attachPermission($value);
            }
        }

        return redirect('/admin/access')->with('message', 'Роль добавлена');
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $role_permission = $role->perms()->pluck('id', 'id')->toArray();

        return view('admin.access.roles.edit', compact(['role', 'permissions', 'role_permission']));
    }

    public function updateRole(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $role = Role::findOrFail($id);
        $role->name = trim($request->name);
        $role->display_name = trim($request->display_name);
        $role->description = trim($request->description);
        $role->save();

        RolePermission::removeRoles($id);

        foreach ($request->permission as $key => $value)
        {
            $role->attachPermission($value);
        }

        return redirect('/admin/access')->with('message', 'Роль обновлена');
    }

    public function removeRole($id)
    {
        Role::removeRole($id);
        RoleUser::removeRole($id);
        RolePermission::removeRoles($id);

        return redirect('/admin/access')->with('message', 'Роль удалена');
    }

    /*
     * Roles end
     * */

    /*
     * Permissions begin
     * */

    public function addPermission()
    {
        return view('admin.access.permissions.add');
    }

    public function createPermission(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        Permission::create($request->except(['_token']));

        return redirect('/admin/access')->with('message', 'Действие добавлено');
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.access.permissions.edit', compact(['permission']));
    }

    public function updatePermission(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'display_name' => 'required|max:255',
            'description' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $permission = Permission::findOrFail($id);
        $permission->name = trim($request->name);
        $permission->display_name = trim($request->display_name);
        $permission->description = trim($request->description);
        $permission->save();

        return redirect('/admin/access')->with('message', 'Действие обновлено');
    }

    public function removePermission($id)
    {
        Permission::destroy($id);

        return redirect('/admin/access')->with('message', 'Действие удалено');
    }

    /*
     * Permissions end
     * */

}
