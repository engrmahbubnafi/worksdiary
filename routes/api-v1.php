<?php

use App\Http\Controllers\Api\V1\ApiAreaController;
use App\Http\Controllers\Api\V1\ApiCompanyController;
use App\Http\Controllers\Api\V1\ApiCompanyUnit;
use App\Http\Controllers\Api\V1\ApiSourceController;
use App\Http\Controllers\Api\V1\ApiUnitController;
use App\Http\Controllers\Api\V1\ApiUserController;
use App\Http\Controllers\Api\V1\ApiVisitController;
use App\Http\Controllers\Api\V1\ApiZoneController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\ResetPasswordController;
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

Route::group([
    'middleware' => 'auth:sanctum',
], function () {

    Route::post('/user/details', [ApiUserController::class, 'details'])
        ->name('api.user_details');

    Route::post('/users/edit/mobile', [ApiUserController::class, 'mobileEdit'])
        ->name('api.user.edit.mobile');

    Route::post('/users/edit/avatar', [ApiUserController::class, 'avatarEdit'])
        ->name('api.user.edit.avatar');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');

    Route::post('/get-companies', [ApiCompanyController::class, 'getCompanies']);

    Route::post('/get-unit-types', [ApiUnitController::class, 'getUnitTypes']);

    Route::post('/get-sources', [ApiSourceController::class, 'getSources']);

    Route::post('/get-zones', [ApiZoneController::class, 'getZones']);

    Route::post('/get-areas', [ApiAreaController::class, 'getAreas']);

    Route::post('/get-company-units', [ApiCompanyUnit::class, 'getCompanyUnits']);

    Route::post('/get-visitors', [ApiVisitController::class, 'getVisitors']);

    Route::post('/get-visits', [ApiVisitController::class, 'getVisits']);

    Route::post('/visit-objectives', [ApiVisitController::class, 'visitObjectives']);

    Route::post('/visit-details', [ApiVisitController::class, 'visitDetails']);
});

// Routes those don't need authentication.
Route::post('/login', [AuthController::class, 'login'])
    ->name('api.login');

Route::post('send-otp', [ResetPasswordController::class, 'sendOtp'])
    ->name('api.send_otp');

Route::post('verify-otp', [ResetPasswordController::class, 'verifyOtp'])
    ->name('api.verify_otp');

Route::post('reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->name('api.reset_password');
