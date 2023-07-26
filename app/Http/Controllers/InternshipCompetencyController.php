<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompetency;
use Illuminate\Http\Request;

class InternshipCompetencyController extends Controller
{
    public function index()
    {
        $competencies = InternshipCompetency::all();
        return response()->json(["error" => false, "message" => "success", "data" => $competencies]);
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
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

    public function destroy($id)
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