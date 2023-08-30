<?php

use App\Http\Controllers\News\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
   return view('home');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/news', function () {
        return view('news.news-index');
    })->name('news.index');

    Route::get('/news/delete/{id}', [NewsController::class, 'delete']);
});

