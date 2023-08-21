<?php

use App\Modules\Invoices\Application\Http\Controllers\InvoiceController;
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

Route::get('/invoices/{uuid}', [InvoiceController::class, 'show'])->name('invoices.show');
Route::post('/invoices/{uuid}/approve', [InvoiceController::class, 'approve'])->name('invoices.approve');
Route::post('/invoices/{uuid}/reject', [InvoiceController::class, 'reject'])->name('invoices.reject');
