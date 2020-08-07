<?php

use Illuminate\Support\Facades\Auth;
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

    if (Auth::user() === null) {
        return view('welcome');
    } else {
        return redirect()->route('home');
    }

    return view('welcome');
});

Auth::routes();


//Rutas protegidas
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/mis-ficheros', 'FicheroController@misFicheros')->name('fichero.mis-ficheros');
    Route::resource('/fichero', 'FicheroController')->name('fichero','*');

});
