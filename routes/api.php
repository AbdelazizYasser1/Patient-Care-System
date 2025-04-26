<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ {
    AuthController,
    DoctorController,
    Medical_historyController,
    PatientsController,
    QuestionController,
    ResponseController,
    XRayController
};

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);

    Route::apiResource('patients', PatientsController::class);

    Route::apiResource('doctors', DoctorController::class);

    Route::apiResource('medical_histories', Medical_historyController::class);
    Route::get('medical_histories_of_patient/{user_id}', [Medical_historyController::class, 'show']);

    Route::get('X-Ray_of_patient/{user_id}', [XRayController::class, 'show']);
    Route::get('Unique_XRay/{XRay_id}', [XRayController::class, 'Unique_XRay']);
    Route::apiResource('XRay', XRayController::class);

    Route::apiResource('questions', QuestionController::class);
    Route::get('showquestions/{doctor_id}/{patient_id}', [QuestionController::class, 'getPatientDoctorQuestions']);

    Route::apiResource('responses', ResponseController::class);
    Route::get('showanswers/{doctor_id}/{patient_id}', [ResponseController::class, 'getResoureformdoctor']);
});
