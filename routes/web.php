<?php

use App\Http\Controllers\InvestmentsAccountController;
use App\Http\Controllers\InvestmentsController;
use App\Http\Controllers\TransfersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankAccountController;

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
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/my-accounts', [BankAccountController::class, 'view'])->middleware(['auth'])->name('my-accounts');
Route::get('/my-accounts/create', [BankAccountController::class, 'create'])->middleware(['auth'])->name('my-accounts.create');
Route::post('/my-accounts', [BankAccountController::class, 'store'])->middleware(['auth'])->name('my-accounts.store');

Route::get('/transfers', [TransfersController::class, 'view'])->middleware(['auth'])->name('transfers');
Route::get('/transfers/create', [TransfersController::class, 'create'])->middleware(['auth'])->name('transfers.create');
Route::post('/transfers', [TransfersController::class, 'store'])->middleware(['auth'])->name('transfers.store');
Route::get('/transfers/history', [TransfersController::class, 'history'])->middleware(['auth'])->name('transfers.history');

Route::get('/investments', [InvestmentsController::class, 'view'])->middleware(['auth'])->name('investments');
Route::get('/investments/create', [InvestmentsController::class, 'create'])->middleware(['auth'])->name('investments.create');
Route::post('/investments', [InvestmentsController::class, 'store'])->middleware(['auth'])->name('investments.store');
Route::post('/investments/sell', [InvestmentsController::class, 'sell'])->middleware(['auth'])->name('investments.sell');
Route::post('/investments/create-account', [InvestmentsAccountController::class, 'create'])->middleware(['auth'])->name('investments.create');

require __DIR__.'/auth.php';
