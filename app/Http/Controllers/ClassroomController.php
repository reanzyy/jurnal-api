<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::with('schoolYear')->latest()->get();

        if ($classrooms->isEmpty()) {
            return response()->json([
                "error" => false,
                "message" => "Belum ada data kelas",
                "data" => $classrooms
            ]);
        } else {
            return response()->json([
                "error" => false,
                "message" => "Success",
                "data" => $classrooms
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
            'name' => 'required',
            'vocational_program' => 'required',
            'vocational_competency' => 'required',
            'school_year_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (auth()->check()) {
            auth()->user()->id;

            $classrooms = Classroom::create([
                'name' => $request->name,
                'vocational_program' => $request->vocational_program,
                'vocational_competency' => $request->vocational_competency,
                'school_year_id' => $request->school_year_id,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $classrooms
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
        //
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
            'name' => 'required',
            'vocational_program' => 'required',
            'vocational_competency' => 'required',
            'school_year_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $classrooms = Classroom::find($id);

        if (!$classrooms) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $classrooms->update([
                'name' => $request->name,
                'vocational_program' => $request->vocational_program,
                'vocational_competency' => $request->vocational_competency,
                'school_year_id' => $request->school_year_id,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $classrooms
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
        $classrooms = Classroom::find($id);

        if (!$classrooms) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $classrooms->delete();

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $classrooms
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
            ]);
        }
    }
}
