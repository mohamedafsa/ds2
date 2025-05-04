<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\GroupGoalController;
use App\Http\Controllers\JournalController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('goals', GoalController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('goals', GoalController::class)->middleware('owns.goal');
    Route::apiResource('steps', StepController::class);
    Route::apiResource('progress', ProgressController::class);
    Route::apiResource('map-pins', MapController::class);
    Route::apiResource('timelines', TimelineController::class);
    Route::apiResource('badges', BadgeController::class);
    Route::apiResource('group-goals', GroupGoalController::class);
    Route::apiResource('journals', JournalController::class);

    Route::post('/goals/{goal}/suggest-steps', [GoalController::class, 'suggestSteps']);
});




