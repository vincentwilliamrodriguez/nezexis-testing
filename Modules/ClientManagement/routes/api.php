<?php

use Illuminate\Support\Facades\Route;
use Modules\ClientManagement\Http\Controllers\ClientManagementController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('clientmanagements', ClientManagementController::class)->names('clientmanagement');
});
