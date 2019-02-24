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
        'as' => 'index', 'uses' => 'DashboardController@index',
    ]);

    // Branches
    Route::get('/branches', [
        'as' => 'branches', 'uses' => 'BranchesController@index',
    ])->middleware('admin');
    Route::get('/branches/add', [
        'as' => 'branches.add', 'uses' => 'BranchesController@create',
    ])->middleware('admin');
    Route::post('/branches/add', 'BranchesController@store')
        ->middleware('admin');
    Route::get('/branches/{id}/edit', [
        'as' => 'branches.edit', 'uses' => 'BranchesController@edit',
    ])->middleware('admin');
    Route::post('/branches/{id}/edit', 'BranchesController@update')
        ->middleware('admin');
    Route::get('/branches/{id}/delete', [
        'as' => 'branches.delete', 'uses' => 'BranchesController@delete',
    ])->middleware('admin');
    Route::post('/branches/{id}/delete', 'BranchesController@destroy')
        ->middleware('admin');
    Route::get('/branches/{id}/view_departments', [
        'as' => 'branches.departments', 'uses' => 'BranchesController@departments',
    ])->middleware('admin');
    Route::get('/branches/{id}/add_departments', [
        'as' => 'branches.add_departments', 'uses' => 'BranchesController@addDepartments',
    ])->middleware('admin');
    Route::post('/branches/{id}/add_departments', 'BranchesController@storeDepartments')
        ->middleware('admin');
    
    // Departments
    Route::get('/departments', [
        'as' => 'departments', 'uses' => 'DepartmentsController@index',
    ])->middleware('admin');
    Route::get('/departments/add', [
        'as' => 'departments.add', 'uses' => 'DepartmentsController@create',
    ])->middleware('admin');
    Route::post('/departments/add', 'DepartmentsController@store')
        ->middleware('admin');
    Route::get('/departments/{id}/edit', [
        'as' => 'departments.edit', 'uses' => 'DepartmentsController@edit',
    ])->middleware('admin');
    Route::post('/departments/{id}/edit', 'DepartmentsController@update')
        ->middleware('admin');
    Route::get('/departments/{id}/delete', [
        'as' => 'departments.delete', 'uses' => 'DepartmentsController@delete',
    ])->middleware('admin');
    Route::post('/departments/{id}/delete', 'DepartmentsController@destroy')
        ->middleware('admin');
    Route::get('/departments/{id}/view_branches', [
        'as' => 'departments.branches', 'uses' => 'DepartmentsController@branches',
    ])->middleware('admin');
    Route::get('/departments/{id}/add_branches', [
        'as' => 'departments.add_branches', 'uses' => 'DepartmentsController@addBranches',
    ])->middleware('admin');
    Route::post('/branches/{id}/add_branches', 'DepartmentsController@storeBranches')
        ->middleware('admin');
});