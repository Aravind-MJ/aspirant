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
    #Home
    Route::get('home', 'PagesController@getHome');
    Route::get('userProtected', 'StandardUser\StandardUserController@getUserProtected');
    Route::resource('profiles', 'StandardUser\UsersController', ['only' => ['show', 'edit', 'update']]);
});

# Admin Routes
Route::group(['middleware' => ['auth', 'admin']], function () {
    #Home
    Route::get('admin', ['as' => 'admin_dashboard', 'uses' => 'Admin\AdminController@getHome']);

    Route::resource('admin/profiles', 'Admin\AdminUsersController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('register', 'RegistrationController@create');
    Route::post('register', ['as' => 'registration.store', 'uses' => 'RegistrationController@store']);
    Route::resource('admin/faculty', 'FacultyController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('addFaculty', ['as' => 'addFaculty', 'uses' => 'FacultyController@create']);
    Route::post('newFaculty', ['as' => 'newFaculty', 'uses' => 'FacultyController@store']);
    Route::get('listFaculty', ['as' => 'listFaculty', 'uses' => 'FacultyController@index']);
    Route::delete('destroy/{id}', ['as' => 'destroy', 'uses' => 'FacultyController@destroy']);
    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'FacultyController@edit']);
    Route::patch('update{id}', ['as' => 'update', 'uses' => 'FacultyController@update']);
    Route::resource('admin/Examtype', 'Admin\ExamtypeController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);
    Route::get('addExamtype', ['as' => 'addExamtype', 'uses' => 'ExamtypeController@create']);
    Route::post('newExamtype', ['as' => 'newExamtype', 'uses' => 'ExamtypeController@store']);
    Route::get('listExamtype', ['as' => 'listExamtype', 'uses' => 'ExamtypeController@index']);
    Route::delete('destroy{id}', ['as' => 'destroy', 'uses' => 'ExamtypeController@destroy']);
    Route::get('edit{id}', ['as' => 'edit', 'uses' => 'ExamtypeController@edit']);
    Route::post('update{id}', ['as' => 'update', 'uses' => 'ExamtypeController@update']);
});

# Super Admin Routes
Route::group(['middleware' => ['auth', 'superadmin']], function () {
    #Home
    Route::get('sadmin', ['as' => 'admin_dashboard', 'uses' => 'SuperAdmin\SuperAdminController@getHome']);

    #Admin CRUD Routes
    Route::get('list/admins', 'SuperAdmin\RegistrationController@index');
    Route::get('create/admin', 'SuperAdmin\RegistrationController@create');
    Route::post('register', ['as' => 'registration.store', 'uses' => 'SuperAdmin\RegistrationController@store']);
    Route::get('edit/admin/{id}', ['as' => 'registration.edit', 'uses' => 'SuperAdmin\RegistrationController@edit']);
    Route::post('edit/admin/{id}', ['as' => 'registration.update', 'uses' => 'SuperAdmin\RegistrationController@update']);
    Route::delete('admin/{id}', ['as' => 'registration.destroy', 'uses' => 'SuperAdmin\RegistrationController@destroy']);


});

Route::group(['middleware' => ['auth']], function () {
    #Routes to Attendance Section
    Route::get('mark/attendance', ['uses' => 'AttendanceController@index']);
    Route::get('mark/attendance/{id}', ['uses' => 'AttendanceController@mark']);
    Route::post('mark/attendance', ['uses' => 'AttendanceController@store']);
    Route::get('attendance/batch', ['uses' => 'AttendanceController@selectBatch']);
    Route::get('attendance/batch/{id}', ['uses' => 'AttendanceController@ofBatch']);
    Route::get('attendance/student', ['uses' => 'AttendanceController@selectStudentGet']);
    Route::post('attendance/student', ['as' => 'attendance.student', 'uses' => 'AttendanceController@selectStudentPost']);
    Route::get('attendance/student/{id}', ['uses' => 'AttendanceController@ofStudent']);
});

# Faculty Routes
Route::group(['middleware' => ['auth', 'faculty']], function () {
    #Home
    Route::get('faculty', ['as' => 'home', 'uses' => 'Faculty\FacultyController@getHome']);
});

Route::group(['middleware' => ['auth', 'notCurrentUser']], function () {
    #Routes to Change Password
    Route::get('changePassword/{id}', ['uses' => 'ChangePasswordController@edit']);
    Route::post('changePassword/{id}', ['as' => 'password.change', 'uses' => 'ChangePasswordController@update']);
});

