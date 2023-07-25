<?php

namespace App\Http\Controllers;

use App\Models\InternshipRule;
use Illuminate\Http\Request;

class InternshipRuleController extends Controller
{
    public function index()
    {
        $internshipRules = InternshipRule::all();
        return response()->json(['message' => 'Success', 'data' => $internshipRules]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_year_id' => 'required|integer',
            'sequence' => 'required|integer',
            'description' => 'required|string',
        ]);

        $internshipRule = InternshipRule::create($data);

        return response()->json(['message' => 'Internship rule created successfully', 'data' => $internshipRule]);
    }

    public function show($id)
    {
        $internshipRule = InternshipRule::find($id);

        if (!$internshipRule) {
            return response()->json(['message' => 'Internship rule not found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $internshipRule]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'school_year_id' => 'integer',
            'sequence' => 'integer',
            'description' => 'string',
        ]);

        $internshipRule = InternshipRule::find($id);

        if (!$internshipRule) {
            return response()->json(['message' => 'Internship rule not found'], 404);
        }

        $internshipRule->update($data);

        return response()->json(['message' => 'Internship rule updated successfully', 'data' => $internshipRule]);
    }

    public function destroy($id)
    {
        $internshipRule = InternshipRule::find($id);

        if (!$internshipRule) {
            return response()->json(['message' => 'Internship rule not found'], 404);
        }

        $internshipRule->delete();

        return response()->json(['message' => 'Internship rule deleted successfully']);
    }
}
