<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompanyRule;
use Illuminate\Http\Request;

class InternshipCompanyRuleController extends Controller
{
    public function index()
    {
        $companyRules = InternshipCompanyRule::all();
        return response()->json(['message' => 'Success', 'data' => $companyRules]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'sequence' => 'required|integer',
            'description' => 'required|string',
        ]);

        $companyRule = InternshipCompanyRule::create($data);

        return response()->json(['message' => 'Internship Company Rules created successfully', 'data' => $companyRule]);
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

        $companyRule->update($data);

        return response()->json(['message' => 'Internship Company Rules updated successfully', 'data' => $companyRule]);
    }

    public function destroy($id)
    {
        $companyRule = InternshipCompanyRule::find($id);

        if (!$companyRule) {
            return response()->json(['message' => 'Internship Company Rules not found'], 404);
        }

        $companyRule->delete();

        return response()->json(['message' => 'Internship Company Rules deleted successfully']);
    }
}
