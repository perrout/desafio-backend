<?php

use App\Http\Controllers\Users\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('users', [UsersController::class, 'index'])->name('users');
Route::post('users/{id}', [UsersController::class, 'show'])->name('users.show');
Route::put('users/{id}/update', [UsersController::class, 'update'])->name('users.update');
Route::delete('users/{id}/delete', [UsersController::class, 'destroy'])->name('users.delete');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
