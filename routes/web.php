<?php

Route::group(['middleware' => 'web'], function () {
    Auth::routes();

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'role:superadmin']], function () {

        Route::get('', 'AdminController@index');

        Route::group(['prefix' => 'profile'], function () {
            Route::get('', 'ProfileController@index');
            Route::post('update', 'ProfileController@profileUpdate');
            Route::get('change-password', 'ProfileController@changePassword');
            Route::post('update-password', 'ProfileController@updatePassword');
        });

        Route::group(['prefix' => 'access', 'middleware' => ['role:superadmin']], function () {
            Route::get('', 'AccessController@index');

            Route::group(['prefix' => 'users'], function () {
                Route::get('add', 'AccessController@addUser');
                Route::post('create', 'AccessController@createUser');
                Route::get('edit/{id}', 'AccessController@editUser');
                Route::post('update/{id}', 'AccessController@updateUser');
                Route::get('remove/{id}', 'AccessController@removeUser');
            });

            Route::group(['prefix' => 'roles'], function () {
                Route::get('add', 'AccessController@addRole');
                Route::post('create', 'AccessController@createRole');
                Route::get('edit/{id}', 'AccessController@editRole');
                Route::post('update/{id}', 'AccessController@updateRole');
                Route::get('remove/{id}', 'AccessController@removeRole');
            });

            Route::group(['prefix' => 'permissions'], function () {
                Route::get('add', 'AccessController@addPermission');
                Route::post('create', 'AccessController@createPermission');
                Route::get('edit/{id}', 'AccessController@editPermission');
                Route::post('update/{id}', 'AccessController@updatePermission');
                Route::get('remove/{id}', 'AccessController@removePermission');
            });
        });

        Route::group(['prefix' => 'param'], function () {
            Route::post('add-param', 'AdminController@addParam');
        });
        Route::post('removeArrJson', 'AdminController@removeArrJson');

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

        Route::group(['prefix' => 'language_interface'], function () {
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

        Route::group(['prefix' => 'block'], function () {
            Route::get('', 'BlockController@index');
            Route::get('add', 'BlockController@add');
            Route::get('edit/{id}', 'BlockController@edit');
            Route::post('insert/{id?}', 'BlockController@insert');
            Route::get('remove/{id}', 'BlockController@remove');
            Route::post('enable', 'BlockController@enable');
        });

        Route::group(['prefix' => 'news'], function () {
            Route::get('', 'NewsController@index');
            Route::get('add', 'NewsController@add');
            Route::get('edit/{id}', 'NewsController@edit');
            Route::post('insert/{id?}', 'NewsController@insert');
            Route::get('remove/{id}', 'NewsController@remove');
            Route::post('remove-image', 'NewsController@removeImage');
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
    $get_allLanguage = \App\EmotionsGroup\Language\LangDb::getInstance();
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

    Route::group(['prefix' => $routing], function () {
        Route::get('', 'IndexController@index');
        Route::get('news/{url?}', 'IndexController@news')->name('news.show');
    });
});
