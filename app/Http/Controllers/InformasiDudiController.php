<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternshipCompany;
use App\Models\InternshipJournal;
use App\Models\InternshipEquipment;
use App\Models\InternshipCompetency;
use App\Models\InternshipSuggestion;
use App\Models\InternshipCompanyRule;
use App\Models\InternshipCompanyEmployee;
use App\Models\InternshipCompanyJobTitle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class InformasiDudiController extends Controller
{

    // Internship Company
    public function getInternshipCompany()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $companies = InternshipCompany::select("internship_companies.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_companies.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredCompanies = [];
                foreach ($companies as $company) {
                    $filteredCompanies[] = [
                        "id" => $company->id,
                        "since" => $company->since,
                        "sectors" => $company->sectors,
                        "services" => $company->services,
                        "address" => $company->address,
                        "telephone" => $company->telephone,
                        "email" => $company->email,
                        "website" => $company->website,
                        "director" => $company->director,
                        "director_phone" => $company->director_phone,
                        "advisors" => $company->advisors,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredCompanies]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function updateInternshipCompany(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer",
            "since" => "integer",
            "sectors" => "array",
            "services" => "array",
            "address" => "nullable|string",
            "telephone" => "nullable|string",
            "email" => "nullable|string",
            "website" => "nullable|string",
            "director" => "nullable|string",
            "director_phone" => "nullable|string",
            "advisors" => "array|nullable",
        ]);

        $internship_company = InternshipCompany::find($id);

        if (!$internship_company) {
            return response()->json(["message" => "Internship Company not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $internship_company->update($data);
            return response()->json(["message" => "Internship Company updated successfully", "data" => $internship_company]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function getOrganizationStructure()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $companies = InternshipCompany::select("internship_companies.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_companies.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredCompanies = [];
                foreach ($companies as $company) {
                    $filteredCompanies[] = [
                        "id" => $company->id,
                        "structure" => $company->structure,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredCompanies]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function updateOrganizationStructure(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            "structure" => "nullable|image"
        ]);

        if ($validator->fails()) {
            $error = $validator->error()->all()[0];
            return response()->json(["error" => true, "message" => $error], 422);
        } else {
            $user = InternshipCompany::join("internships", "internships.id", "=", "internship_companies.internship_id")
                ->where("internships.user_id", auth()->user()->id)
                ->first();

            if (!$user) {
                return response()->json(["message" => "Organization not found"], 404);
            }

            if ($request->structure && $request->structure->isValid()) {
                $fileName = time() . '.' . $request->structure->extension();
                $request->structure->move(public_path("images"), $fileName);
                $path = "public/images/$fileName";
                $user->structure = $path;
            }

            $user->update();

            $filteredData = [
                'structure' => $user->structure
            ];

            return response()->json(["message" => "Organization structure updated successfully", "data" => $filteredData]);
        }
    }

    // Company Job Title
    public function getCompanyJobTitle()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $jobtitles = InternshipCompanyJobTitle::select("internship_company_job_titles.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_company_job_titles.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredJobtitle = [];
                foreach ($jobtitles as $jobtitle) {
                    $filteredJobtitle[] = [
                        "id" => $jobtitle->id,
                        "name" => $jobtitle->name,
                        "description" => $jobtitle->description,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredJobtitle]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeCompanyJobTitle(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "name" => "required|string|max:255",
            "description" => "nullable|string",
        ]);

        if (auth()->check()) {
            auth()->user();
            $jobTitle = InternshipCompanyJobTitle::create($data);

            return response()->json(["error" => false, "message" => "Job title created successfully", "data" => $jobTitle]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function updateCompanyJobTitle(Request $request, $id)
    {
        $data = $request->validate([
            "internship_company_id" => "integer|exists:internships,id",
            "name" => "string|max:255",
            "description" => "nullable|string",
        ]);

        $jobTitle = InternshipCompanyJobTitle::find($id);

        if (!$jobTitle) {
            return response()->json(["error" => true, "message" => "Job title not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $jobTitle->update($data);

            return response()->json(["error" => false, "message" => "Job title updated successfully", "data" => $jobTitle]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyCompanyJobTitle($id)
    {
        $jobTitle = InternshipCompanyJobTitle::find($id);

        if (!$jobTitle) {
            return response()->json(["error" => true, "message" => "Job title not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $jobTitle->delete();

            return response()->json(["error" => false, "message" => "Job title deleted successfully", "data" => $jobTitle]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    // Company Employee
    public function getCompanyEmployee()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $employees = InternshipCompanyEmployee::select("internship_company_employees.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_company_employees.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                if (!$employees) {
                    return response()->json(["error" => true, "message" => "Employee not found"], 404);
                }

                $filteredEmployee = [];
                foreach ($employees as $employee) {

                    $filteredEmployee[] = [
                        "id" => $employee->id,
                        "name" => $employee->name,
                        "job_title" => $employee->jobTitle->name,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredEmployee]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeCompanyEmployee(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "job_title_id" => "required|integer|exists:internship_company_job_titles,id",
            "name" => "required|string|max:255",
        ]);

        if (auth()->check()) {
            auth()->user();
            $employee = InternshipCompanyEmployee::create($data);

            return response()->json(["error" => false, "message" => "Employee created successfully", "data" => $employee]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function updateCompanyEmployee(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "job_title_id" => "integer|exists:internship_company_job_titles,id",
            "name" => "string|max:255",
        ]);

        $employee = InternshipCompanyEmployee::find($id);

        if (!$employee) {
            return response()->json(["error" => true, "message" => "Employee not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $employee->update($data);

            return response()->json(["error" => false, "message" => "Employee updated successfully", "data" => $employee]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyCompanyEmployee($id)
    {
        $employee = InternshipCompanyEmployee::find($id);

        if (!$employee) {
            return response()->json(["error" => true, "message" => "Employee not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $employee->delete();

            return response()->json(["error" => false, "message" => "Employee deleted successfully", "data" => $employee]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    // Competency
    public function getCompetency()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $competencies = InternshipCompetency::select("internship_competencies.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_competencies.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredCompetency = [];
                foreach ($competencies as $competency) {

                    $filteredCompetency[] = [
                        "id" => $competency->id,
                        "competency" => $competency->competency,
                        "description" => $competency->description,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredCompetency]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeCompetency(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "competency" => "required|string|max:255",
            "description" => "nullable|string",
        ]);

        if (auth()->check()) {
            auth()->user();
            $competency = InternshipCompetency::create($data);

            return response()->json(["error" => false, "message" => "Competency created successfully", "data" => $competency]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function updateCompetency(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "competency" => "string|max:255",
            "description" => "nullable|string",
        ]);

        $competency = InternshipCompetency::find($id);

        if (!$competency) {
            return response()->json(["error" => true, "message" => "Competency not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $competency->update($data);

            return response()->json(["error" => false, "message" => "Competency updated successfully", "data" => $competency]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyCompetency($id)
    {
        $competency = InternshipCompetency::find($id);

        if (!$competency) {
            return response()->json(["error" => true, "message" => "Competency not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $competency->delete();

            return response()->json(["error" => false, "message" => "Competency deleted successfully", "data" => $competency]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    // Company Suggestion
    public function getCompanySuggestion()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $suggestions = InternshipSuggestion::select("internship_suggestions.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_suggestions.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredSuggestion = [];
                foreach ($suggestions as $suggestion) {
                    $employeeData = [
                        "name" => $suggestion->companyEmployee->name,
                    ];

                    $employeeData['job_title'] = $suggestion->companyEmployee->jobTitle->name;

                    $filteredSuggestion[] = [
                        "id" => $suggestion->id,
                        "suggest" => $suggestion->suggest,
                        "employee" => $employeeData,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredSuggestion]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeCompanySuggestion(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "company_employee_id" => "required|integer|exists:internship_company_employees,id",
            "suggest" => "required|string",
            "approval_user_id" => "nullable|integer|exists:users,id",
            "approval_by" => "nullable|string",
            "approval_at" => "nullable|timestamp",
        ]);

        if (auth()->check()) {
            auth()->user();
            $suggestion = InternshipSuggestion::create($data);

            return response()->json(["error" => false, "message" => "Suggestion created successfully", "data" => $suggestion]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function updateCompanySuggestion(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "company_employee_id" => "integer|exists:internship_company_employees,id",
            "suggest" => "string",
            "approval_user_id" => "nullable|integer|exists:users,id",
            "approval_by" => "nullable|string",
            "approval_at" => "nullable|timestamp",
        ]);

        $suggestion = InternshipSuggestion::find($id);

        if (!$suggestion) {
            return response()->json(["error" => true, "message" => "Suggestion not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $suggestion->update($data);

            return response()->json(["error" => false, "message" => "Suggestion updated successfully", "data" => $suggestion]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyCompanySuggestion($id)
    {
        $suggestion = InternshipSuggestion::find($id);

        if (!$suggestion) {
            return response()->json(["error" => true, "message" => "Suggestion not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $suggestion->delete();

            return response()->json(["error" => false, "message" => "Suggestion deleted successfully", "data" => $suggestion]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    // Equipment
    public function getCompanyEquipment()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $equipments = InternshipEquipment::select("internship_equipments.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_equipments.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredEquipment = [];
                foreach ($equipments as $equipment) {

                    $filteredEquipment[] = [
                        "id" => $equipment->id,
                        "tool" => $equipment->tool,
                        "specification" => $equipment->specification,
                        "utility" => $equipment->utility,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredEquipment]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeCompanyEquipment(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "tool" => "required|string|max:255",
            "specification" => "required|string|max:255",
            "utility" => "required|string",
        ]);

        if (auth()->check()) {
            auth()->user();
            $equipment = InternshipEquipment::create($data);

            return response()->json(["error" => false, "message" => "Journal created successfully", "data" => $equipment]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function updateCompanyEquipment(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "tool" => "required|string|max:255",
            "specification" => "required|string|max:255",
            "utility" => "required|string",
        ]);

        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(["error" => true, "message" => "Equipment not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $equipment->update($data);

            return response()->json(["error" => false, "message" => "Equipment updated successfully", "data" => $equipment]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyCompanyEquipment($id)
    {
        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(["error" => true, "message" => "Equipment not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $equipment->delete();

            return response()->json(["error" => false, "message" => "Equipment deleted successfully", "data" => $equipment]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    // Company Rules
    public function getCompanyRules()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $rules = InternshipCompanyRule::select("internship_company_rules.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_company_rules.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredRules = [];
                foreach ($rules as $rule) {

                    $filteredRules[] = [
                        "id" => $rule->id,
                        "internship_id" => $rule->internship_id,
                        "sequence" => $rule->sequence,
                        "description" => $rule->description,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredRules]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeCompanyRules(Request $request)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'sequence' => 'required|integer',
            'description' => 'required|string',
        ]);

        if (auth()->check()) {
            auth()->user();
            $companyRule = InternshipCompanyRule::create($data);

            return response()->json(['message' => 'Internship Company Rules created successfully', 'data' => $companyRule]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function updateCompanyRules(Request $request, $id)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'sequence' => 'integer',
            'description' => 'string',
        ]);

        $companyRule = InternshipCompanyRule::find($id);

        if (!$companyRule) {
            return response()->json(['message' => 'Internship Company Rules not found'], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $companyRule->update($data);

            return response()->json(['message' => 'Internship Company Rules updated successfully', 'data' => $companyRule]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyCompanyRules($id)
    {
        $companyRule = InternshipCompanyRule::find($id);

        if (!$companyRule) {
            return response()->json(['message' => 'Internship Company Rules not found'], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $companyRule->delete();

            return response()->json(['message' => 'Internship Company Rules deleted successfully', "data" => $companyRule]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}