<?php

namespace App\Http\Controllers;

use App\Models\StudentDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentDraftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student_drafts = StudentDraft::latest()->get();

        if ($student_drafts->isEmpty()) {
            return response()->json([
                "error" => false,
                "message" => "Belum ada data",
                "data" => null
            ]);
        } else {
            return response()->json([
                "error" => false,
                "message" => "Success",
                "data" => $student_drafts,
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
            "student_id" => 'required',
            "description" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student_drafts = StudentDraft::create([
                "student_id" => 'required',
                "description" => 'required',
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $student_drafts
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
        $student_draft = StudentDraft::find($id);

        if (!$student_draft) {
            return response()->json(['message' => 'Student Draft not found'], 404);
        }

        return response()->json([
            "error" => false,
            "message" => 'Success',
            'data' => $student_draft
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
            "student_id" => 'required',
            "description" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $student_drafts = StudentDraft::find($id);

        if (!$student_drafts) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student_drafts->update([
                'name' => $request->name,
                'headmaster_name' => $request->headmaster_name,
            ]);

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $student_drafts
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
        $student_drafts = StudentDraft::find($id);

        if (!$student_drafts) {
            return response()->json(['message' => 'Classroom not found'], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;

            $student_drafts->delete();

            return response()->json([
                "error" => false,
                "message" => 'Success',
                "data" => $student_drafts
            ]);
        } else {
            return response()->json([
                "error" => true,
                "message" => "User not authenticated."
            ]);
        }
    }
}
