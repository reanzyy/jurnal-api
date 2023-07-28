<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Models\InternshipJournal;

class InternshipJournalController extends Controller
{
    public function index()
    {
        $journals = InternshipJournal::with('internship', 'competency', 'approvalUser')->get();
        return response()->json(["error" => false, "message" => "success", "data" => $journals]);
    }


    public function store(Request $request)
    {
        if (auth()->check()) {
            $validatedData = $request->validate([
                "internship_id" => 'required',
                "date" => 'required|date',
                "activity" => 'required',
                "competency_id" => 'required',
                "approval_user_id" => "integer|exists:users,id",
                "approval_by" => "nullable|string|max:255",
                "approval_at" => "nullable|timestamp",
            ]);

            // Create a new InternshipJournal model with the validated data
            $journal = new InternshipJournal($validatedData);

            // Associate the journal with the related Internship model
            $internship = Internship::find($validatedData['internship_id']);
            $internship->journals()->save($journal);

            return response()->json(['message' => 'Jurnal added successfully.']);
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }


    public function show($id)
    {
        $journal = InternshipJournal::find($id);

        if (!$journal) {
            return response()->json(["error" => true, "message" => "Journal not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $journal]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "date" => "date",
            "activity" => "string|max:255",
            "competency_id" => "integer|exists:internship_competencies,id",
            "approval_user_id" => "integer|exists:users,id",
            "approval_by" => "nullable|string|max:255",
            "approval_at" => "nullable|timestamp",
        ]);

        $journal = InternshipJournal::find($id);

        if (!$journal) {
            return response()->json(["error" => true, "message" => "Journal not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $journal->update($data);

            return response()->json(["error" => false, "message" => "Journal updated successfully", "data" => $journal]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroy($id)
    {
        $journal = InternshipJournal::find($id);

        if (!$journal) {
            return response()->json(["error" => true, "message" => "Journal not found"], 404);
        }

        if (auth()->check()) {
            auth()->user()->id;
            $journal->delete();

            return response()->json(["error" => false, "message" => "Journal deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
