<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\OnboardController;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\VerificationApiController;

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
//Route::post('/register', [RegisterController::class, 'register']);

//Route::post('register', [API\RegisterController::class, 'register']);
//Route::post('register', 'API\RegisterController@register');
//Route::post('/login', [RegisterController::class, 'login']);
Route::post('/login', [PatientController::class, 'login']);

Route::middleware('auth:api')->group( function () {
	Route::resource('onboard',OnboardController::class);
	Route::get('/send-verify-mail/{email}',[PatientController::class, 'SendVerifyMail']);

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('email/verify/{id}', [PatientController::class, 'verify']);
//Route::post('email/resend',  [PatientController::class, 'resend']);
Route::get('/send-verify-mail/{email}',[PatientController::class, 'SendVerifyMail']);

Route::post('/register', [PatientController::class, 'register']);


Route::get('email/verify/{id}', [VerificationApiController::class, 'verify'])->name('verificationapi.verify');
Route::get('email/resend', [VerificationApiController::class, 'resend'])->name('verificationapi.resend');