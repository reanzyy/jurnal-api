<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::latest()->get();

        if ($schools->isEmpty()) {
            return response()->json([
                "error" => false,
                "message" => "Belum ada data",
                "data" => null
            ]);
        } else {
            return response()->json([
                "error" => false,
                "message" => "Success",
                "data" => $schools,
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
            'npsn' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (auth()->check()) {
            auth()->user()->id;

            $schools = School::create([
                'name' => $request->name,
                'npsn' => $request->npsn,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $schools
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
            'npsn' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $schools = School::find($id);

        if (!$schools) {
            return response()->json(['message' => 'School not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $schools->update([
                'name' => $request->name,
                'npsn' => $request->npsn,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $schools
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
        $school = School::find($id);

        if (!$school) {
            return response()->json(['message' => 'School not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $school->delete();

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $school
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
            ]);
        }
    }
}
