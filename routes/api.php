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

Route::apiResource('companies', CompanyController::class);
// Route::get('/companies', [CompanyController::class, 'index']);
// Route::post('/companies', [CompanyController::class, 'store']);
// Route::get('/companies', [CompanyController::class, 'show']);
// Route::put('/companies/{id}', [CompanyController::class, 'update']);
// Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

Route::get('/internship-rules', [InternshipRuleController::class, 'index']);

Route::apiResource('notifications', NotificationController::class);

Route::apiResource('company_advisors', CompanyAdvisorController::class);
// Route::get('/company_advisors', [CompanyAdvisorController::class, 'index']);
// Route::post('/company_advisors', [CompanyAdvisorController::class, 'store']);
// Route::get('/company_advisors/{id}', [CompanyAdvisorController::class, 'show']);
// Route::put('/company_advisors/{id}', [CompanyAdvisorController::class, 'update']);
// Route::delete('/company_advisors/{id}', [CompanyAdvisorController::class, 'destroy']);

Route::apiResource('internships', InternshipController::class);
// Route::get('/internships', [InternshipController::class, 'index']);
// Route::post('/internships', [InternshipController::class, 'store']);
// Route::get('/internships/{id}', [InternshipController::class, 'show']);
// Route::put('/internships/{id}', [InternshipController::class, 'update']);
// Route::delete('/internships/{id}', [InternshipController::class, 'destroy']);

Route::apiResource('internship_company_job_titles', InternshipCompanyJobTitleController::class);
// Route::get('/internship_company_job_titles', [InternshipCompanyJobTitle::class, 'index']);
// Route::post('/internship_company_job_titles', [InternshipCompanyJobTitle::class, 'store']);
// Route::get('/internship_company_job_titles/{id}', [InternshipCompanyJobTitle::class, 'show']);
// Route::put('/internship_company_job_titles/{id}', [InternshipCompanyJobTitle::class, 'update']);
// Route::delete('/internship_company_job_titles/{id}', [InternshipCompanyJobTitle::class, 'destroy']);

Route::apiResource('internship_company_employee', InternshipCompanyEmployeeController::class);
// Route::get('/internships_company_employee', [InternshipCompanyEmployee::class, 'index']);
// Route::post('/internships_company_employee', [InternshipCompanyEmployee::class, 'store']);
// Route::get('/internships_company_employee/{id}', [InternshipCompanyEmployee::class, 'show']);
// Route::put('/internships_company_employee/{id}', [InternshipCompanyEmployee::class, 'update']);
// Route::delete('/internships_company_employee/{id}', [InternshipCompanyEmployee::class, 'destroy']);

Route::apiResource('internship_journal', InternshipJournalController::class);
// Route::get('/internships_journal', [InternshipJournal::class, 'index']);
// Route::post('/internships_journal', [InternshipJournal::class, 'store']);
// Route::get('/internships_journal/{id}', [InternshipJournal::class, 'show']);
// Route::put('/internships_journal/{id}', [InternshipJournal::class, 'update']);
// Route::delete('/internships_journal/{id}', [InternshipJournal::class, 'destroy']);

Route::apiResource('internship_journal', InternshipJournalController::class);
// Route::get('/internships_competencies', [InternshipCompetency::class, 'index']);
// Route::post('/internships_competencies', [InternshipCompetency::class, 'store']);
// Route::get('/internships_competencies/{id}', [InternshipCompetency::class, 'show']);
// Route::put('/internships_competencies/{id}', [InternshipCompetency::class, 'update']);
// Route::delete('/internships_competencies/{id}', [InternshipCompetency::class, 'destroy']);

Route::apiResource('internship_suggestion', InternshipSuggestionController::class);
// Route::get('/internship_suggestion', [InternshipSuggestion::class, 'index']);
// Route::post('/internship_suggestion', [InternshipSuggestion::class, 'store']);
// Route::get('/internship_suggestion/{id}', [InternshipSuggestion::class, 'show']);
// Route::put('/internship_suggestion/{id}', [InternshipSuggestion::class, 'update']);
// Route::delete('/internship_suggestion/{id}', [InternshipSuggestion::class, 'destroy']);

Route::apiResource('internship_equipment', InternshipEquipmentController::class);
// Route::get('/internship_equipment', [InternshipEquipment::class, 'index']);
// Route::post('/internship_equipment', [InternshipEquipment::class, 'store']);
// Route::get('/internship_equipment/{id}', [InternshipEquipment::class, 'show']);
// Route::put('/internship_equipment/{id}', [InternshipEquipment::class, 'update']);
// Route::delete('/internship_equipment/{id}', [InternshipEquipment::class, 'destroy']);

Route::apiResource('internship_rules', InternshipRuleController::class);
// Route::get('/internship_rules', [InternshipCom::class, 'index']);
// Route::post('/internship_rules', [InternshipCom::class, 'store']);
// Route::get('/internship_rules/{id}', [InternshipCom::class, 'show']);
// Route::put('/internship_rules/{id}', [InternshipCom::class, 'update']);
// Route::delete('/internship_rules/{id}', [InternshipCom::class, 'destroy']);
