<?php

use App\Http\Controllers\AssignDoctorController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DownloadAttachmentController;
use App\Http\Controllers\FinishSubmissionController;
use App\Http\Controllers\GetMySubmissionsController;
use App\Http\Controllers\GetOneSubmissionController;
use App\Http\Controllers\GetPendingSubmissionsController;
use App\Http\Controllers\GetUserController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\PreviewAttachmentController;
use App\Http\Controllers\SendEmailNewPasswordController;
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

Route::group(['middleware' => ['auth:sanctum',/*'verified'*/]], function() {
    Route::group(['middleware' => ['role:doctor']], function() {
        Route::post('submissions/{submission}/assignments', AssignDoctorController::class)->name('doctor.assign');
        Route::post('upload/{submission}',StoreAttachmentController::class)->name('submission.upload');
        Route::post('finish/{submission}',FinishSubmissionController::class)->name('submission.finish');
        Route::get('submissions', GetPendingSubmissionsController::class)->name('submissions.index');
    });
    Route::group(['middleware' => ['role:patient|doctor']], function() {
        Route::get('my-submissions/{status?}', GetMySubmissionsController::class)->name('my-submissions.index');
        Route::get('user', GetUserController::class)->name('user.index');
        Route::get('submissions/{submission}', GetOneSubmissionController::class)->name('submission.show');
        Route::get('download/{submission}',DownloadAttachmentController::class)->name('submission.download');
        Route::post('preview/{submission}',PreviewAttachmentController::class)->name('submission.preview');

    });
    Route::post('submissions', StoreSubmissionController::class)->name('submission.new')->middleware(PatientHasInfo::class);
    Route::post('info', InformationController::class)->name('patient.info')->middleware('role:patient');
});

Route::post('email/verification-notification', SendEmailVerificationController::class)->middleware('auth:sanctum');
Route::get('verify-email/{id}/{hash}', VerifyEmailVerificationController::class)->name('verification.verify');

Route::post('forgot-password', SendEmailNewPasswordController::class);
Route::post('reset-password', NewPasswordController::class);
