<?php

use Illuminate\Support\Facades\Request;
use App\EmotionsGroup\Language\LangDb;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'web'], function () {
    Auth::routes();

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'role:admin']], function () {

        Route::get('', 'AdminController@index');

        Route::group(['prefix' => 'profile'], function () {
            Route::get('', 'ProfileController@index');
            Route::post('update', 'ProfileController@profileUpdate');
            Route::get('change-password', 'ProfileController@changePassword');
            Route::post('update-password', 'ProfileController@updatePassword');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('', 'UserController@index');
            Route::get('add', 'UserController@add');
            Route::get('edit/{id}', 'UserController@edit');
            Route::post('insert/{id?}', 'UserController@insert');
            Route::get('remove/{id}', 'UserController@remove');
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('', 'RoleController@index');
            Route::get('add', 'RoleController@add');
            Route::get('edit/{id}', 'RoleController@edit');
            Route::post('insert/{id?}', 'RoleController@insert');
            Route::get('remove/{id}', 'RoleController@remove');
        });

        Route::group(['prefix' => 'param'], function () {
            Route::post('add-param', 'AdminController@addParam');
        });

        Route::group(['prefix' => 'config'], function () {
            Route::get('', 'ConfigController@edit');
            Route::post('update', 'ConfigController@update');
        });

        Route::group(['prefix' => 'seo'], function () {
            Route::get('', 'SeoController@index');
            Route::get('add', 'SeoController@add');
            Route::get('edit/{id}', 'SeoController@edit');
            Route::post('insert/{id?}', 'SeoController@insert');
            Route::get('remove/{id}', 'SeoController@remove');
        });

        Route::group(['prefix' => 'language'], function () {
            Route::get('', 'LangController@index');
            Route::get('add', 'LangController@add');
            Route::get('edit/{id}', 'LangController@edit');
            Route::post('insert/{id?}', 'LangController@insert');
            Route::get('remove/{id}', 'LangController@remove');
            Route::post('change-position', 'LangController@changePosition');
            Route::post('remove-image', 'LangController@removeImage');
            Route::post('enable', 'LangController@enable');
            Route::post('default_lang', 'LangController@default_lang');
        });

        Route::group(['prefix' => 'language-interface'], function () {
            Route::get('', 'LangInterfaceController@index');
            if(config('emotions.language_developer')) {
                Route::get('add', 'LangInterfaceController@add');
            }
            Route::get('edit/{id}', 'LangInterfaceController@edit');
            Route::post('insert/{id?}', 'LangInterfaceController@insert');
            if(config('emotions.language_developer')) {
                Route::get('remove/{id}', 'LangInterfaceController@remove');
            }
            Route::post('change-position', 'LangInterfaceController@changePosition');
        });

        Route::group(['prefix' => 'news'], function () {
            Route::get('', 'NewsController@index');
            Route::get('add', 'NewsController@add');
            Route::get('edit/{id}', 'NewsController@edit');
            Route::post('insert/{id?}', 'NewsController@insert');
            Route::get('remove/{id}', 'NewsController@remove');
        });

        Route::group(['prefix' => 'logs'], function () {
            Route::get('', 'LogsController@index');
            Route::get('add', 'LogsController@add');
            Route::get('edit/{id}', 'LogsController@edit');
            Route::post('insert/{id?}', 'LogsController@insert');
            Route::get('remove/{id}', 'LogsController@remove');
        });

        Route::group(['prefix' => 'request-call'], function () {
            Route::get('', 'RequestCallController@index');
        });
    });

    Route::post('subscribers', 'ServiceController@subscribers');
    Route::post('file-uploads', 'ServiceController@fileUploads');
    Route::post('request', 'ServiceController@request');
    Route::get('sitemap.xml', 'ServiceController@sitemap');

    /**
     * Этот код занимается установкой языка в свойства switch_lang класса LangDb
     * А также затрагивает роутинг с учетом языков
     */
    $get_allLanguage = LangDb::getInstance();
    $language = $get_allLanguage->get();
    // Устанавливаю в переключатель язык по умолчанию. Эта переменная пойдет в роутинг, если чел не переключил язык в ручную.
    // А если переключил, то она переопределяется на переключенный язык в коде ниже
    $get_allLanguage->switch_lang = $get_allLanguage->default_lang;
    $urls = [];
    foreach ($language as $lang) {
        $urls[] = $lang->url;
    }

    //Установка языка на переключатель
    $patch = Request::segment(1);
    if(in_array($patch, $urls)) {
        $get_allLanguage->switch_lang = $patch;
    }

    //Настроика для роутинга
    if($get_allLanguage->switch_lang == $get_allLanguage->default_lang) {
        //Проверка не был ли этот язык выбран в ручную
        if($get_allLanguage->switch_lang == $patch) {
            $routing = $get_allLanguage->switch_lang;
        } else {
            $routing = '';
        }
    } else {
        $routing = $get_allLanguage->switch_lang;
    }
    $_ENV['default_lang'] = $get_allLanguage->default_lang;
    $_ENV['routing'] = $routing;

    Route::post('check-username', 'ServiceController@checkUsername');
    Route::post('check-email', 'ServiceController@checkEmail');

    Route::group(['prefix' => $routing], function () {
        Route::get('', 'IndexController@index');
    });
});
