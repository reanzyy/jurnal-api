<?php

use App\Http\Controllers\InternshipController;
use App\Http\Controllers\CompanyAdvisorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InternshipRuleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentController;
use App\Models\InternshipCompanyJobTitle;
use App\Models\InternshipCompanyEmployee;
use App\Models\InternshipCompetency;
use App\Models\InternshipEquipment;
use App\Models\InternshipJournal;
use App\Models\InternshipSuggestion;
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

Route::apiResource('students', StudentController::class);
Route::apiResource('school-years', SchoolYearsController::class);
Route::apiResource('classrooms', ClassroomController::class);
Route::apiResource('schools', SchoolController::class);
Route::apiResource('student-drafts', StudentDraftController::class);
Route::apiResource('companies', CompanyController::class);
Route::get('/internship-rules', [InternshipRuleController::class, 'index']);
Route::apiResource('notifications', NotificationController::class);
Route::apiResource('company_advisors', CompanyAdvisorController::class);
Route::apiResource('internships', InternshipController::class);
Route::apiResource('internship_company_job_titles', InternshipCompanyJobTitleController::class);
Route::apiResource('internship_company_employee', InternshipCompanyEmployeeController::class);
Route::apiResource('internship_journal', InternshipJournalController::class);
Route::apiResource('internship_journal', InternshipJournalController::class);
Route::apiResource('internship_suggestion', InternshipSuggestionController::class);
Route::apiResource('internship_equipment', InternshipEquipmentController::class);
Route::apiResource('internship_rules', InternshipRuleController::class);
