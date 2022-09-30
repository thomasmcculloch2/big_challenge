<?php

use App\Http\Controllers\AssignDoctorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DownloadAttachmentController;
use App\Http\Controllers\GetOneSubmissionController;
use App\Http\Controllers\GetSubmissionController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SendEmailVerificationController;
use App\Http\Controllers\StoreAttachmentController;
use App\Http\Controllers\StoreSubmissionController;
use App\Http\Controllers\VerifyEmailVerificationController;
use App\Http\Middleware\PatientHasInfo;
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

Route::group(['middleware' => ['auth:sanctum','role:patient','verified']], function() {
    Route::post('info', InformationController::class)->name('patient.info');
});

Route::group(['middleware' => ['auth:sanctum','role:doctor','verified']], function() {
    Route::post('submissions/{submission}/assignments', AssignDoctorController::class)->name('doctor.assign');
    Route::post('upload/{submission}',StoreAttachmentController::class)->name('submission.upload');
});

Route::group(['middleware' => ['auth:sanctum','role:patient|doctor','verified']], function() {
    Route::get('submissions', GetSubmissionController::class)->name('submission.index');
    Route::get('submissions/{submission}', GetOneSubmissionController::class)->name('submission.show');
    Route::post('download/{submission}',DownloadAttachmentController::class)->name('submission.download');

});

Route::group(['middleware' => ['auth:sanctum',PatientHasInfo::class,'verified']], function() {
    Route::post('submissions', StoreSubmissionController::class)->name('submission.new');
});

Route::post('email/verification-notification', SendEmailVerificationController::class)->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', VerifyEmailVerificationController::class)->name('verification.verify')->middleware('auth:sanctum');
