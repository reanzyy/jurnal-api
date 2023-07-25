<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('classroom', 'schoolYear')->latest()->get();

        if ($students->isEmpty()) {
            return response()->json([
                "error" => false,
                "message" => "Belum ada data siswa",
                "data" => null,
            ]);
        } else {
            return response()->json([
                "error" => false,
                "message" => "Success",
                "data" => $students,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'identity' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'photo' => 'required',
            'address' => 'required',
            'blood_type' => 'required',
            'parent_name' => 'required',
            'parent_phone' => 'required',
            'parent_address' => 'required',
            'school_year_id' => 'required',
            'classroom_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (auth()->check()) {
            $user = auth()->user()->id;

            $student = Student::create([
                'identity' => $request->identity,
                'name' => $request->name,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'religion' => $request->religion,
                'gender' => $request->gender,
                'photo' => $request->photo,
                'address' => $request->address,
                'blood_type' => $request->blood_type,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'parent_address' => $request->parent_address,
                'school_year_id' => $request->school_year_id,
                'classroom_id' => $request->classroom_id,
                'user_id' => $user,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $student
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => 'User not authenticated.'
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json([
            "error" => false,
            "message" => 'Success',
            'data' => $student
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'identity' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'photo' => 'required',
            'address' => 'required',
            'blood_type' => 'required',
            'parent_name' => 'required',
            'parent_phone' => 'required',
            'parent_address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student->update([
                'identity' => $request->identity,
                'name' => $request->name,
                'phone' => $request->phone,
                'birth_date' => $request->birth_date,
                'birth_place' => $request->birth_place,
                'religion' => $request->religion,
                'gender' => $request->gender,
                'photo' => $request->photo,
                'address' => $request->address,
                'blood_type' => $request->blood_type,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
                'parent_address' => $request->parent_address,
                'school_year_id' => $request->school_year_id,
                'classroom_id' => $request->classroom_id,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $student
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => 'User not authenticated.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student->delete();

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $student
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
            ]);
        }
    }
}
