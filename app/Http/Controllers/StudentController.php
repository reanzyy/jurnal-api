<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $students = Student::with("classroom", "schoolYear")->latest()->get();

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
            "identity" => "required",
            "name" => "required",
            "phone" => "required",
            "birth_date" => "required",
            "birth_place" => "required",
            "religion" => "required",
            "gender" => "required",
            "photo" => "required",
            "address" => "required",
            "blood_type" => "required",
            "parent_name" => "required",
            "parent_phone" => "required",
            "parent_address" => "required",
            "school_year_id" => "required",
            "classroom_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (auth()->check()) {
            $user = auth()->user()->id;

            $student = Student::create([
                "identity" => $request->identity,
                "name" => $request->name,
                "phone" => $request->phone,
                "birth_date" => $request->birth_date,
                "birth_place" => $request->birth_place,
                "religion" => $request->religion,
                "gender" => $request->gender,
                "photo" => $request->photo,
                "address" => $request->address,
                "blood_type" => $request->blood_type,
                "parent_name" => $request->parent_name,
                "parent_phone" => $request->parent_phone,
                "parent_address" => $request->parent_address,
                "school_year_id" => $request->school_year_id,
                "classroom_id" => $request->classroom_id,
                "user_id" => $user,
            ]);

            return response()->json([
                "error" => false,
                "message" => "Student created successfully",
                "data" => $student
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
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
            return response()->json(["error" => true, "message" => "Student not found"], 404);
        }

        return response()->json([
            "error" => false,
            "message" => "Success",
            "data" => $student
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
            "identity" => "required",
            "name" => "required",
            "phone" => "required",
            "birth_date" => "required",
            "birth_place" => "required",
            "religion" => "required",
            "gender" => "required",
            "photo" => "required",
            "address" => "required",
            "blood_type" => "required",
            "parent_name" => "required",
            "parent_phone" => "required",
            "parent_address" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $student = Student::find($id);

        if (!$student) {
            return response()->json(["error" => true, "message" => "Student not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student->update([
                "identity" => $request->identity,
                "name" => $request->name,
                "phone" => $request->phone,
                "birth_date" => $request->birth_date,
                "birth_place" => $request->birth_place,
                "religion" => $request->religion,
                "gender" => $request->gender,
                "photo" => $request->photo,
                "address" => $request->address,
                "blood_type" => $request->blood_type,
                "parent_name" => $request->parent_name,
                "parent_phone" => $request->parent_phone,
                "parent_address" => $request->parent_address,
                "school_year_id" => $request->school_year_id,
                "classroom_id" => $request->classroom_id,
            ]);

            return response()->json([
                "error" => false,
                "message" => "Student updated successfully",
                "data" => $student
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
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
            return response()->json(["error" => true, "message" => "Student not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student->delete();

            return response()->json([
                "error" => false,
                "message" => "Student deleted successfully",
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
            ]);
        }
    }

    public function profile()
    {
        if (auth()->check()) {

            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student')) {

                $student = $user->student;

                return response()->json($student);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function profile_personal()
    {
        if (auth()->check()) {

            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student')) {

                $student = $user->student;

                $filteredStudent = [
                    'id' => $student->id,
                    'identity' => $student->identity,
                    'name' => $student->name,
                    'phone' => $student->phone,
                    'birth_date' => $student->birth_date,
                    'birth_place' => $student->birth_place,
                    'religion' => $student->religion,
                    'gender' => $student->gender,
                    'address' => $student->address,
                    'photo' => $student->photo,
                    'blood_type' => $student->blood_type,
                ];

                return response()->json($filteredStudent);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function update_profile_personal(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student')) {
                $student = $user->student;

                // Validate the incoming request data
                $validatedData = $request->validate([
                    'identity' => 'required',
                    'name' => 'required',
                    'phone' => 'required',
                    'birth_date' => 'required',
                    'birth_place' => 'required',
                    'religion' => 'required',
                    'gender' => 'required',
                    'address' => 'required',
                    'photo' => 'required',
                    'blood_type' => 'required',
                    'phone' => 'nullable|string|max:20',
                    'address' => 'nullable|string|max:255',
                    'photo' => 'nullable|string|max:255',
                    // Add more validation rules for other fields if needed
                ]);

                // Update the student's profile with the validated data
                $student->update($validatedData);

                return response()->json(['message' => 'Profile updated successfully.']);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function profile_parent()
    {
        if (auth()->check()) {

            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student')) {

                $student = $user->student;

                $filteredStudent = [
                    'id' => $student->id,
                    'parent_name' => $student->parent_name,
                    'parent_phone' => $student->parent_phone,
                    'parent_address' => $student->parent_address,
                ];

                return response()->json($filteredStudent);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function update_profile_parent(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student')) {
                $student = $user->student;

                // Validate the incoming request data
                $validatedData = $request->validate([
                    "parent_name" => 'required',
                    "parent_phone" => 'required',
                    "parent_address" => 'required',
                    // Add more validation rules for other fields if needed
                ]);

                // Update the student's profile with the validated data
                $student->update($validatedData);

                return response()->json(['message' => 'Profile updated successfully.']);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function update_profile_schedule_internship(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('internship');

            if ($user->relationLoaded('internship')) {
                $internship = $user->internship;

                // Validate the incoming request data
                $validatedData = $request->validate([
                    "working_day" => "required|in:mon-fri,mon-sat",
                ]);

                // Update the internship's profile with the validated data
                $internship->update($validatedData);

                return response()->json(['message' => 'Profile updated successfully.']);
            } else {
                return response()->json(['message' => 'Internship relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }


    public function profile_schedule()
    {
        if (auth()->check()) {
            $user = auth()->user()->load('internship', 'student');

            if ($user->relationLoaded('internship', 'student')) {
                $internship = $user->internship;

                $student = $internship->student->load('classroom');

                $filteredStudent = [
                    'id' => $internship->id,
                    'nis' => $internship->student->identity,
                    'school_year_id' => $internship->schoolYear->name,
                    'classroom' => $student->classroom->name,
                    'vocational_program' => $student->classroom->vocational_program,
                    'vocational_competency' => $student->classroom->vocational_competency,
                    'working_day' => $internship->working_day,
                ];

                return response()->json($filteredStudent);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }
}
