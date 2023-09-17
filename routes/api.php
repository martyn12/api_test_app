<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/employee/create', [\App\Http\Controllers\EmployeeController::class, 'createEmployee']);
Route::post('/transaction/create', [\App\Http\Controllers\TransactionController::class, 'createTransaction']);
Route::get('/transaction/index', [\App\Http\Controllers\TransactionController::class, 'getPaymentSum']);
Route::patch('/transaction/conduct', [\App\Http\Controllers\TransactionController::class, 'conductTransactions']);
