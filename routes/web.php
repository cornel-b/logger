<?php

use App\Http\Controllers\AppLogsController;
use App\Http\Controllers\ErrorsController;
use Illuminate\Support\Facades\Route;

Route::prefix('test')->group(function () {
    Route::get('/alternative-database', [ErrorsController::class, 'alternativeDatabaseError'])->name('test.alternative-database');
    Route::get('/division-by-zero', [ErrorsController::class, 'divisionByZero'])->name('test.division');
    Route::get('/malformed-json', [ErrorsController::class, 'malformedJson'])->name('test.json');
    Route::get('/carbon-error', [ErrorsController::class, 'carbonError'])->name('test.carbon');
    Route::get('/undefined-variable', [ErrorsController::class, 'undefinedVariable'])->name('test.undefined');
    Route::get('/array-index-error', [ErrorsController::class, 'arrayIndexError'])->name('test.array');
    Route::get('/log-only', [ErrorsController::class, 'logOnly'])->name('test.log');
});

Route::get('/app-logs', [AppLogsController::class, 'showLogs'])->name('app_logs.index');
