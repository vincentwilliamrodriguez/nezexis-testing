<?php

use Illuminate\Support\Facades\Route;
use Modules\ClientManagement\Http\Controllers\ClientManagementController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clientmanagements', ClientManagementController::class)->names('clientmanagement');
});
