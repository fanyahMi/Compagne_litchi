<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Log;

class ShiftController extends Controller
{
    // Afficher la liste des shifts
    public function index(){
        return view('shift.Shift');
    }

    // Récupérer tous les shifts
    public function getShifts() {
        $shifts = Shift::all();
        return response()->json($shifts);
    }

    // Ajouter un nouveau shift
    public function addShift(Request $request) {
        $validator = Validator::make($request->all(),[
            'description' => 'required|string|max:255',
            'debut' => 'required|date_format:H:i', // Validation du format HH:MM
            'fin' => 'required|date_format:H:i|after:debut', // Validation du format HH:MM et fin après début
        ], [
            'debut.required' => 'L\'heure de début est obligatoire.',
            'fin.required' => 'L\'heure de fin est obligatoire.',
            'debut.date_format' => 'Le format de l\'heure de début doit être HH:MM.',
            'fin.date_format' => 'Le format de l\'heure de fin doit être HH:MM.',
            'fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            Shift::create([
                'description' => $validatedData['description'],
                'debut' => $validatedData['debut'],
                'fin' => $validatedData['fin'],
            ]);
            return response()->json(['message' => 'Shift ajouté avec succès'], 200);
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'ajout du shift: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors de l\'ajout du shift: ' . $e->getMessage()], 400);
        }
    }

    // Récupérer un shift par ID
    public function getById($id) {
        try {
            $shift = Shift::findOrFail($id);
            $shift->debut = date('H:i', strtotime($shift->debut));
            $shift->fin = date('H:i', strtotime($shift->fin));
            return response()->json($shift);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération du shift: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 404);
        }
    }

    // Mettre à jour un shift
    public function update(Request $request) {
        $validator = Validator::make($request->all(),[
            'id_shift' => 'required|integer|exists:shift,id_shift',
            'description' => 'required|string|max:255',
            'debut' => 'required|date_format:H:i', // Validation du format HH:MM
            'fin' => 'required|date_format:H:i|after:debut', // Validation du format HH:MM et fin après début
        ], [
            'id_shift.required' => 'L\'ID du shift est obligatoire.',
            'debut.required' => 'L\'heure de début est obligatoire.',
            'fin.required' => 'L\'heure de fin est obligatoire.',
            'debut.date_format' => 'Le format de l\'heure de début doit être HH:MM.',
            'fin.date_format' => 'Le format de l\'heure de fin doit être HH:MM.',
            'fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422); // Code d'erreur 422 : Unprocessable Entity
        }
        try {
            $shift = Shift::findOrFail($validatedData['id_shift']);
            $shift->update([
                'description' => $validatedData['description'],
                'debut' => $validatedData['debut'],
                'fin' => $validatedData['fin'],
            ]);

            return response()->json(['status' => 'success', 'message' => 'Shift mis à jour avec succès!', 'shift' => $shift]);
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du shift: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    // Supprimer un shift
    public function destroy($id) {
        try {
            $shift = Shift::findOrFail($id);
            $shift->delete();
            return response()->json(['status' => 'success', 'message' => 'Shift supprimé avec succès!']);
        } catch (Exception $e) {
            Log::error('Erreur lors de la suppression du shift: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Erreur lors de la suppression du shift'], 400);
        }
    }
}
