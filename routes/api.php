<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipRuleController;
use App\Http\Controllers\NotificationController;
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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::resource('companies', CompanyController::class)->except(['create', 'edit']);
// Route::get('/companies', [CompanyController::class, 'index']);
// Route::post('/companies', [CompanyController::class, 'store']);
// Route::get('/companies', [CompanyController::class, 'show']);
// Route::put('/companies/{id}', [CompanyController::class, 'update']);
// Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

Route::get('/internship-rules', [InternshipRuleController::class, 'index']);

Route::resource('notifications', NotificationController::class)->except(['create', 'edit']);
