<?php

namespace App\Http\Controllers;

use App\Http\FileClass;
use App\News;
use App\RequestCall;
use App\Subscribe;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function fileUploads(Request $request)
    {
        $rules = [
            'upload' => 'required',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return response()->json($v->errors(), 422);

        $file = new FileClass();
        $file_name = $file->uploadFile($request->upload);

        $message = 'Файл загружен';

        $callback = $_REQUEST['CKEditorFuncNum'];

        return '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '", "/uploads/'.$file_name.'", "' . $message . '" );</script>';
    }

    public function subscribers(Request $request)
    {
        $rules = [
            'email' => 'required|unique:subscribers,email',
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) return response()->json($v->errors(), 422);

        if  ($request->has('email')) {
            Subscribe::firstOrCreate(['email' => $request->email]);
        }

        return response()->json(['status' => 'ok', 'message' => 'Подписка оформлена']);
    }

    public function request(Request $request)
    {
        $data = $request->all();

        $emails = explode(",", configKey('emails'));

        Mail::send('email.request', ['data' => $data], function($message) use ($emails) {
            $message->from(env('MAIL_USERNAME'), url('/'));
            $message->subject(env('APP_NAME').' Info | Новая заявка');
            $message->to($emails);
        });

        $item = new RequestCall();
        if ($request->has('name'))
            $item->name = $request->name;
        if ($request->has('phone'))
            $item->phone = $request->phone;
        if ($request->has('email'))
            $item->email = $request->email;
        if ($request->has('message'))
            $item->message = $request->message;
        $item->save();

        return response()->json(['status' => 'ok', 'message' => 'Спасибо за заявку! В ближайшее время мы с Вами свяжемся.']);
    }

    public function sitemap()
    {
        $news = News::orderBy('publish', 'desc')->get();

        return response()->view('sitemap', compact('news'))->header('Content-Type', 'application/xml');
    }

    public function checkUsername(Request $request)
    {
        $username = $request->string;
        $isExists = User::checkUsername($username);

        if($isExists > 0){
            return response()->json(["status" => false, "message" => "Это имя пользователя уже занято"]);
        }else{
            return response()->json(["status" => true]);
        }
    }

    public function checkEmail(Request $request)
    {
        $email = $request->string;
        $isExists = User::checkEmail($email);

        if($isExists > 0){
            return response()->json(["status" => false, "message" => "Этот e-mail уже занят"]);
        }else{
            return response()->json(["status" => true]);
        }
    }
}
