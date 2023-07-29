<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;
use App\Models\InternshipCompany;
use Illuminate\Support\Facades\Storage;

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

    public function updateImage(Request $request, $id)
    {
        $data = $request->validate([
            "structure" => "image", // Make sure the "structure" field is an image
        ]);

        $internship_company = InternshipCompany::find($id);

        if (!$internship_company) {
            return response()->json(["message" => "Internship Company not found"], 404);
        }

        if ($request->file('structure')) {
            $structure = time() . '.' . $request->file('structure')->getClientOriginalExtension();
            $request->file('structure')->move(public_path("structure"), $structure);

            // Update the "structure" attribute in the database
            $internship_company->structure = $structure;
        }

        // Save the changes to the database
        $internship_company->save();

        if (auth()->check()) {
            // Get the authenticated user's ID (you can use it for further processing if needed)
            $authenticatedUserId = auth()->user()->id;
            return response()->json(["message" => "Internship Company updated successfully", "data" => $internship_company], 200);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"], 401);
        }
    }
}
