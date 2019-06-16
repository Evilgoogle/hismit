<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        return view('admin.profile.index');
    }

    public function profileUpdate(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if (Auth::user()->email != $request->email) {
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
            ];
        }

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $user = User::findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect('/admin/profile')->with('message', 'Профайл обновлен');
    }

    public function changePassword()
    {
        return view('admin.profile.change_password');
    }

    public function updatePassword(Request $request)
    {
        $v = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($v->fails()) return back()->withErrors($v->errors())->withInput();

        $user = User::findOrFail(Auth::user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect('/admin/profile')->with('message', 'Пароль обновлен');
        } else {
            return back()->with('message', 'Старый пароль не совпадает');
        }
    }

}
