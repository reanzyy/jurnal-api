<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompanyRule;
use Illuminate\Http\Request;

class InternshipCompanyRuleController extends Controller
{
    public function index()
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

    public function store(Request $request)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'sequence' => 'required|integer',
            'description' => 'required|string',
        ]);

        if (auth()->check()) {
            auth()->user()->id;
            $companyRule = InternshipCompanyRule::create($data);

            return response()->json(['message' => 'Internship Company Rules created successfully', 'data' => $companyRule]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $companyRule = InternshipCompanyRule::find($id);

        if (!$companyRule) {
            return response()->json(['message' => 'Internship Company Rules not found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $companyRule]);
    }

    public function update(Request $request, $id)
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
            auth()->user()->id;
            $companyRule->update($data);

            return response()->json(['message' => 'Internship Company Rules updated successfully', 'data' => $companyRule]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $companyRule = InternshipCompanyRule::find($id);

        if (!$companyRule) {
            return response()->json(['message' => 'Internship Company Rules not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $companyRule->delete();

            return response()->json(['message' => 'Internship Company Rules deleted successfully']);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
