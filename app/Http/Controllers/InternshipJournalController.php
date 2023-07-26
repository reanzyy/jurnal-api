<?php

namespace App\Http\Controllers;

use App\Models\InternshipJournal;
use Illuminate\Http\Request;

class InternshipJournalController extends Controller
{
    public function index()
    {
        $journals = InternshipJournal::all();
        return response()->json(['error' => false, 'message' => 'success', 'data' => $journals]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'date' => 'required|date',
            'activity' => 'required|string|max:255',
            'competency_id' => 'required|integer|exists:internship_competencies,id',
            'approval_user_id' => 'integer|exists:users,id',
            'approval_by' => 'nullable|string|max:255',
            'approval_at' => 'nullable|timestamp',
        ]);

        $journal = InternshipJournal::create($data);

        return response()->json(['error' => false, 'message' => 'Journal created successfully', 'data' => $journal]);
    }

    public function show($id)
    {
        $journal = InternshipJournal::find($id);

        if (!$journal) {
            return response()->json(['error' => true, 'message' => 'Journal not found'], 404);
        }

        return response()->json(['error' => false, 'message' => 'success', 'data' => $journal]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'internship_id' => 'integer|exists:internships,id',
            'date' => 'date',
            'activity' => 'string|max:255',
            'competency_id' => 'integer|exists:internship_competencies,id',
            'approval_user_id' => 'integer|exists:users,id',
            'approval_by' => 'nullable|string|max:255',
            'approval_at' => 'nullable|timestamp',
        ]);

        $journal = InternshipJournal::find($id);

        if (!$journal) {
            return response()->json(['error' => true, 'message' => 'Journal not found'], 404);
        }

        $journal->update($data);

        return response()->json(['error' => false, 'message' => 'Journal updated successfully', 'data' => $journal]);
    }

    public function destroy($id)
    {
        $journal = InternshipJournal::find($id);

        if (!$journal) {
            return response()->json(['error' => true, 'message' => 'Journal not found'], 404);
        }

        $journal->delete();

        return response()->json(['error' => false, 'message' => 'Journal deleted successfully']);
    }
}
