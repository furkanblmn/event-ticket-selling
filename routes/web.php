<?php

use App\Http\Controllers\UI\EventController;
use App\Http\Controllers\UI\PaymentController;
use App\Http\Controllers\UI\SeatPlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('events.index');
});


Route::controller(EventController::class)->prefix('events')->name('events.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{eventId}', 'show')->name('show');
});

Route::get('/seat-plans/{eventId}/{categoryId}', [SeatPlanController::class, 'index'])->name('seat-plans.index');

Route::controller(PaymentController::class)->prefix('payment')->name('payments.')->group(function () {
    Route::get('/', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/success/{orderId}', 'success')->name('success');
});
