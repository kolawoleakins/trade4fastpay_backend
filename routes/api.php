<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\TradeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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


//public routes 
Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);
Route::get('send-verify-mail/{email}',[EmailVerificationController::class,'sendVerifyMail']);

//sendVerificationEmail
// Route::post('email/verify',[EmailVerificationController::class,'sendVerificationEmail'])->name('verification.notice');
// Route::get('email/verify/{id}/{hash}',[EmailVerificationController::class,'verify'])->name('verification.verify');


//protected routes
//add the verified to the middleware
Route::group([
    'middleware' => ['auth:sanctum']
],
function () 
{
    Route::resource('trade',TradeController::class);
    Route::post('logout',[AuthController::class, 'logout']);
}
);