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
    public function addShift(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:255',
            'debut' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i',
        ], [
            'description.required' => 'La description est obligatoire.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne peut pas dépasser 255 caractères.',
            'debut.required' => 'L\'heure de début est obligatoire.',
            'debut.date_format' => 'Le format de l\'heure de début doit être HH:MM.',
            'fin.required' => 'L\'heure de fin est obligatoire.',
            'fin.date_format' => 'Le format de l\'heure de fin doit être HH:MM.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $validatedData = $validator->validated();

            Shift::create([
                'description' => $validatedData['description'],
                'debut' => $validatedData['debut'],
                'fin' => $validatedData['fin'],
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Shift ajouté avec succès.',
            ], 201);
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'ajout du shift: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'error' => 'Erreur lors de l\'ajout du shift: ' . $e->getMessage(),
            ], 500);
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_shift' => 'required|integer|exists:shift,id_shift',
            'description' => 'required|string|max:255',
            'debut' => 'required|date_format:H:i',
            'fin' => 'required|date_format:H:i|after:debut',
        ], [
            'id_shift.required' => 'L\'ID du shift est obligatoire.',
            'id_shift.exists' => 'Le shift avec cet ID n\'existe pas.',
            'debut.required' => 'L\'heure de début est obligatoire.',
            'debut.date_format' => 'Le format de l\'heure de début doit être HH:MM.',
            'fin.required' => 'L\'heure de fin est obligatoire.',
            'fin.date_format' => 'Le format de l\'heure de fin doit être HH:MM.',
            'fin.after' => 'L\'heure de fin doit être après l\'heure de début.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $validatedData = $validator->validated();

            $shift = Shift::findOrFail($validatedData['id_shift']);

            $shift->update([
                'description' => $validatedData['description'],
                'debut' => $validatedData['debut'],
                'fin' => $validatedData['fin'],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Shift mis à jour avec succès!',
                'shift' => $shift,
            ], 200); // Code 200 : OK
        } catch (Exception $e) {
            Log::error('Erreur lors de la mise à jour du shift: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la mise à jour du shift: ' . $e->getMessage(),
            ], 400); // Code 400 : Bad Request
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

    public function getShiftEnCours()
    {
        $currentShift = DB::table('shift')
            ->where(function ($query) {
                // Shifts dans la même journée
                $query->whereRaw('CURRENT_TIME >= debut AND CURRENT_TIME <= fin');
            })
            ->orWhere(function ($query) {
                // Shifts traversant minuit
                $query->whereRaw('debut > fin AND (CURRENT_TIME >= debut OR CURRENT_TIME <= fin)');
            })
            ->first();

        if (!$currentShift) {
            return response()->json(['error' => 'Aucun shift actif actuellement'], 404);
        }

        return response()->json($currentShift);
    }
}
