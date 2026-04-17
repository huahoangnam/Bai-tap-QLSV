<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentApiController;

Route::prefix('students')->group(function () {
    Route::get('/', [StudentApiController::class, 'index']);
    Route::post('/', [StudentApiController::class, 'store']);
    Route::get('/{id}', [StudentApiController::class, 'show']);
    Route::put('/{id}', [StudentApiController::class, 'update']);
    Route::delete('/{id}', [StudentApiController::class, 'destroy']);
    Route::get('/{id}/subjects', [StudentApiController::class, 'getSubjects']);
    Route::post('/{id}/register-subject/{subject_id}', [StudentApiController::class, 'registerSubject']);
});
