<?php

namespace App\Http\Controllers;

use App\Models\InternshipSuggestion;
use Illuminate\Http\Request;

class InternshipSuggestionController extends Controller
{
    public function index()
    {
        $suggestions = InternshipSuggestion::with('internship', 'companyEmployee', 'approvalUser')->get();
        return response()->json(["error" => false, "message" => "success", "data" => $suggestions]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "company_employee_id" => "required|integer|exists:internship_company_employees,id",
            "suggest" => "required|string",
            "approval_user_id" => "nullable|integer|exists:users,id",
            "approval_by" => "required|string",
            "approval_at" => "nullable|timestamp",
        ]);

        if (auth()->check()) {
            auth()->user()->id;
            $suggestion = InternshipSuggestion::create($data);

            return response()->json(["error" => false, "message" => "Suggestion created successfully", "data" => $suggestion]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $suggestion = InternshipSuggestion::find($id);

        if (!$suggestion) {
            return response()->json(["error" => true, "message" => "Suggestion not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $suggestion]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "company_employee_id" => "integer|exists:internship_company_employees,id",
            "suggest" => "string",
            "approval_user_id" => "nullable|integer|exists:users,id",
            "approval_by" => "string",
            "approval_at" => "nullable|timestamp",
        ]);

        $suggestion = InternshipSuggestion::find($id);

        if (!$suggestion) {
            return response()->json(["error" => true, "message" => "Suggestion not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $suggestion->update($data);

            return response()->json(["error" => false, "message" => "Suggestion updated successfully", "data" => $suggestion]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $suggestion = InternshipSuggestion::find($id);

        if (!$suggestion) {
            return response()->json(["error" => true, "message" => "Suggestion not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $suggestion->delete();

            return response()->json(["error" => false, "message" => "Suggestion deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
