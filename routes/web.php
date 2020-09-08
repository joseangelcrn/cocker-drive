<?php

use App\Fichero;
use App\Log;
use App\LogType;
use App\User;
use App\Utils\File\Handler\FileHandler;
use App\Utils\File\Types\ImageFile;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\FileFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
});

Auth::routes();


//Protected routes.
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/mis-ficheros', 'FicheroController@misFicheros')->name('fichero.mis-ficheros');
    Route::post('file/advanced_searching', 'FicheroController@advancedSearching')->name('fichero.advanced-searching');
    Route::get('file/download-all-compressed-files', 'FicheroController@downloadCompressedFiles')->name('fichero.download-all-files');
    Route::get('file/download-single-file', 'FicheroController@downloadSingleFile')->name('fichero.download-single-file');
    Route::delete('file/delete-all-files-current-user', 'FicheroController@fullDelete')->name('fichero.delete-all-files-current-user');
    Route::resource('/fichero', 'FicheroController')->name('fichero','*');


    Route::get('/log', 'LogController@index')->name('log.index');
    Route::get('/log/searching', 'LogController@searching')->name('log.searching');

});

Route::get('/test',  function (Request $request)
{

    $user = User::first();
    Auth::login($user);
    
    $fakeFile = new FileFactory();
    $file = $fakeFile->create('test.mp3',3);
// dd($file);

    $image = new ImageFile();

    $fichero = Fichero::first();
    dd(
        FileHandler::compressAndDownloadAllFilesByUser($user)
    );
//     //---------------------------------------------------

// $nameSpaceOrigin = [];
// for ($i=0; $i < 2; $i++) {
//     foreach (FileHandler::getFileTypesList() as $file) {
//         array_push($nameSpaceOrigin,$file);
//     }
// }
// $nameSpaceResult = [];

// foreach ($nameSpaceOrigin as $ns) {
//    $nsFixed = FileHandler::fixPath($ns,$nameSpaceResult);
//    array_push($nameSpaceResult,$nsFixed);
// }

// dd($nameSpaceOrigin,$nameSpaceResult);
});

