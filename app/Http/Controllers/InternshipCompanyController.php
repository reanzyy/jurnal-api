<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;
use App\Models\InternshipCompany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InternshipCompanyController extends Controller
{
    public function index()
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

    public function update(Request $request, $id)
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
            "structure" => "nullable|image",
        ]);

        $internship_company = InternshipCompany::find($id);

        if (!$internship_company) {
            return response()->json(["message" => "Internship Company not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $internship_company->update($data);
            return response()->json(["message" => "Internship Company updated successfully", "data" => $internship_company]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function getOrganization()
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


    public function updateImage(Request $request)
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

            if ($request->structure && $request->structure->isValid()) {
                $fileName = time() . '.' . $request->structure->extension();
                $request->structure->move(public_path("structure"), $fileName);
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
}
