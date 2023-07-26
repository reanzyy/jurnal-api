<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompany;
use Illuminate\Http\Request;

class InternshipCompanyController extends Controller
{
    public function index()
    {
        $internship_company = InternshipCompany::all();
        return response()->json(['message' => 'Success', 'data' => $internship_company]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer',
            'since' => 'required|string',
            'sectors' => 'array',
            'services' => 'array',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string',
            'email' => 'nullable|string',
            'website' => 'nullable|string',
            'director' => 'nullable|string',
            'director_phone' => 'nullable|string',
            'advisors' => 'nullable|string',
            'structure' => 'nullable|string',
        ]);

        $internship_company = InternshipCompany::create($data);

        return response()->json(['message' => 'Company created successfully', 'data' => $internship_company]);
    }

    public function show($id)
    {
        $internship_company = InternshipCompany::find($id);

        if (!$internship_company) {
            return response()->json(['message' => 'Internship Company not found'], 404);
        }
        return response()->json(['message' => 'Success', 'data' => $internship_company]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'internship_id' => 'integer',
            'since' => 'string',
            'sectors' => 'array',
            'services' => 'array',
            'address' => 'nullable|string',
            'telephone' => 'nullable|string',
            'email' => 'nullable|string',
            'website' => 'nullable|string',
            'director' => 'nullable|string',
            'director_phone' => 'nullable|string',
            'advisors' => 'nullable|string',
            'structure' => 'nullable|string',
        ]);

        $internship_company = InternshipCompany::find($id);
        if (!$internship_company) {
            return response()->json(['message' => 'Internship Company not found'], 404);
        }
        $internship_company->update($data);
        return response()->json(['message' => 'Internship Company updated successfully', 'data' => $internship_company]);
    }

    public function destroy($id)
    {
        $internship_company = InternshipCompany::find($id);

        if (!$internship_company) {
            return response()->json(['message' => 'Internship Company not found'], 404);
        }

        $internship_company->delete();

        return response()->json(['message' => 'Internship Company deleted successfully']);
    }
}