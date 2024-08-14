<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/invoices/{id}')
    ->whereUuid('id')
    ->group(function () {
        Route::get('', \App\Modules\Invoices\Api\Controller\GetInvoiceDataController::class);
        Route::post('/approve', \App\Modules\Invoices\Api\Controller\ApproveInvoiceController::class);
        Route::post('/reject', \App\Modules\Invoices\Api\Controller\RejectInvoiceController::class);
    });
