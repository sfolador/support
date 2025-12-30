<?php

use Illuminate\Support\Facades\Route;
use Sfolador\Support\Http\Controllers\SupportRequestController;

Route::middleware(config('support.middleware', ['web']))
    ->prefix(config('support.route_prefix', 'support'))
    ->group(function () {
        Route::get('/', [SupportRequestController::class, 'index'])->name('support');
        Route::post('/', [SupportRequestController::class, 'store'])->name('support.store');
    });
