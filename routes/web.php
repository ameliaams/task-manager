<?php

use App\Http\Controllers\TaskController;
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

Route::get('api/tasks', [TaskController::class, 'index']);
Route::post('api/tasks', [TaskController::class, 'store']);
Route::get('api/tasks/{id}', [TaskController::class, 'show']);
Route::put('api/tasks/{id}', [TaskController::class, 'update']);
