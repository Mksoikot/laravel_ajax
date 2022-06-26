<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/ajax',"TeacherController@Index");
Route::get('/teacher/all',"TeacherController@allData");
Route::post('/teacher/store',"TeacherController@storeData");
Route::post('/teacher/delete',"TeacherController@deleteData");
Route::get('/teacher/edit/{id}',"TeacherController@editData");
Route::post('/teacher/update/{id}',"TeacherController@updateData");
Route::post('/teacher/destroy/{id}',"TeacherController@deleteData");
