<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InternshipJournal;
use Carbon\Carbon;

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
        $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'date' => 'required|date',
            'activity' => 'required|string|max:255',
            'competency_id' => 'required|integer|exists:internship_competencies,id',
            'activity_image' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',
            'approval_user_id' => 'integer|exists:users,id',
            'approval_by' => 'nullable|string|max:255',
            'approval_at' => 'nullable|timestamp',
        ]);


        if ($request->hasFile('activity_image')) {
            $image = $request->file('activity_image');
            $imageName = time() . '.' . $request->activity_image->extension();
            $image->move(public_path('images'), $imageName);

            $journal = InternshipJournal::create([
                'internship_id' => $request->internship_id,
                'date' => $request->date,
                'activity' => $request->activity,
                'competency_id' => $request->competency_id,
                'activity_image' => $imageName,
                'approval_user_id' => $request->approval_user_id,
                'approval_by' => $request->approval_by,
                'approval_at' => $request->approval_at,
            ]);

            $filteredJournals = [
                'id' => $journal->id,
                'internship_id' => $journal->internship_id,
                'date' => $journal->date,
                'activity' => $journal->activity,
                'competency_id' => $journal->competency_id,
                'activity_image' => $journal->activity_image,
            ];
        } else {
            return response()->json(['message' => 'No image uploaded'], 400);
        }

        return response()->json(['error' => false, 'message' => 'Journal created successfully', 'data' => $filteredJournals]);
    }

    public function show($id)
    {
        $journal = InternshipJournal::with('competency')->find($id);

        if (!$journal) {
            return response()->json(["error" => true, "message" => "Journal not found"], 404);
        }

        $filteredJournals = [
            "id" => $journal->id,
            "activity_image" => $journal->activity_image,
            "activity" => $journal->activity,
            "competency" => $journal->competency->competency,
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
            auth()->user();

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

    public function journalsCount()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        $user = auth()->user();
        $startDate = Carbon::now()->subDays(66);
        $endDate = Carbon::now();

        $journalsCount = InternshipJournal::join('internships', 'internships.id', '=', 'internship_journals.internship_id')
            ->where('status', 'Approved')
            ->where('internships.user_id', $user->id)
            ->whereBetween('internship_journals.created_at', [$startDate, $endDate])
            ->count();

        $targetCount = 66;
        $journalsNeeded = max(0, $targetCount - $journalsCount);

        return response()->json([
            'journals' => $journalsCount,
            'journals_needed' => $journalsNeeded
        ]);
    }



    public function generateDownloadLink()
    {
        $downloadLink = url('/journal/preview');

        return response()->json(['link' => $downloadLink]);
    }

    public function downloadJournals()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        $user = auth()->user();
        $journals = $user->internshipJournals;

        $pdf = PDF::loadView('pdf.journals', ['journals' => $journals]);

        $filename = 'internship_journals.pdf';
        $pdf->save(public_path('pdfs/' . $filename));

        return response()->download(public_path('pdfs/' . $filename));
    }
}