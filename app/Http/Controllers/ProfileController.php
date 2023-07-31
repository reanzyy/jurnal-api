<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function profile()
    {
        if (auth()->check()) {

            $user = auth()->user()->load('student');

            if (!$user) {
                return response()->json(["error" => true, "message" => "User not found"], 404);
            }

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

            if ($user->relationLoaded('student') && $user->student !== null) {
                $student = $user->student;

                $filteredStudent = [
                    'id' => $student->id,
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
                return response()->json(['message' => 'Student record not found.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }


    public function update_profile_personal(Request $request)
    {
        $request->validate([
            'identity' => 'required',
            'name' => 'required',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'religion' => 'required',
            'gender' => 'required',
            'address' => 'nullable|string|max:255',
            'blood_type' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);


        if (auth()->check()) {

            $user = Student::where('user_id', auth()->user()->id)->first();

            $user->identity = $request->identity;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->birth_date = $request->birth_date;
            $user->birth_place = $request->birth_place;
            $user->religion = $request->religion;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->blood_type = $request->blood_type;

            if ($request->photo && $request->photo->isValid()) {
                $fileName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path("images"), $fileName);
                $path = "public/images/$fileName";
                $user->photo = $path;
            }
            $user->update();

            $filteredStudent = [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'birth_date' => $user->birth_date,
                'birth_place' => $user->birth_place,
                'religion' => $user->religion,
                'gender' => $user->gender,
                'address' => $user->address,
                'photo' => $user->photo,
                'blood_type' => $user->blood_type,
            ];

            if (!$user) {
                return response()->json(["message" => "Student record not found."], 404);
            }

            return response()->json(["message" => "Profile updated successfully", "data" => $filteredStudent]);
        } else {
            return response()->json(["message" => "User not authenticated"], 404);
        }
    }


    public function profile_parent()
    {
        if (auth()->check()) {
            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student') && $user->student !== null) {
                $student = $user->student;

                $filteredStudent = [
                    'id' => $student->id,
                    'parent_name' => $student->parent_name,
                    'parent_phone' => $student->parent_phone,
                    'parent_address' => $student->parent_address,
                ];

                return response()->json($filteredStudent);
            } else {
                return response()->json(['message' => 'Student record not found.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function update_profile_parent(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student') && $user->student !== null) {
                $student = $user->student;

                $validatedData = $request->validate([
                    'parent_name' => 'required',
                    'parent_phone' => 'required',
                    'parent_address' => 'required',
                ]);

                $student->update($validatedData);

                $filteredStudent = [
                    'id' => $student->id,
                    'parent_name' => $student->parent_name,
                    'parent_phone' => $student->parent_phone,
                    'parent_address' => $student->parent_address,
                ];

                return response()->json(['message' => 'Profile updated successfully.', "data" => $filteredStudent]);
            } else {
                return response()->json(['message' => 'Student record not found.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }


    public function update_profile_schedule_internship(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('internship');

            if ($user->relationLoaded('internship') && $user->internship !== null) {
                $internship = $user->internship;

                $validatedData = $request->validate([
                    "working_day" => "required|in:mon-fri,mon-sat",
                ]);

                $internship->update($validatedData);
                $filteredStudent = [
                    'id' => $internship->id,
                    'working_day' => $internship->working_day,
                ];

                return response()->json(['message' => 'Profile updated successfully.', 'data' => $filteredStudent]);
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

            if ($user->relationLoaded('internship') && $user->internship !== null) {
                $internship = $user->internship;

                $student = $internship->student->load('classroom');

                $schoolYear = $internship->schoolYear->first();

                $filteredStudent = [
                    'id' => $internship->id,
                    'nis' => $internship->student->identity,
                    'school_year_id' => $schoolYear->name,
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

    public function uploadPhoto(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student') && $user->student !== null) {
                $student = $user->student;

                $validatedData = $request->validate([
                    'photo' => 'nullable|image|max:2048',
                ]);

                if ($request->hasFile('photo')) {
                    $image = $request->file('photo');
                    $fileName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $fileName);

                    $student->photo = 'images/' . $fileName;
                    $student->save();
                }

                return response()->json(['message' => 'Profile updated successfully.']);
            } else {
                return response()->json(['message' => 'Student record not found.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }
}
