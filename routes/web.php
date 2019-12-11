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
    return view('welcome');
});

Route::get('/employees', 'EmployeeController@index');
Route::post('/employees', 'EmployeeController@store');
Route::get('/employees/{employee}/edit', 'EmployeeController@edit');
Route::put('/employees/{employee}/', 'EmployeeController@update');
Route::get('/employees/{employee}/delete', 'EmployeeController@destroy');


Route::get('/tasks', 'TaskController@index');


