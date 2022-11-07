<?php

use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\HomeController;
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

Route::resource('dropzone', DropzoneController::class);
Route::post('dropzone/saveFile', [DropzoneController::class,'saveFile'])->name('dropzone.savefile');
//Route form displaying our form
Route::get('/dropzoneform', [HomeController::class, 'dropzoneform']);

//Rout for submitting the form datat
Route::post('/storedata', [HomeController::class, 'storeData'])->name('form.data');

//Route for submitting dropzone data
Route::post('/storeimgae', [HomeController::class,'storeImage']);
Route::post('/storeMultipleImage', [HomeController::class,'storeMultipleImage']);
?>