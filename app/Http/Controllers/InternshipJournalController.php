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
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $journals = InternshipJournal::with('internship', 'competency', 'approvalUser')
                    ->select("internship_journals.*")
                    ->join("internships", "internships.id", "=", "internship_journals.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredJournals = [];

                foreach ($journals as $journal) {
                    $filteredJournals[] = [
                        "id" => $journal->id,
                        "status" => $journal->status,
                        "date" => $journal->date,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredJournals]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function store(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user()->load('internship');

            // $internship = $user->internship->load('journals');   

            $validatedData = $request->validate([
                "internship_id" => 'required',
                "date" => 'required|date',
                "activity_image" => 'required',
                "activity" => 'required',
                "competency_id" => 'required',
                "approval_user_id" => "integer|exists:users,id",
                "approval_by" => "nullable|string|max:255",
                "approval_at" => "nullable|timestamp",
            ]);

            if ($images = $request->hasFile("activity_image")) {
                $images = time() . '.' . $request->activity_image->extension();
                $request->activity_image->move(public_path("images"), $images);
            } else {
                unset($validatedData['activity_image']);
            }

            $journal = new InternshipJournal($validatedData);

            // Pastikan Anda mengatur activity_image sebelum menyimpan jurnal
            $journal->activity_image = $images;
            $journal->save();

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

        $filteredJournals = [
            "id" => $journal->id,
            "activity_image" => $journal->activity_image,
            "activity" => $journal->activity,
            "approval_by" => $journal->approval_by,
        ];

        return response()->json(["error" => false, "message" => "success", "data" => $filteredJournals]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "integer|exists:internships,id",
            "date" => "date",
            "activity" => "string|max:255",
            "activity_image" => "image",
            "competency_id" => "integer|exists:internship_competencies,id",
            "approval_user_id" => "integer|exists:users,id",
            "approval_by" => "nullable|string|max:255",
            "approval_at" => "nullable|timestamp",
        ]);

        $journal = InternshipJournal::find($id);

        $images = null;

        if ($images = $request->hasFile("activity_image")) {
            $images = time() . '.' . $request->activity_image->extension();
            $request->activity_image->move(public_path("images"), $images);
        } else {
            $images = $journal->activity_image;
        }

        $journal->activity_image = $images;
        $journal->save();

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
