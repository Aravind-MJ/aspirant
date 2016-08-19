<?php

#Redirecting all registered users so they cannot access these pages.
Route::group(['middleware' => ['redirectAdmin', 'redirectStandardUser','redirectSuperAdmin','redirectFaculty']], function() {
    Route::get('/', ['as' => 'login', 'uses' => 'SessionsController@create']);
    Route::get('/login', ['as' => 'login', 'middleware' => 'guest', 'uses' => 'SessionsController@create']);
});

Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController', ['only' => ['create', 'store', 'destroy']]);

Route::group(['middleware' => 'guest'], function() {
    # Forgotten Password
    Route::get('forgot_password', 'Auth\PasswordController@getEmail');
    Route::post('forgot_password', 'Auth\PasswordController@postEmail');
    Route::get('reset_password/{token}', 'Auth\PasswordController@getReset');
    Route::post('reset_password/{token}', 'Auth\PasswordController@postReset');
});

# Standard User Routes
Route::group(['middleware' => ['auth', 'standardUser']], function() {
    Route::get('home', 'PagesController@getHome');
    Route::get('userProtected', 'StandardUser\StandardUserController@getUserProtected');
    Route::resource('profiles', 'StandardUser\UsersController', ['only' => ['show', 'edit', 'update']]);
});

# Admin Routes
Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('admin', ['as' => 'admin_dashboard', 'uses' => 'Admin\AdminController@getHome']);
    Route::resource('admin/profiles', 'Admin\AdminUsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('register', 'RegistrationController@create');
    Route::post('register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
});

# Super Admin Routes
Route::group(['middleware' => ['auth', 'superadmin']], function() {
    Route::get('sadmin', ['as' => 'admin_dashboard', 'uses' => 'SuperAdmin\SuperAdminController@getHome']);
});

# Faculty Routes
Route::group(['middleware' => ['auth', 'faculty']], function() {
    Route::get('faculty', ['as' => 'home', 'uses' => 'Faculty\FacultyController@getHome']);
});

