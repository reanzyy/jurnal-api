<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompanyJobTitle;
use Illuminate\Http\Request;

class InternshipCompanyJobTitleController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $jibtitles = InternshipCompanyJobTitle::select("internship_company_job_titles.*", "internships.*")
                    ->join("internships", "internships.id", "=", "internship_company_job_titles.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredJobtitle = [];
                foreach ($jibtitles as $jobtitle) {
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

    public function store(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "name" => "required|string|max:255",
            "description" => "nullable|string",
        ]);

        if (auth()->check()) {
            auth()->user()->id;
            $jobTitle = InternshipCompanyJobTitle::create($data);

            return response()->json(["error" => false, "message" => "Job title created successfully", "data" => $jobTitle]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $jobTitle = InternshipCompanyJobTitle::find($id);

        if (!$jobTitle) {
            return response()->json(["error" => true, "message" => "Job title not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $jobTitle]);
    }

    public function update(Request $request, $id)
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
            auth()->user()->id;
            $jobTitle->update($data);

            return response()->json(["error" => false, "message" => "Job title updated successfully", "data" => $jobTitle]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $jobTitle = InternshipCompanyJobTitle::find($id);

        if (!$jobTitle) {
            return response()->json(["error" => true, "message" => "Job title not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $jobTitle->delete();

            return response()->json(["error" => false, "message" => "Job title deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
