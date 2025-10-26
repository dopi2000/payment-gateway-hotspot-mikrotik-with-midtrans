<?php

use App\Http\Controllers\CallBackNotificationStatusTransactionMidtransController;
use App\Http\Controllers\CheckStatusPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackagesPageController;
use App\Http\Controllers\ValidatedFormController;
use App\Http\Controllers\PaymentProcessPageController;
use App\Http\Controllers\PaymentSuccessPageController;
use App\Http\Controllers\UserListsAccountHotspotController;


Route::middleware(['hotspot.access'])->group(function() {
    Route::get('/', [PackagesPageController::class, 'packages'])->name('index');
    Route::post('/', [ValidatedFormController::class, 'ValidatedPackage'])->name('validated');
    Route::get('/process', [PaymentProcessPageController::class, 'paymentProcess'])->name('payment.process');
    Route::post('/callback', [CallBackNotificationStatusTransactionMidtransController::class, 'callback'])->name('payment.callback');
    Route::get('/success', [PaymentSuccessPageController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/check', [CheckStatusPaymentController::class, 'check'])->name('check');
    Route::post('/check', [CheckStatusPaymentController::class, 'validatedOrderId'])->name('payment.check');

    // route untuk dashbaord admin
    Route::get('/login', [UserListsAccountHotspotController::class, 'login'])->middleware('guest')->name('login');
    Route::post('/login', [UserListsAccountHotspotController::class, 'validatedAdmin'])->name('validated.admin');
    Route::get('/customers', [UserListsAccountHotspotController::class, 'index'])->middleware('auth')->name('lists.order');
    Route::get('/logout', [UserListsAccountHotspotController::class, 'logout'])->middleware('auth')->name('logout');

    // convert web page to pdf file
    Route::get('/view/pdf', [UserListsAccountHotspotController::class, 'viewPdf'])->middleware('auth')->name('view.pdf');
});