<?php

use App\Exports\ProductSalesReportExport;
use App\Http\Controllers\Client\AuthUserController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProductIncomingController;
use App\Http\Controllers\Client\ProductOutgoingController;
use App\Http\Controllers\Client\ProductTypeController;
use App\Http\Controllers\Client\BalanceStockController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\ReportController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthUserController::class, 'indexLogin'])->name('login');
    Route::post('/login', [AuthUserController::class, 'login']);
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/product', [ProductController::class, 'index']);
    Route::get('/product-data', [ProductController::class, 'data']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::post('/product/{product}', [ProductController::class, 'update']);
    Route::delete('/product/{product}', [ProductController::class, 'destroy']);
    Route::get('/type', [ProductTypeController::class, 'index']);
    Route::post('/type', [ProductTypeController::class, 'store']);
    Route::post('/type/{productType}', [ProductTypeController::class, 'update']);
    Route::delete('/type/{productType}', [ProductTypeController::class, 'destroy']);
    Route::get('/incoming', [ProductIncomingController::class, 'index']);
    Route::post('/incoming', [ProductIncomingController::class, 'store']);
    Route::post('/incoming/{incoming}', [ProductIncomingController::class, 'update']);
    Route::delete('/incoming/{incoming}', [ProductIncomingController::class, 'destroy']);
    Route::get('/outgoing', [ProductOutgoingController::class, 'index']);
    Route::post('/outgoing', [ProductOutgoingController::class, 'store']);
    Route::post('/outgoing/{outgoing}', [ProductOutgoingController::class, 'update']);
    Route::delete('/outgoing/{outgoing}', [ProductOutgoingController::class, 'destroy']);
    Route::get('/stock', [BalanceStockController::class, 'index']);
    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/report', [ReportController::class, 'store']);
    Route::get('/report-date', [ReportController::class, 'getStockOut']);

    Route::get('/logout', [AuthUserController::class, 'logout']);

    Route::get('/export-excel', function() {
        return Excel::download(new ProductSalesReportExport, 'product_sales_report.xlsx');
    });
    Route::get('/export-pdf', [DashboardController::class, 'exportPDF']);
});
