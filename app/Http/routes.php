<?php

# Routes that anyone can access.
Route::get('logout', ['as' => 'logout', 'uses' => 'SessionsController@destroy']);
Route::resource('sessions', 'SessionsController', ['only' => ['create', 'store', 'destroy']]);

# Redirecting all registered users so they cannot access these pages.
Route::group(['middleware' => ['redirectAdmin', 'redirectStandardUser', 'redirectSuperAdmin', 'redirectFaculty']], function () {

    # Login page routes.
    Route::get('/', ['as' => 'login', 'uses' => 'SessionsController@create']);
    Route::get('/login', ['as' => 'login', 'middleware' => 'guest', 'uses' => 'SessionsController@create']);
});

# Routes only guests can access.
Route::group(['middleware' => 'guest'], function () {

    # Forgotten Password.
    Route::get('forgot_password', 'Auth\PasswordController@getEmail');
    Route::post('forgot_password', 'Auth\PasswordController@postEmail');
    Route::get('reset_password/{token}', 'Auth\PasswordController@getReset');
    Route::post('reset_password/{token}', 'Auth\PasswordController@postReset');
});

# Routes that Standard Users and Faculty cannot access.
Route::group(['middleware' => ['auth', 'redirectFaculty', 'redirectStandardUser']], function () {

    # Faculty crud Route.
    Route::resource('Faculty', 'FacultyController');

    # Examtype crud Routes.
    Route::resource('ExamType', 'ExamTypeController');

    # ExamDetails crud Routes.
    Route::resource('ExamDetails', 'ExamDetailsController');

    # Feetype crud Routes.
    Route::resource('FeeTypes', 'FeeTypesController');

    # Notice crud Routes.
    Route::resource('Notice', 'NoticeController');

    # Batch crud Routes.
    Route::resource('BatchDetails', 'BatchDetailsController');

    # Route to edit student profile.
    Route::post('edit/admin/student/{id}', ['as' => 'studentProfilen.update', 'uses' => 'SuperAdmin\RegistrationController@update']);

    # Route to edit faculty profile.
    Route::post('edit/admin/faculty/{id}', ['as' => 'facultyProfile.update', 'uses' => 'SuperAdmin\RegistrationController@update']);

    #Search Student Route
    Route::post('Search', ['as' => 'search.queries', 'uses' => 'StudentController@search']);

    # Sms Api Route
    Route::get('SendAnSms/students', 'SmsApiController@students');
    Route::get('SendAnSms/batches', 'SmsApiController@batches');
    Route::get('SendAnSms/faculty', 'SmsApiController@faculty');
    Route::post('SmsApi', 'SmsApiController@sms');
    Route::get('SmsHistory', 'SmsApiController@index');
});

# Routes that Standard User Cannot access.
Route::group(['middleware' => ['auth', 'redirectStandardUser']], function () {

    # Routes to Mark Section.
    Route::resource('mark', 'MarkDetailsController', ['only' => ['index', 'create', 'store', 'update', 'destroy']]);
    Route::post('fetchStudents', ['uses' => 'MarkDetailsController@fetchStudents']);
    Route::post('fetchMark', ['uses' => 'MarkDetailsController@fetchMark']);

    # Student Registration crud Route.
    Route::resource('Student', 'StudentController');

    # Search Student Route.
    Route::get('Search', ['as' => 'search.queries', 'uses' => 'StudentController@search']);
});

# Standard User Routes.
Route::group(['middleware' => ['auth', 'standardUser']], function () {

    # Home
    Route::get('home', 'PagesController@getHome');
    Route::get('notice', ['as' => 'notice.getNotice', 'uses' => 'PagesController@getNotice']);
    Route::get('userProtected', 'StandardUser\StandardUserController@getUserProtected');
    Route::resource('profiles', 'StandardUser\UsersController', ['only' => ['show', 'edit', 'update']]);

    # Mark details Route
    Route::get('Marks', ['uses' => 'MarkDetailsController@getMark']);
});

# Admin Routes.
Route::group(['middleware' => ['auth', 'admin']], function () {
    # Home
    Route::get('admin', ['as' => 'admin_dashboard', 'uses' => 'Admin\AdminController@getHome']);
});

# Super Admin Routes.
Route::group(['middleware' => ['auth', 'superadmin']], function () {

    # Home.
    Route::get('sadmin', ['as' => 'admin_dashboard', 'uses' => 'SuperAdmin\SuperAdminController@getHome']);

    # Admin CRUD Routes.
    Route::get('list/admins', 'SuperAdmin\RegistrationController@index');
    Route::get('create/admin', 'SuperAdmin\RegistrationController@create');
    Route::post('register', ['as' => 'registration.store', 'uses' => 'SuperAdmin\RegistrationController@store']);
    Route::get('edit/admin/{id}', ['as' => 'registration.edit', 'uses' => 'SuperAdmin\RegistrationController@edit']);
    Route::post('edit/admin/{id}', ['as' => 'registration.update', 'uses' => 'SuperAdmin\RegistrationController@update']);
    Route::delete('admin/{id}', ['as' => 'registration.destroy', 'uses' => 'SuperAdmin\RegistrationController@destroy']);
});

# Routes that any Authorized user can use
Route::group(['middleware' => ['auth']], function () {

    # Routes to Attendance Section
    Route::get('attendance/mark', ['uses' => 'AttendanceController@index']);
    Route::get('attendance/mark/{id}', ['uses' => 'AttendanceController@mark']);
    Route::post('attendance/mark', ['uses' => 'AttendanceController@store']);
    Route::get('attendance/batch', ['uses' => 'AttendanceController@selectBatch']);
    Route::get('attendance/batch/{id}', ['uses' => 'AttendanceController@ofBatch']);
    Route::get('attendance/batch/{id}/{date}', ['uses' => 'AttendanceController@ofBatchDate']);
    Route::get('attendance/student', ['uses' => 'AttendanceController@selectStudentGet']);
    Route::post('attendance/student', ['as' => 'attendance.student', 'uses' => 'AttendanceController@selectStudentPost']);
    Route::get('attendance/student/{id}', ['uses' => 'AttendanceController@ofStudent']);
    Route::get('edit/attendance', ['uses' => 'AttendanceController@edit']);
    Route::get('edit/attendance/{id}', ['uses' => 'AttendanceController@selectDate']);
    Route::get('edit/attendance/{id}/{date}', ['uses' => 'AttendanceController@editBatch']);
    Route::post('edit/attendance', ['uses' => 'AttendanceController@update']);
    Route::delete('attendance', ['as' => 'attendance.destroy', 'uses' => 'AttendanceController@destroy']);
    Route::post('rangeAttendance', ['uses' => 'AttendanceController@rangeAttendance']);

});

# Faculty Routes
Route::group(['middleware' => ['auth', 'faculty']], function () {

    # Home
    Route::get('faculty', ['as' => 'home', 'uses' => 'Faculty\FacultyController@getHome']);
});

# Routes that only current user can access
Route::group(['middleware' => ['auth', 'notCurrentUser']], function () {

    # Routes to Change Password
    Route::get('changePassword/{id}', ['uses' => 'ChangePasswordController@edit']);
    Route::post('changePassword/{id}', ['as' => 'password.change', 'uses' => 'ChangePasswordController@update']);
});

