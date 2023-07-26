<?php

namespace App\Http\Controllers;

use App\Models\SchoolAdvisor;
use Illuminate\Http\Request;

class SchoolAdvisorController extends Controller
{
    public function index()
    {
        $schoolAdvisors = SchoolAdvisor::all();
        return response()->json(['message' => 'Success', 'data' => $schoolAdvisors]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'identity' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'is_active' => 'required|boolean',
            'user_id' => 'integer|exists:users,id',
            'password_hint' => 'nullable|string|max:255',
        ]);

        $schoolAdvisor = SchoolAdvisor::create($data);

        return response()->json(['message' => 'School Advisor created successfully', 'data' => $schoolAdvisor]);
    }

    public function show($id)
    {
        $schoolAdvisor = SchoolAdvisor::find($id);

        if (!$schoolAdvisor) {
            return response()->json(['message' => 'School Advisor not found'], 404);
        }

        return response()->json(['message' => 'Success', 'data' => $schoolAdvisor]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'identity' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'is_active' => 'required|boolean',
            'user_id' => 'integer|exists:users,id',
            'password_hint' => 'nullable|string|max:255',
        ]);

        $schoolAdvisor = SchoolAdvisor::find($id);

        if (!$schoolAdvisor) {
            return response()->json(['message' => 'School Advisor not found'], 404);
        }

        $schoolAdvisor->update($data);

        return response()->json(['message' => 'School Advisor updated successfully', 'data' => $schoolAdvisor]);
    }

    public function destroy($id)
    {
        $schoolAdvisor = SchoolAdvisor::find($id);

        if (!$schoolAdvisor) {
            return response()->json(['message' => 'School Advisor not found'], 404);
        }

        $schoolAdvisor->delete();

        return response()->json(['message' => 'School Advisor deleted successfully']);
    }
}
