<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GetSubmissionController;
use App\Http\Controllers\PatientInfoController;
use App\Http\Controllers\StoreSubmissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', RegisterController::class)->name('user.register')->middleware('guest');

Route::post('login', LoginController::class)->name('user.login')->middleware('guest');

Route::post('logout', LogoutController::class)->name('user.logout')->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum','role:patient']], function() {
    Route::post('info', PatientInfoController::class)->name('patient.info');
});

Route::group(['middleware' => ['auth:sanctum','role:patient|doctor']], function() {
    Route::get('submissions', GetSubmissionController::class)->name('submission.index');
});

Route::group(['middleware' => ['auth:sanctum','role:full_patient']], function() {
    Route::post('submissions', StoreSubmissionController::class)->name('submission.new');
});
