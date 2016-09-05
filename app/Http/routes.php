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
    #Faculty crud Route
    Route::resource('Faculty', 'FacultyController', ['only' => ['index', 'show', 'edit', 'update', 'destroy', 'store', 'create']]);
    #Student Reristration crud Route
    Route::resource('Student', 'StudentController', ['only' => ['index', 'show', 'edit', 'update', 'destroy', 'store', 'create']]);
    #Examtype crud Routes
    Route::resource('ExamType', 'ExamTypeController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    #ExamDetails crud Routes
    Route::resource('ExamDetails', 'ExamDetailsController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    #Feetype crud Routes
    Route::resource('FeeTypes', 'FeeTypesController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    Route::resource('Notice', 'NoticeController', ['only' => ['index', 'show', 'edit', 'update', 'destroy','store','create']]);

     #Batch crud Routes
    Route::resource('BatchDetails', 'BatchDetailsController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);

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

