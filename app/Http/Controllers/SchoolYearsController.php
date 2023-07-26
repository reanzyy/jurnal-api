<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolYearsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school_years = SchoolYear::latest()->get();

        if ($school_years->isEmpty()) {
            return response()->json([
                "error" => false,
                "message" => "Belum ada data",
                "data" => null
            ]);
        } else {
            return response()->json([
                "error" => false,
                "message" => "Success",
                "data" => $school_years,
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
            'headmaster_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (auth()->check()) {
            auth()->user()->id;

            $school_years = SchoolYear::create([
                'name' => $request->name,
                'headmaster_name' => $request->headmaster_name,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $school_years
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
            'headmaster_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $school_years = SchoolYear::find($id);

        if (!$school_years) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $school_years->update([
                'name' => $request->name,
                'headmaster_name' => $request->headmaster_name,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $school_years
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
        $school_years = SchoolYear::find($id);

        if (!$school_years) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $school_years->delete();

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $school_years
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
            ]);
        }
    }
}
