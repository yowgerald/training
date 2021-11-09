<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@authenticate')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

Route::prefix('error')->group(function () {
    Route::get('/not_allowed', 'PageErrorController@showNotAllowedForm')->name('not_allowed');
});

Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::resource('student', StudentController::class);
        Route::post('student/import', 'StudentController@import')->name('import');

        Route::resource('teacher', TeacherController::class);
        Route::post('teacher/import', 'TeacherController@import')->name('import');

        Route::resource('class', ClassController::class);

        Route::resource('plot_class', PlotClassController::class);

        Route::resource('plot_teacher', PlotTeacherController::class);

        Route::resource('account', AccountController::class);
    });
});

Route::prefix('teacher')->namespace('Teacher')->group(function () {
    Route::middleware('teacher')->group(function () {
        Route::resource('attendance', AttendanceController::class);
        Route::get('attendance/take/{attendance}', 'AttendanceController@showStudents')->name('take');
        Route::post('attendance/take/{attendance}', 'AttendanceController@take')->name('take');

        Route::get('attendance_report', 'AttendanceReportController@index')->name('attendance_report.index');
        Route::get('attendance_report/download', 'AttendanceReportController@downloadCSV')->name('attendance_report.download');
    });
});

Route::prefix('student')->namespace('Student')->group(function () {
    Route::middleware('student')->group(function () {
        Route::get('class', 'ClassController@index')->name('index');
    });
});
