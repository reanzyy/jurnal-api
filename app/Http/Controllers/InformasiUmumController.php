<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\InternshipRule;
use App\Models\School;
use App\Models\SchoolAdvisor;
use App\Models\Student;
use Illuminate\Http\Request;

class InformasiUmumController extends Controller
{
    public function getInformation()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $internship = Internship::with('schoolYear', 'student', 'company', 'schoolAdvisor', 'companyAdvisor')
                    ->where('user_id', auth()->user()->id)
                    ->get();
                $rules = InternshipRule::select("internship_rules.*", "school_years.name")
                    ->join("school_years", "school_years.id", "=", "internship_rules.school_year_id")
                    ->where("school_years.name", date('Y'))
                    ->get();

                $filteredInternship = [];
                foreach ($internship as $data) {
                    $filteredInternship[] = [
                        "id" => $data->id,
                        "name" => $data->student->name,
                        "classroom" => $data->student->classroom->name,
                        "vocational_program" => $data->student->classroom->vocational_program,
                        "school_year" => $data->student->schoolYear->name,
                        "company" => $data->company->name,
                        "advisor" => [
                            "school" => $data->schoolAdvisor->pluck('name'),
                            "company" => $data->companyAdvisor->pluck('name')
                        ],
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => [
                    "student" => $filteredInternship,
                    "internship_rules" => $rules,
                ]]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }
}
