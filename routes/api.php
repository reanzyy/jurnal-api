<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\SchoolYearsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentDraftController;
use App\Http\Controllers\CompanyAdvisorController;
use App\Http\Controllers\InformasiUmumController;
use App\Http\Controllers\InternshipCompanyController;
use App\Http\Controllers\InternshipRuleController;
use App\Http\Controllers\InternshipJournalController;
use App\Http\Controllers\InternshipEquipmentController;
use App\Http\Controllers\InternshipSuggestionController;
use App\Http\Controllers\InternshipCompanyEmployeeController;
use App\Http\Controllers\InternshipCompanyJobTitleController;
use App\Http\Controllers\InternshipCompanyRuleController;
use App\Http\Controllers\InternshipCompetencyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolAdvisorController;
use App\Models\School;
use App\Models\SchoolAdvisor;

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
Route::post('profile/upload', [ProfileController::class, "upload"]);
// Route::put('profile/updatephoto', [ProfileController::class, "updateImage"]);
Route::put('profile/personal', [ProfileController::class, 'update_profile_personal']);

Route::get('profile/parent', [ProfileController::class, 'profile_parent']);
Route::put('profile/parent', [ProfileController::class, 'update_profile_parent']);

Route::get('profile/schedule-internship', [ProfileController::class, 'profile_schedule']);
Route::put('profile/schedule-internship', [ProfileController::class, 'update_profile_schedule_internship']);

Route::apiResource('journals', InternshipJournalController::class);

Route::get('information/internship', [InformasiUmumController::class, 'getInformation']);

Route::apiResource('information/company', InternshipCompanyController::class);
Route::apiResource('information/job-title', InternshipCompanyJobTitleController::class);
Route::apiResource('information/employee', InternshipCompanyEmployeeController::class);
Route::apiResource('information/competency', InternshipCompetencyController::class);
Route::apiResource('information/suggestion', InternshipSuggestionController::class);
Route::apiResource('information/equipment', InternshipEquipmentController::class);
Route::apiResource('information/company-rules', InternshipCompanyRuleController::class);

Route::get('information/organization', [InternshipCompanyController::class, 'getOrganization']);
Route::post('information/organization', [InternshipCompanyController::class, 'updateImage']);


// Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
// Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);


// Route::apiResource('students', StudentController::class);
// Route::apiResource('school-years', SchoolYearsController::class);
// Route::apiResource('classrooms', ClassroomController::class);
// Route::apiResource('schools', SchoolController::class);
// Route::apiResource('student-drafts', StudentDraftController::class);
// Route::apiResource('companies', CompanyController::class);
// Route::apiResource('notifications', NotificationController::class);
// Route::apiResource('company_advisors', CompanyAdvisorController::class);
// Route::apiResource('school_advisors', SchoolAdvisorController::class);
// Route::apiResource('internships', InternshipController::class);
// Route::apiResource('internship_rules', InternshipRuleController::class);