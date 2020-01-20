<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $subscribes = Subscribe::all();

        return view('admin.dashboard', compact('subscribes'));
    }

    public function addParam(Request $request)
    {
        $rules = [
            'param' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return response()->json($v->errors(), 422);

        return view('admin.params.'. $request->param);
    }
    
}