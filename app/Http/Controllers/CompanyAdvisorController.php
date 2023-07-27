<?php

namespace App\Http\Controllers;

use App\Models\CompanyAdvisor;
use Illuminate\Http\Request;

class CompanyAdvisorController extends Controller
{
    public function index()
    {
        $companyAdvisors = CompanyAdvisor::with('company', 'user')->get();
        return response()->json(["error" => false, "message" => "success", "data" => $companyAdvisors]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "company_id" => "required|integer|exists:companies,id",
            "identity" => "required|string|max:255",
            "name" => "required|string|max:255",
            "phone" => "required|string|max:255",
            "gender" => "required|in:male,female",
            "user_id" => "integer|exists:users,id",
            "password_hint" => "nullable|string|max:255",
        ]);
        if (auth()->check()) {
            auth()->user()->id;

            $companyAdvisor = CompanyAdvisor::create($data);

            return response()->json(["error" => false, "message" => "Company advisor created successfully", "data" => $companyAdvisor]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $companyAdvisor = CompanyAdvisor::find($id);

        if (!$companyAdvisor) {
            return response()->json(["error" => true, "message" => "Company advisor not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $companyAdvisor]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "company_id" => "integer|exists:companies,id",
            "identity" => "string|max:255",
            "name" => "string|max:255",
            "phone" => "string|max:255",
            "gender" => "in:male,female",
            "user_id" => "integer|exists:users,id",
            "password_hint" => "nullable|string|max:255",
        ]);

        $companyAdvisor = CompanyAdvisor::find($id);

        if (!$companyAdvisor) {
            return response()->json(["error" => true, "message" => "Company advisor not found"], 404);
        }
        if (auth()->check()) {
            auth()->user()->id;
            $companyAdvisor->update($data);

            return response()->json(["error" => false, "message" => "Company advisor updated successfully", "data" => $companyAdvisor]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $companyAdvisor = CompanyAdvisor::find($id);

        if (!$companyAdvisor) {
            return response()->json(["error" => true, "message" => "Company advisor not found"], 404);
        }
        if (auth()->check()) {
            auth()->user()->id;
            $companyAdvisor->delete();

            return response()->json(["error" => false, "message" => "Company advisor deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
