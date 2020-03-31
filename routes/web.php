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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/data', function () {
//     return view('data.index');
// });

// Route::prefix('/modelName')->middleware(['auth',])->group(function(){
        // ALLRoutesForThisModel
// });

Auth::routes();
Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/home', 'HomeController@index')->name('home');
