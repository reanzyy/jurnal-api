<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::all();
        return response()->json(['error' => false, 'message' => 'success', 'data' => $internships]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_year_id' => 'required|integer|exists:school_years,id',
            'student_id' => 'required|integer|exists:students,id',
            'company_id' => 'required|integer|exists:companies,id',
            'school_advisor_id' => 'required|integer|exists:school_advisors,id',
            'company_advisor_id' => 'integer|exists:company_advisors,id',
            'working_day' => 'required|in:mon-fri,mon-sat',
        ]);

        $internship = Internship::create($data);

        return response()->json(['error' => false, 'message' => 'Internship created successfully', 'data' => $internship]);
    }

    public function show($id)
    {
        $internship = Internship::find($id);

        if (!$internship) {
            return response()->json(['error' => true, 'message' => 'Internship not found'], 404);
        }

        return response()->json(['error' => false, 'message' => 'success', 'data' => $internship]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'school_year_id' => 'integer|exists:school_years,id',
            'student_id' => 'integer|exists:students,id',
            'company_id' => 'integer|exists:companies,id',
            'school_advisor_id' => 'integer|exists:school_advisors,id',
            'company_advisor_id' => 'integer|exists:company_advisors,id',
            'working_day' => 'in:mon-fri,mon-sat',
        ]);

        $internship = Internship::find($id);

        if (!$internship) {
            return response()->json(['error' => true, 'message' => 'Internship not found'], 404);
        }

        $internship->update($data);

        return response()->json(['error' => false, 'message' => 'Internship updated successfully', 'data' => $internship]);
    }

    public function destroy($id)
    {
        $internship = Internship::find($id);

        if (!$internship) {
            return response()->json(['error' => true, 'message' => 'Internship not found'], 404);
        }

        $internship->delete();

        return response()->json(['error' => false, 'message' => 'Internship deleted successfully']);
    }
}

