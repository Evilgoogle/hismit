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
            if(config('myconfig.language_developer')) {
                Route::get('add', 'LangInterfaceController@add');
            }
            Route::get('edit/{id}', 'LangInterfaceController@edit');
            Route::post('insert/{id?}', 'LangInterfaceController@insert');
            if(config('myconfig.language_developer')) {
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

    Route::group(['prefix' => ''], function () {
        Route::get('', 'IndexController@index');
        Route::get('news/{url?}', 'IndexController@news')->name('news.show');
    });
});
