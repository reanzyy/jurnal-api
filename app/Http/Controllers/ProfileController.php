<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class ProfileController extends Controller
{
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
                    'phone' => 'nullable|string|max:20',
                    'birth_date' => 'required',
                    'birth_place' => 'required',
                    'religion' => 'required',
                    'gender' => 'required',
                    'address' => 'nullable|string|max:255',
                    'blood_type' => 'required',
                ]);

                if ($images = $request->hasFile("photo")) {
                    $images = time() . '.' . $request->photo->extension();
                    $request->photo->move(public_path("images"), $images);
                } else {
                    $images = $student->photo;
                }

                $student->photo = $images;
                $student->update($validatedData);
                $student->save();

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

                // Retrieve the first schoolYear model from the collection
                $schoolYear = $internship->schoolYear->first();

                $filteredStudent = [
                    'id' => $internship->id,
                    'nis' => $internship->student->identity,
                    'school_year_id' => $schoolYear->name, // Access the 'name' property of the specific schoolYear model
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

    public function upload(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('student');

            if ($user->relationLoaded('student')) {
                $student = $user->student;

                // Validate the incoming request data
                $validatedData = $request->validate([
                    'photo' => 'nullable|image|max:2048', // Allow only image files (jpeg, png, jpg, gif) with a maximum size of 2MB (2048KB)
                ]);

                if ($request->hasFile('photo')) {
                    $image = $request->file('photo');
                    $fileName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $fileName);

                    // Update the student's profile with the new photo path
                    $student->photo = 'images/' . $fileName;
                    $student->save();
                }

                return response()->json(['message' => 'Profile updated successfully.']);
            } else {
                return response()->json(['message' => 'Student relationship not loaded.']);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    // public function updateImage(Request $request)
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json(['message' => 'User not authenticated.'], 401);
    //     }

    //     $student = $user->student;

    //     if (!$student) {
    //         return response()->json(['message' => 'Student not found.'], 404);
    //     }

    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow only image files (jpeg, png, jpg, gif) with a maximum size of 2MB (2048KB)
    //     ]);

    //     if ($request->hasFile('photo')) {
    //         $image = $request->file('photo');
    //         $fileName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('images'), $fileName);

    //         // Delete the old image if it exists
    //         if ($student->photo) {
    //             $oldImagePath = public_path($student->photo);
    //             if (File::exists($oldImagePath)) {
    //                 File::delete($oldImagePath);
    //             }
    //         }

    //         // Update the student's profile with the new photo path
    //         $student->photo = 'images/' . $fileName;
    //         $student->save();
    //     }

    //     return response()->json(['message' => 'Profile updated successfully.']);
    // }
}
