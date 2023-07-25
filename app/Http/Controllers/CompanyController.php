<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::all();
        return response()->json(['message' => 'Success', 'data' => $company]);
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

        $company = Company::create($data);

        return response()->json(['message' => 'Company created successfully', 'data' => $company]);
    }

    public function show($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Internship Company not found'], 404);
        }
        return response()->json(['message' => 'Success', 'data' => $company]);
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

        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Internship Company not found'], 404);
        }
        $company->update($data);
        return response()->json(['message' => 'Internship Company updated successfully', 'data' => $company]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Internship Company not found'], 404);
        }

        $company->delete();

        return response()->json(['message' => 'Internship Company deleted successfully']);
    }
}
