<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class,'index'])->name('home');

Route::resources([
    'customers'=>CustomerController::class,
    'products'=>ProductController::class,
    'inventory'=>InventoryController::class
]);

Route::get('/inventoryhistory',[InventoryController::class,'inventoryHistory'])->name('inventoryHistory');

Route::group(['prefix'=>'settings'], function(){
    Route::get('/view',[DashboardController::class,'viewSettings'])->name('viewSettings');
    Route::post('/update',[DashboardController::class,'settingsUpdate'])->name('settingsUpdate');
});

Route::group(['prefix'=>'invoice'], function(){
    Route::get('/list',[InvoiceController::class,'invoiceList'])->name('invoiceList');
    Route::get('/form',[InvoiceController::class,'showGenerateForm'])->name('showGenerateForm');
    Route::post('/generate',[InvoiceController::class,'generateInvoice'])->name('generateInvoice');
    Route::post('/add-product',[InvoiceController::class,'addSingleProduct'])->name('addSingleProduct');
    Route::post('/product-info',[InvoiceController::class,'getProductInfo'])->name('getProductInfo');

    Route::get('/download-zip/{file}', [InvoiceController::class, 'downloadZip'])->name('downloadZip');

});