<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $company = Company::all();
        return response()->json(['error' => false, 'message' => 'success', 'data' => $company]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'identity' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'user_id' => 'integer|exists:users,id',
            'password_hint' => 'nullable|string|max:255',
        ]);

        $company = Company::create($data);

        return response()->json(['error' => false, 'message' => 'Company created successfully', 'data' => $company]);
    }

    public function show($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => true, 'message' => 'Companyy not found'], 404);
        }

        return response()->json(['error' => false, 'message' => 'success', 'data' => $company]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'company_id' => 'integer|exists:companies,id',
            'identity' => 'string|max:255',
            'name' => 'string|max:255',
            'phone' => 'string|max:255',
            'gender' => 'in:male,female',
            'user_id' => 'integer|exists:users,id',
            'password_hint' => 'nullable|string|max:255',
        ]);

        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => true, 'message' => 'Company not found'], 404);
        }

        $company->update($data);

        return response()->json(['error' => false, 'message' => 'Company updated successfully', 'data' => $company]);
    }

    public function destroy($id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['error' => true, 'message' => 'Company not found'], 404);
        }

        $company->delete();

        return response()->json(['error' => false, 'message' => 'Company deleted successfully']);
    }
}

