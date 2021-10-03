<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
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

Route::post('/company', [CompanyController::class, 'create']);
Route::post('/invoice', [InvoiceController::class, 'create']);
Route::post('/invoice/{invoiceId}/paid', [InvoiceController::class, 'update']);