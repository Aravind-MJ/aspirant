<?php

#Redirecting all registered users so they cannot access these pages.
Route::group(['middleware' => ['redirectAdmin', 'redirectStandardUser', 'redirectSuperAdmin', 'redirectFaculty']], function () {
    Route::get('/', ['as' => 'login', 'uses' => 'SessionsController@create']);
    Route::get('/login', ['as' => 'login', 'middleware' => 'guest', 'uses' => 'SessionsController@create']);
});

Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController', ['only' => ['create', 'store', 'destroy']]);

Route::group(['middleware' => 'guest'], function () {
    # Forgotten Password
    Route::get('forgot_password', 'Auth\PasswordController@getEmail');
    Route::post('forgot_password', 'Auth\PasswordController@postEmail');
    Route::get('reset_password/{token}', 'Auth\PasswordController@getReset');
    Route::post('reset_password/{token}', 'Auth\PasswordController@postReset');
});

# Standard User Routes
Route::group(['middleware' => ['auth', 'standardUser']], function () {
    Route::get('home', 'PagesController@getHome');
    Route::get('userProtected', 'StandardUser\StandardUserController@getUserProtected');
    Route::resource('profiles', 'StandardUser\UsersController', ['only' => ['show', 'edit', 'update']]);
});

# Admin Routes
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('admin', ['as' => 'admin_dashboard', 'uses' => 'Admin\AdminController@getHome']);
    Route::resource('admin/profiles', 'Admin\AdminUsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('register', 'RegistrationController@create');
    Route::post('register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
    Route::resource('admin/faculty', 'FacultyController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('addFaculty', ['as' => 'addFaculty', 'uses' => 'FacultyController@create'], ['only' => ['index','create','store']]);
    Route::post('newFaculty', ['as' => 'newFaculty', 'uses' => 'FacultyController@store'], ['only' => ['index','create','store']]);
    Route::get('listFaculty', ['as' => 'listFaculty', 'uses' => 'FacultyController@index'], ['only' => ['index','create','store','show']]);
    Route::delete('destroy{id}', ['as' => 'destroy', 'uses' => 'FacultyController@destroy'], ['only' => ['index','create','store','show','destroy']]);
    Route::get('edit{id}', ['as' => 'edit', 'uses' => 'FacultyController@edit'], ['only' => ['index','create','store','show','destroy','edit']]);
    Route::post('update{id}', ['as' => 'update', 'uses' => 'FacultyController@update'], ['only' => ['index','create','store','show','destroy','edit','update']]);
});

# Super Admin Routes
Route::group(['middleware' => ['auth', 'superadmin']], function () {
    Route::get('sadmin', ['as' => 'admin_dashboard', 'uses' => 'SuperAdmin\SuperAdminController@getHome']);

    #Admin CRUD Routes
    Route::get('list/admins', 'SuperAdmin\RegistrationController@index');
    Route::get('create/admin', 'SuperAdmin\RegistrationController@create');
    Route::post('register', ['as' => 'registration.store', 'uses' => 'SuperAdmin\RegistrationController@store']);
    Route::get('edit/admin/{id}',['as'=>'registration.edit','uses'=>'SuperAdmin\RegistrationController@edit']);
    Route::post('edit/admin/{id}',['as'=>'registration.update','uses'=>'SuperAdmin\RegistrationController@update']);
    Route::delete('admin/{id}',['as'=>'registration.destroy','uses'=>'SuperAdmin\RegistrationController@destroy']);

    
});

# Faculty Routes
Route::group(['middleware' => ['auth', 'faculty']], function () {
    Route::get('faculty', ['as' => 'home', 'uses' => 'Faculty\FacultyController@getHome']);
});

Route::resource('attendance', 'AttendanceController');


