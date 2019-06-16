<?php

namespace App\Http\Controllers\Admin;

use App\RequestCall;
use App\Http\Controllers\Controller;

class RequestCallController extends Controller
{
    public function __construct()
    {
        $this->info = (object)[];
        $this->info->head = 'Заявки';
        $this->info->url = 'request-call';
        $this->info->modelName = 'RequestCall';
        $this->middleware('role:superadmin');
    }

    public function index()
    {
        $items = RequestCall::orderBy('id', 'desc')->get();
        $info = $this->info;

        return view('admin.request-call.index', compact(['items', 'info']));
    }
}
