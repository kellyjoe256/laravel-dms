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

    // Documents
    Route::get('/documents', [
        'as' => 'documents', 'uses' => 'DocumentsController@index',
    ]);
    Route::get('/documents/add', [
        'as' => 'documents.add', 'uses' => 'DocumentsController@create',
    ]);
    Route::post('/documents/add', 'DocumentsController@store');
    Route::get('/documents/{id}/edit', [
        'as' => 'documents.edit', 'uses' => 'DocumentsController@edit',
    ]);
    Route::post('/documents/{id}/edit', 'DocumentsController@update');
    Route::get('/documents/{id}/delete', [
        'as' => 'documents.delete', 'uses' => 'DocumentsController@delete',
    ]);
    Route::post('/documents/{id}/delete', 'DocumentsController@destroy');
    Route::get('/documents/{id}/view_files', [
        'as' => 'documents.view_files', 'uses' => 'DocumentsController@viewFiles',
    ]);
    Route::get('/documents/{id}/upload_files', [
        'as' => 'documents.upload_files', 'uses' => 'DocumentsController@uploadFiles',
    ]);
    Route::post('/documents/{id}/upload_files', 'DocumentsController@storeFiles');

    // Document Files
    Route::get('/document_files/{id}/preview', [
        'as' => 'document_files.preview', 'uses' => 'DocumentFilesController@preview',
    ]);
    Route::get('/document_files/{id}/delete', [
        'as' => 'document_files.delete_file', 'uses' => 'DocumentFilesController@deleteFile',
    ]);

    // Document Categories
    Route::get('/document_categories', [
        'as' => 'doc_categories', 'uses' => 'DocumentCategoriesController@index',
    ])->middleware('admin');
    Route::get('/document_categories/add', [
        'as' => 'doc_categories.add', 'uses' => 'DocumentCategoriesController@create',
    ])->middleware('admin');
    Route::post('/document_categories/add', 'DocumentCategoriesController@store')
        ->middleware('admin');
    Route::get('/document_categories/{id}/edit', [
        'as' => 'doc_categories.edit', 'uses' => 'DocumentCategoriesController@edit',
    ])->middleware('admin');
    Route::post('/document_categories/{id}/edit', 'DocumentCategoriesController@update')
        ->middleware('admin');
    Route::get('/document_categories/{id}/delete', [
        'as' => 'doc_categories.delete', 'uses' => 'DocumentCategoriesController@delete',
    ])->middleware('admin');
    Route::post('/document_categories/{id}/delete', 'DocumentCategoriesController@destroy')
        ->middleware('admin');

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
    Route::get('/branches/{id}/get_departments', [
        'as' => 'branches.get_departments', 'uses' => 'BranchesController@getDepartments',
    ])->middleware('admin');
    
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
    
    // Users
    Route::get('/users', [
        'as' => 'users', 'uses' => 'UsersController@index',
    ])->middleware('admin');
    Route::get('/users/add', [
        'as' => 'users.add', 'uses' => 'UsersController@create',
    ])->middleware('admin');
    Route::post('/users/add', 'UsersController@store')
        ->middleware('admin');
    Route::get('/users/{id}/edit', [
        'as' => 'users.edit', 'uses' => 'UsersController@edit',
    ])->middleware('admin');
    Route::post('/users/{id}/edit', 'UsersController@update')
        ->middleware('admin');
    Route::get('/users/{id}/delete', [
        'as' => 'users.delete', 'uses' => 'UsersController@delete',
    ])->middleware('admin');
    Route::post('/users/{id}/delete', 'UsersController@destroy')
        ->middleware('admin');
    Route::get('/users/{id}/change_password', [
        'as' => 'users.change_password', 'uses' => 'UsersController@changePassword',
    ])->middleware('admin');
    Route::post('/users/{id}/change_password', 'UsersController@storePassword')
        ->middleware('admin');
    Route::get('/users/{id}/activate', [
        'as' => 'users.activate', 'uses' => 'UsersController@activate',
    ])->middleware('admin');
    Route::get('/users/{id}/deactivate', [
        'as' => 'users.deactivate', 'uses' => 'UsersController@deactivate',
    ])->middleware('admin');
});