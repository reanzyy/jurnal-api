<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InformasiDudiController;
use App\Http\Controllers\InformasiUmumController;
use App\Http\Controllers\InternshipJournalController;

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
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::get('profile/personal', [ProfileController::class, 'profile_personal']);
Route::post('profile/upload', [ProfileController::class, "uploadPhoto"]);
Route::post('profile/personal', [ProfileController::class, 'update_profile_personal']);
Route::get('profile/parent', [ProfileController::class, 'profile_parent']);
Route::put('profile/parent', [ProfileController::class, 'update_profile_parent']);
Route::get('profile/schedule-internship', [ProfileController::class, 'profile_schedule']);
Route::put('profile/schedule-internship', [ProfileController::class, 'update_profile_schedule_internship']);

Route::apiResource('journals', InternshipJournalController::class);
Route::get('generate-pdf', [InternshipJournalController::class, 'generatePDF']);
Route::get('journal/download-link', [InternshipJournalController::class, 'generateDownloadLink']);

Route::get('information/internship', [InformasiUmumController::class, 'getInformation']);

Route::get('information/company', [InformasiDudiController::class, 'getInternshipCompany']);
Route::put('information/company/{id}', [InformasiDudiController::class, 'updateInternshipCompany']);
Route::get('information/organization', [InformasiDudiController::class, 'getOrganizationStructure']);
Route::post('information/organization', [InformasiDudiController::class, 'updateOrganizationStructure']);

Route::get('information/job-title', [InformasiDudiController::class, 'getCompanyJobTitle']);
Route::post('information/job-title', [InformasiDudiController::class, 'storeCompanyJobTitle']);
Route::put('information/job-title/{id}', [InformasiDudiController::class, 'updateCompanyJobTitle']);
Route::delete('information/job-title/{id}', [InformasiDudiController::class, 'destroyCompanyJobTitle']);

Route::get('information/employee', [InformasiDudiController::class, 'getCompanyEmployee']);
Route::post('information/employee', [InformasiDudiController::class, 'storeCompanyEmployee']);
Route::put('information/employee/{id}', [InformasiDudiController::class, 'updateCompanyEmployee']);
Route::delete('information/employee/{id}', [InformasiDudiController::class, 'destroyCompanyEmployee']);

Route::get('information/competency', [InformasiDudiController::class, 'getCompetency']);
Route::post('information/competency', [InformasiDudiController::class, 'storeCompetency']);
Route::put('information/competency/{id}', [InformasiDudiController::class, 'updateCompetency']);
Route::delete('information/competency/{id}', [InformasiDudiController::class, 'destroyCompetency']);

Route::get('information/suggestion', [InformasiDudiController::class, 'getCompanySuggestion']);
Route::post('information/suggestion', [InformasiDudiController::class, 'storeCompanySuggestion']);
Route::put('information/suggestion/{id}', [InformasiDudiController::class, 'updateCompanySuggestion']);
Route::delete('information/suggestion/{id}', [InformasiDudiController::class, 'destroyCompanySuggestion']);

Route::get('information/equipment', [InformasiDudiController::class, 'getCompanyEquipment']);
Route::post('information/equipment', [InformasiDudiController::class, 'storeCompanyEquipment']);
Route::put('information/equipment/{id}', [InformasiDudiController::class, 'updateCompanyEquipment']);
Route::delete('information/equipment/{id}', [InformasiDudiController::class, 'destroyCompanyEquipment']);

Route::get('information/company-rules', [InformasiDudiController::class, 'getCompanyRules']);
Route::post('information/company-rules', [InformasiDudiController::class, 'storeCompanyRules']);
Route::put('information/company-rules/{id}', [InformasiDudiController::class, 'updateCompanyRules']);
Route::delete('information/company-rules/{id}', [InformasiDudiController::class, 'destroyCompanyRules']);

Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/{id}', [NotificationController::class, 'show']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::put('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);