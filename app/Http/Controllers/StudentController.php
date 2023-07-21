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
        $students = Student::latest()->get();
        return response()->json([
            "data" => $students,
        ]);
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
            'nis' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'region' => 'required',
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

        $user = auth()->user();

        $student = $user->students()->create([
            'nis' => $request->nis,
            'name' => $request->name,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'region' => $request->region,
            'gender' => $request->gender,
            'photo' => $request->photo,
            'address' => $request->address,
            'blood_type' => $request->blood_type,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_address' => $request->parent_address,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json([
            "message" => 'Data siswa berhasil ditambahkan',
            "data" => $student
        ]);
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
        return response()->json([
            'message' => 'Data berhasil ditampilkan',
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
            'nis' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'region' => 'required',
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

        $student->nis = $request->nis;
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->birth_date = $request->birth_date;
        $student->birth_place = $request->birth_place;
        $student->region = $request->region;
        $student->gender = $request->gender;
        $student->photo = $request->photo;
        $student->address = $request->address;
        $student->blood_type = $request->blood_type;
        $student->parent_name = $request->parent_name;
        $student->parent_phone = $request->parent_phone;
        $student->parent_address = $request->parent_address;
        $student->save();

        // $student = Student::where('id', $id)->update([
        //     'nis' => $request->nis,
        //     'name' => $request->name,
        //     'phone' => $request->phone,
        //     'birth_date' => $request->birth_date,
        //     'birth_place' => $request->birth_place,
        //     'region' => $request->region,
        //     'gender' => $request->gender,
        //     'photo' => $request->photo,
        //     'address' => $request->address,
        //     'blood_type' => $request->blood_type,
        //     'parent_name' => $request->parent_name,
        //     'parent_phone' => $request->parent_phone,
        //     'parent_address' => $request->parent_address,
        // ]);

        return response()->json([
            "message" => 'Data siswa berhasil diupdate',
            "data" => $student
        ]);
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

        $student->delete();

        return response()->json([
            "message" => 'Data siswa berhasil dihapus',
            "data" => $student
        ]);
    }
}