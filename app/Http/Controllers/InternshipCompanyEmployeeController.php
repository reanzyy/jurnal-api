<?php

namespace App\Http\Controllers;

use App\Models\InternshipCompanyEmployee;
use Illuminate\Http\Request;

class InternshipCompanyEmployeeController extends Controller
{
    public function index()
    {
        $employees = InternshipCompanyEmployee::with('internship', 'jobTitle')->get();
        return response()->json(["error" => false, "message" => "success", "data" => $employees]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "job_title_id" => "required|integer|exists:internship_company_job_titles,id",
            "name" => "required|string|max:255",
        ]);

        if (auth()->check()) {
            auth()->user()->id;
            $employee = InternshipCompanyEmployee::create($data);

            return response()->json(["error" => false, "message" => "Employee created successfully", "data" => $employee]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $employee = InternshipCompanyEmployee::find($id);

        if (!$employee) {
            return response()->json(["error" => true, "message" => "Employee not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $employee]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "job_title_id" => "integer|exists:internship_company_job_titles,id",
            "name" => "string|max:255",
        ]);

        $employee = InternshipCompanyEmployee::find($id);

        if (!$employee) {
            return response()->json(["error" => true, "message" => "Employee not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $employee->update($data);

            return response()->json(["error" => false, "message" => "Employee updated successfully", "data" => $employee]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $employee = InternshipCompanyEmployee::find($id);

        if (!$employee) {
            return response()->json(["error" => true, "message" => "Employee not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $employee->delete();

            return response()->json(["error" => false, "message" => "Employee deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
