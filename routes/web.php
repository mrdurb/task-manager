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

Route::get('/', function () {
    return view('employee');
});

Route::resource('employee', 'EmployeeController');

Route::post('employee/update', 'EmployeeController@update')->name('employee.update');

Route::get('employee/destroy/{id}', 'EmployeeController@destroy');
