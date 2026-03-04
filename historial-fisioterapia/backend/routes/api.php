<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\FunctionalAssessmentController;
use App\Http\Controllers\GaitAnalysisController;
use App\Http\Controllers\MobilityArcController;
use App\Http\Controllers\MuscleEvaluationController;
use App\Http\Controllers\PostureEvaluationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('patients', PatientController::class);
    Route::apiResource('therapists', TherapistController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('functional-assessments', FunctionalAssessmentController::class);
    Route::apiResource('gait-analyses', GaitAnalysisController::class);
    Route::apiResource('mobility-arcs', MobilityArcController::class);
    Route::apiResource('muscle-evaluations', MuscleEvaluationController::class);
    Route::apiResource('posture-evaluations', PostureEvaluationController::class);
});