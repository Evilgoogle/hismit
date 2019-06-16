<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\CrudClass;
use App\Http\FileClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    protected $crudClass;
    protected $info;

    public function __construct()
    {
        $this->crudClass = new CrudClass();
        $this->fileClass = new FileClass();
        $this->info = (object)[];
        $this->info->head = 'Конфиг';
        $this->info->url = 'config';
        $this->info->modelName = 'Config';
        $this->middleware('role:superadmin');
    }

    public function edit()
    {
        $info = $this->info;

        $items = Config::all();

        return view('admin.config', compact(['items', 'info']));
    }

    public function update(Request $request)
    {
        if ($request->has('emails')) {
            Config::updateOrCreate(['key' => 'emails'], ['value' => $request->emails]);
        }
        if ($request->has('whatsapp')) {
            Config::updateOrCreate(['key' => 'whatsapp'], ['value' => $request->whatsapp]);
        }
        if ($request->has('map_latitude')) {
            Config::updateOrCreate(['key' => 'map_latitude'], ['value' => $request->map_latitude]);
        }
        if ($request->has('map_longitude')) {
            Config::updateOrCreate(['key' => 'map_longitude'], ['value' => $request->map_longitude]);
        }

        return redirect('/admin/config')->with('message', 'Информация обновлена');
    }
}
