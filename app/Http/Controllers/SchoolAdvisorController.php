<?php

namespace App\Http\Controllers;

use App\Models\SchoolAdvisor;
use Illuminate\Http\Request;

class SchoolAdvisorController extends Controller
{
    public function index()
    {
        $schoolAdvisors = SchoolAdvisor::with('user')->get();
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
            'is_active' => 'boolean',
            'user_id' => 'integer|exists:users,id',
            'password_hint' => 'nullable|string|max:255',
        ]);

        if (auth()->check()) {
            auth()->user()->id;
            $schoolAdvisor = SchoolAdvisor::create($data);

            return response()->json(['message' => 'School Advisor created successfully', 'data' => $schoolAdvisor]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
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
            'is_active' => 'boolean',
            'user_id' => 'integer|exists:users,id',
            'password_hint' => 'nullable|string|max:255',
        ]);

        $schoolAdvisor = SchoolAdvisor::find($id);

        if (!$schoolAdvisor) {
            return response()->json(['message' => 'School Advisor not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $schoolAdvisor->update($data);

            return response()->json(['message' => 'School Advisor updated successfully', 'data' => $schoolAdvisor]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $schoolAdvisor = SchoolAdvisor::find($id);

        if (!$schoolAdvisor) {
            return response()->json(['message' => 'School Advisor not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $schoolAdvisor->delete();

            return response()->json(['message' => 'School Advisor deleted successfully']);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
