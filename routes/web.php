<?php

Route::redirect('/home', '/', 301);
Route::get('/login', [
    'as' => 'login', 'uses' => 'SessionsController@create',
]);
Route::post('/login', 'SessionsController@login');
Route::get('/logout', [
    'as' => 'logout', 'uses' => 'SessionsController@destroy',
]);
Route::get('/test', [
    'as' => 'test', 'uses' => 'TestController@index',
]);

Route::group(['middleware' => ['auth', 'timeout']], function () {
    Route::get('/', [
        'as' => 'index', 'uses' => 'DashboardController@index'
    ]);
});