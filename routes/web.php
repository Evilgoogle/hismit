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
