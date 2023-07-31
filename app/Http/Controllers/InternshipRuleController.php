<?php

namespace App\Http\Controllers;

use App\Models\InternshipRule;
use Illuminate\Http\Request;

class InternshipRuleController extends Controller
{
    public function index()
    {
        $Rules = InternshipRule::select("internship_rules.*", "school_years.name")
            ->join("school_years", "school_years.id", "=", "internship_rules.school_year_id")
            ->where("school_years.name", date('Y'))
            ->get();
        return response()->json(['error' => false, 'message' => 'success', 'data' => $Rules]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_year_id' => 'integer|exists:school_years,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $Rule = InternshipRule::create($data);

        return response()->json(['error' => false, 'message' => ' Rule created successfully', 'data' => $Rule]);
    }

    public function show($id)
    {
        $Rule = InternshipRule::find($id);

        if (!$Rule) {
            return response()->json(['error' => true, 'message' => ' Rule not found'], 404);
        }

        return response()->json(['error' => false, 'message' => 'success', 'data' => $Rule]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'school_year_id' => 'integer|exists:school_years,id',
            'name' => 'string|max:255',
            'description' => 'nullable|string',
        ]);

        $Rule = InternshipRule::find($id);

        if (!$Rule) {
            return response()->json(['error' => true, 'message' => ' Rule not found'], 404);
        }

        $Rule->update($data);

        return response()->json(['error' => false, 'message' => ' Rule updated successfully', 'data' => $Rule]);
    }

    public function destroy($id)
    {
        $Rule = InternshipRule::find($id);

        if (!$Rule) {
            return response()->json(['error' => true, 'message' => ' Rule not found'], 404);
        }

        $Rule->delete();

        return response()->json(['error' => false, 'message' => ' Rule deleted successfully']);
    }
}
