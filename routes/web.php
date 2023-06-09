<?php

use App\Http\Controllers\BookController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/students', [StudentController::class, 'index']);
// Route::post('/students/store',[StudentController::class, 'store']);
Route::get('/token', [BookController::class, 'createToken']);
// Route::get('/students/{id}', [StudentController::class, 'show']);
// Route::delete('/students/delete/{id}', [StudentController::class, 'destroy']);
// Route::patch('/students/update/{id}', [StudentController::class, 'update']);