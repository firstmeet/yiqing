<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/download','HomeController@download')->name('admin.download');
    $router->get('/download_template','HomeController@download_template')->name('admin.download_template');
    $router->post('/getList','HomeController@getList')->name('admin.getList');
    $router->get('/test','HomeController@test')->name('admin.test');
    $router->get('/tongji_ui','HomeController@tongji_ui')->name('admin.tongjiui');
    $router->post('/tongji','HomeController@tongji')->name('admin.tongji');

});
