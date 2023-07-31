<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompetency;
use Illuminate\Http\Request;

class InternshipCompetencyController extends Controller
{
    public function getCompetency()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $competencies = InternshipCompetency::select("internship_competencies.*", "internships.*")
                    ->join("internships", "internships.id", "=", "internship_competencies.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredCompetency = [];
                foreach ($competencies as $competency) {

                    $filteredCompetency[] = [
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
            auth()->user()->id;
            $competency = InternshipCompetency::create($data);

            return response()->json(["error" => false, "message" => "Competency created successfully", "data" => $competency]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $competency = InternshipCompetency::find($id);

        if (!$competency) {
            return response()->json(["error" => true, "message" => "Competency not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $competency]);
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
            auth()->user()->id;
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
            auth()->user()->id;
            $competency->delete();

            return response()->json(["error" => false, "message" => "Competency deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
