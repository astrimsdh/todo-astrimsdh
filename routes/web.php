<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
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

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::get('/register', function () {
    return view('register');
});
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [TodoController::class, 'index'])->middleware('auth');
Route::post('/', [TodoController::class, 'store'])->middleware('auth');;
Route::get('/todos', [TodoController::class, 'fetchTodos'])->name('todos.fetch')->middleware('auth');;
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy')->middleware('auth');;
Route::post('/todos/{id}/toggle-complete', [TodoController::class, 'toggleComplete'])->name('todos.toggleComplete')->middleware('auth');;
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');;
