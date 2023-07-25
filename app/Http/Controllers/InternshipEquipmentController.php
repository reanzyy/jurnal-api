<?php

namespace App\Http\Controllers;

use App\Models\InternshipEquipment;
use Illuminate\Http\Request;

class InternshipEquipmentController extends Controller
{
    public function index()
    {
        $equipments = InternshipEquipment::all();
        return response()->json(['error' => false, 'message' => 'success', 'data' => $equipments]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'tool' => 'required|string|mas:255',
            'specification' => 'required|string|max:255',
            'utility' => 'required|string',
        ]);

        $equipment = InternshipEquipment::create($data);

        return response()->json(['error' => false, 'message' => 'Journal created successfully', 'data' => $equipment]);
    }

    public function show($id)
    {
        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(['error' => true, 'message' => 'Equipment not found'], 404);
        }

        return response()->json(['error' => false, 'message' => 'success', 'data' => $equipment]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'internship_id' => 'required|integer|exists:internships,id',
            'tool' => 'required|string|mas:255',
            'specification' => 'required|string|max:255',
            'utility' => 'required|string',
        ]);

        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(['error' => true, 'message' => 'Equipment not found'], 404);
        }

        $equipment->update($data);

        return response()->json(['error' => false, 'message' => 'Equipment updated successfully', 'data' => $equipment]);
    }

    public function destroy($id)
    {
        $equipment = InternshipEquipment::find($id);

        if (!$equipment) {
            return response()->json(['error' => true, 'message' => 'Equipment not found'], 404);
        }

        $equipment->delete();

        return response()->json(['error' => false, 'message' => 'Equipment deleted successfully']);
    }
}

