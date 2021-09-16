<?php

use App\Http\Controllers\Transaction\TransactionController;
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

Route::prefix('users')->name('users.')->group(function () {
    Route::post('/', [UsersController::class, 'index'])->name('list');
    Route::post('/{id}', [UsersController::class, 'show'])->name('show');
    Route::put('/{id}/update', [UsersController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [UsersController::class, 'destroy'])->name('delete');
});

Route::post('/transaction', [TransactionController::class, 'transfer'])->name('transaction');
