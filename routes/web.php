<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookSalesController;
use Illuminate\Support\Facades\Route;
use Tests\Feature\BookSalesControllerTest;

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

Route::middleware('auth')->group(function(){
    Route::get('/show', [BookController::class, 'show']);
    Route::get('/books', [BookController::class, 'index']);
    Route::post('/book/{book}/sales', [BookSalesController::class, 'store']);
});

