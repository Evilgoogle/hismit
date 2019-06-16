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

        return view('admin.dashboard', compact(['subscribes']));
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

    public function removeArrJson(Request $request)
    {
        $rules = [
            'id' => 'required',
            'column' => 'required',
            'model' => 'required',
            'arr' => 'required'
        ];

        $model = $request->model;
        $column = $request->column;
        $id = $request->id;
        $arr = $request->arr;
        $index = $request->index;

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return response()->json($v->errors(), 422);

        try {
            try {
                $item = eval('return \\App\\'. $model .'::findOrFail($id);');
            } catch (\Exception $e) {
                return $result = [
                    'status' => 'errors',
                    'message' => $e->getMessage()
                ];
            }

            $itemNew = json_decode($item->$column);
            if (empty($index))
                eval('return $itemNew->$arr = null;');
            else
                eval('return $itemNew[$index]->$arr = null;');
            $item->$column = json_encode($itemNew, JSON_UNESCAPED_UNICODE);
            $item->save();

            $result = [
                'status' => 'ok',
                'message' => 'Аргумент удален',
            ];
        } catch (\Exception $e) {
            return $result = [
                'status' => 'errors',
                'message' => $e->getMessage()
            ];
        }

        return response()->json($result);
    }
    
}