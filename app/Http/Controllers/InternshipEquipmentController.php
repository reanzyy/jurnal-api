<?php

namespace App\Http\Controllers;

use App\Models\InternshipEquipment;
use Illuminate\Http\Request;

class InternshipEquipmentController extends Controller
{
    public function getEquipment()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user) {
                $equipments = InternshipEquipment::select("internship_equipments.*", "internships.user_id")
                    ->join("internships", "internships.id", "=", "internship_equipments.internship_id")
                    ->where("internships.user_id", $user->id)
                    ->get();

                $filteredEquipment = [];
                foreach ($equipments as $equipment) {

                    $filteredEquipment[] = [
                        "id" => $equipment->id,
                        "tool" => $equipment->tool,
                        "specification" => $equipment->specification,
                        "utility" => $equipment->utility,
                    ];
                }

                return response()->json(["error" => false, "message" => "success", "data" => $filteredEquipment]);
            } else {
                return response()->json(['message' => 'User not authenticated.'], 401);
            }
        } else {
            return response()->json(['message' => 'User not authenticated.'], 401);
        }
    }

    public function storeEquipment(Request $request)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "tool" => "required|string|max:255",
            "specification" => "required|string|max:255",
            "utility" => "required|string",
        ]);

        if (auth()->check()) {
            auth()->user();
            $equipment = InternshipEquipment::create($data);

            return response()->json(["error" => false, "message" => "Journal created successfully", "data" => $equipment]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(["error" => true, "message" => "Equipment not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $equipment]);
    }

    public function updateEquipment(Request $request, $id)
    {
        $data = $request->validate([
            "internship_id" => "required|integer|exists:internships,id",
            "tool" => "required|string|max:255",
            "specification" => "required|string|max:255",
            "utility" => "required|string",
        ]);

        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(["error" => true, "message" => "Equipment not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $equipment->update($data);

            return response()->json(["error" => false, "message" => "Equipment updated successfully", "data" => $equipment]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function destroyEquipment($id)
    {
        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(["error" => true, "message" => "Equipment not found"], 404);
        }

        if (auth()->check()) {
            auth()->user();
            $equipment->delete();

            return response()->json(["error" => false, "message" => "Equipment deleted successfully"]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }
}
