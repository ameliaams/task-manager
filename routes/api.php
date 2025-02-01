<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']); // Ambil semua task
    Route::post('/', [TaskController::class, 'store']); // Tambah task
    Route::get('/{id}', [TaskController::class, 'show']); // Detail task
    Route::put('/{id}', [TaskController::class, 'update']); // Update task
    Route::delete('/{id}', [TaskController::class, 'destroy']); // Hapus task
});
